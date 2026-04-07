<?php

namespace App\Http\Repositories;

use DB;
use Exception;
use App\Models\Stock;
use App\Models\StockHistory;
use App\Http\Repositories\BaseRepository;

class StockRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Stock();
        $this->models = [
            'stock_history' => new StockHistory()
        ];
    }

    public function all(array $params = [])
    {
        try {
            $query = $this->model->with('product.category')
                ->with('history');
            
            if (!empty($params) && isset($params['name'])) {
                $query = $query->where('name', 'like', '%'.$params['name'].'%');
            }

            if (!empty($params) && isset($params['barcode'])) {
                $query = $query->whereHas('product', function($productQuery) use ($params) {
                    $productQuery->where('barcode', 'like', '%'.$params['barcode'].'%');
                });
            }

            return $query->paginate(5)->withQueryString();
        } catch (Exception $e) {
            return $this->error($e->getMessage(), [], $this->internalServerError);
        }
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function filter(array $params = [])
    {
        try {
            if (empty($params)) {
                return [];
            }

            // 1. Start the query
            $query = $this->model->with(['product.category']);

            // 2. Constrain the Eager Loading for 'history'
            // This ensures the returned collection only contains the filtered history items
            $query->with(['history' => function($historyQuery) use ($params) {
                if (isset($params['start_date'], $params['end_date'])) {
                    $historyQuery->whereBetween('date', [$params['start_date'], $params['end_date']]);
                }
                if (isset($params['type']) && $params['type'] !== 'all') {
                    $historyQuery->where('type', $params['type']);
                }
            }]);

            // 3. Filter the main query results (whereHas)
            // This ensures we only get parent models that actually HAVE those history records
            $query->whereHas('history', function($historyQuery) use ($params) {
                if (isset($params['start_date'], $params['end_date'])) {
                    $historyQuery->whereBetween('date', [$params['start_date'], $params['end_date']]);
                }
                if (isset($params['type']) && $params['type'] !== 'all') {
                    $historyQuery->where('type', $params['type']);
                }
            });

            // 4. Other Filters
            if (isset($params['product_id']) && $params['product_id'] !== 'all') {
                $query->where('product_id', $params['product_id']);
            }

            if (isset($params['category_id']) && $params['category_id'] !== 'all') {
                $query->whereHas('product', function($q) use ($params) {
                    $q->where('category_id', $params['category_id']);
                });
            }

            return $query->get();
        } catch (Exception $e) {
            return $this->error($e->getMessage(), [], $this->internalServerError);
        }
    }

    public function find($id)
    {
        try {
            $data = $this->model->with('product.category')->find($id);
            if ($data) {
                return $this->success($data, 'Stock found');
            }

            return $this->success(null, 'No stock product found for ID #'.$id, $this->notFound);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), [], $this->internalServerError);
        }
    }

    
    public function create($params = [])
    {
        if (!empty($params)) {
            try {
                DB::beginTransaction();
                $stockParams = [
                    'product_id' => $params['product_id'],
                    'stocked_count' => $params['stocked_count']
                ];
                $stockedExisting = $this->model->where('product_id', $params['product_id'])->first();

                if (isset($params['type']) && $stockedExisting) {
                    if ($params['type'] === 'out') {
                        $stockParams['stocked_count'] = $stockedExisting->stocked_count - abs($params['stocked_count']);
                    } else if ($params['type'] === 'in') {
                        $stockParams['stocked_count'] = $stockedExisting->stocked_count + abs($params['stocked_count']);
                    }
                } else {
                    $stockParams['stocked_count'] = abs($params['stocked_count']);
                }

                $stock = $this->model->updateOrCreate(
                    ['product_id' => $params['product_id']],
                    $stockParams
                );

                $historyParams = [
                    'stock_id' => $stock->id,
                    'count' => $params['stocked_count'],
                    'type' => $params['type'],
                    'date' => $params['date'],
                    'requestor' => $params['requestor'] ?? null,
                    'approved_by' => $params['approved_by'] ?? null,
                    'details' => $params['details'] ?? null
                ];

                $stockHistory = $this->models['stock_history']->create($historyParams);

                DB::commit();
                return $this->success($stock, 'Stock created successfully');
            } catch (Exception $e) {
                DB::rollBack(); 
                \Log::error('Error creating stock: '.$e->getMessage());
                return $this->error($e->getMessage(), [], $this->internalServerError);
            }
        }

        return $this->error('No data found', [], $this->badRequest);
    }

    
    public function update($id, $params = [])
    {
        if (isset($id))
        {
            $stock = $this->model->find($id);
            if ($stock) {
                try {
                    DB::beginTransaction();
                    $stockParams = [
                        'product_id' => $params['product_id'],
                        'stocked_count' => $params['stocked_count']
                    ];

                    $stockedHistoryExisting = $this->models['stock_history']
                        ->where('stock_id', $id)
                        ->where('id', $params['history_id'])
                        ->first();

                    if (isset($params['type']) && $stockedHistoryExisting) {
                        if ($params['type'] === 'out') {
                            if ($stockedHistoryExisting->count > $params['stocked_count']) {
                                $stockParams['stocked_count'] = $stock->stocked_count + abs($params['stocked_count']);
                            } else {
                                $stockParams['stocked_count'] = ($stock->stocked_count + $stockedHistoryExisting->count) - abs($params['stocked_count']);
                            }
                        } else if ($params['type'] === 'in') {
                            $stockParams['stocked_count'] = ($stock->stocked_count - $stockedHistoryExisting->count) + abs($params['stocked_count']);
                        }
                    } else {
                        $stockParams['stocked_count'] = abs($params['stocked_count']);
                    }

                    $stock->update($stockParams);

                    $historyParams = [
                        'stock_id' => $id,
                        'count' => $params['stocked_count'],
                        'type' => $params['type'],
                        'date' => $params['date'],
                        'requestor' => $params['requestor'] ?? null,
                        'approved_by' => $params['approved_by'] ?? null,
                        'details' => $params['details'] ?? null
                    ];

                    if (isset($params['history_id'])) {
                        $stockHistory = $this->models['stock_history']->find($params['history_id']);
                        if ($stockHistory) {
                            $stockHistory->update($historyParams);
                        } else {
                            $this->models['stock_history']->create($historyParams);
                        }
                    } else {
                        $this->models['stock_history']->create($historyParams);
                    }
                    DB::commit();
                    $updated = $this->model->find($id);
                    return $this->success($updated, 'Stock #'.$id.' is updated');
                } catch (Exception $e) {
                    DB::rollback();
                    return $this->error($e->getMessage(), [], $this->internalServerError);
                }
            }
            return $this->success(null, 'No record found for id #'.$id, $this->notFound);
        }

        return $this->error('Please provide an ID', [], $this->badRequest);
    }
    

    public function delete($historyId)
    {
        if (isset($historyId)) {
            $history = $this->models['stock_history']->find($historyId);

            if (isset($history)) {
                try {
                    DB::beginTransaction();

                    $stock = $this->model->find($history->stock_id);
                    if ($stock) {
                        $stockCount = $stock->stocked_count - ($history->type == 'in' ? $history->count : -($history->count));
                        $stock->stocked_count = $stockCount;
                        $stock->save();
                    }

                    $history->delete();
                    DB::commit();
                    return $this->success(null, 'Stock #'.$historyId.' was successfully deleted');
                } catch (Exception $e) {
                    DB::rollback();
                    return $this->error($e->getMessage(), [], $this->internalServerError);
                }
            }

            return $this->success(null, 'No record found for ID #'.$historyId, $this->notFound);
        }

        return $this->error('Please provide an ID', [], $this->badRequest);
    }
}
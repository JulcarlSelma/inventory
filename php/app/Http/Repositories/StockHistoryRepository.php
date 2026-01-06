<?php

namespace App\Http\Repositories;

use DB;
use Exception;
use App\Models\StockHistory;
use App\Repositories\BaseRepository;

class StockHistoryRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new StockHistory();
    }

    public function all($paginate = 10)
    {
        try {
            $data = $this->model->with('stock')->paginate($paginate);
            return $this->success($data, 'Data from page #'.$data->currentPage());
        } catch (Exception $e) {
            return $this->error($e->getMessage(), [], $this->internalServerError);
        }
    }

    public function find($id)
    {
        try {
            $data = $this->model->with('stock')->find($id);
            if ($data) {
                return $this->success($data, 'Stock history found');
            }

            return $this->success(null, 'No stock history found for ID #'.$id, $this->notFound);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), [], $this->internalServerError);
        }
    }

    
    public function create($params = [])
    {
        if (!empty($params)) {
            try {
                DB::beginTransaction();
                $result = $this->model->create($params);

                DB::commit();
                return $this->success($result, 'Stock history created successfully');
            } catch (Exception $e) {
                DB::rollBack(); 
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
                    $stock->update($params);
                    DB::commit();
                    $updated = $this->model->find($id);
                    return $this->success($updated, 'Stock history #'.$id.' is updated');
                } catch (Exception $e) {
                    DB::rollback();
                    return $this->error($e->getMessage(), [], $this->internalServerError);
                }
            }
            return $this->success(null, 'No record found for id #'.$id, $this->notFound);
        }

        return $this->error('Please provide an ID', [], $this->badRequest);
    }
    

    public function delete($id)
    {
        if (isset($id)) {
            $stock = $this->model->find($id);

            if (isset($stock)) {
                try {
                    DB::beginTransaction();
                    $stock->delete();
                    DB::commit();
                    return $this->success(null, 'Stock #'.$id.' was successfully deleted');
                } catch (Exception $e) {
                    DB::rollback();
                    return $this->error($e->getMessage(), [], $this->internalServerError);
                }
            }

            return $this->success(null, 'No record found for ID #'.$id, $this->notFound);
        }

        return $this->error('Please provide an ID', [], $this->badRequest);
    }
}
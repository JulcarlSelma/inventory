<?php

namespace App\Http\Repositories;

use DB;
use Exception;
use App\Models\Product;
use App\Http\Repositories\BaseRepository;

class ProductRepository extends BaseRepository {
    public function __construct()
    {
        $this->model = new Product();
    }

    public function all($paginate = 10)
    {
        try {
            $data = $this->model->with('category')->paginate($paginate);
            return $this->success($data, 'Data from page #'.$data->currentPage());
        } catch (Exception $e) {
            return $this->error($e->getMessage(), [], $this->internalServerError);
        }
    }

    public function find($id)
    {
        try {
            $product = $this->model->with('category')->find($id);
            if ($product) {
                return $this->success($product, 'Product found');
            }

            return $this->success(null, 'No product found for ID #'.$id, $this->notFound);
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
                return $this->success($result, 'Product created successfully');
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
            $product = $this->model->find($id);
            if ($product) {
                try {
                    DB::beginTransaction();
                    $product->update($params);
                    DB::commit();
                    $updated = $this->model->with('category')->find($id);
                    return $this->success($updated, 'Product #'.$id.' is updated');
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
            $product = $this->model->find($id);

            if (isset($product)) {
                try {
                    DB::beginTransaction();
                    $product->delete();
                    DB::commit();
                    return $this->success(null, 'Product #'.$id.' was successfully deleted');
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

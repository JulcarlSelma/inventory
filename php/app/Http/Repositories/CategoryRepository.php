<?php

namespace App\Http\Repositories;

use DB;
use Exception;
use App\Models\Category;
use App\Http\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Category();
    }

    public function all(array $params = [])
    {
        try {
            $query = $this->model;
            if (!empty($params) && isset($params['name'])) {
                $query = $query->where('name', 'like', '%'.$params['name'].'%');
            }
            return $query->paginate(5)->withQueryString();
        } catch (Exception $e) {
            return $this->error($e->getMessage(), [], $this->internalServerError);
        }
    }

    public function create($params = [])
    {
        if (!empty($params)) {
            try {
                DB::beginTransaction();
                $data = $this->model->create($params);
                DB::commit();
                return $this->success($data, 'Successfully created a category');
            } catch (Exception $e) {
                DB::rollback();
                return $this->error($e->getMessage(), [], $this->internalServerError);
            }
        }

        return $this->error('Field should not be empty', [], $this->badRequest);
    }

    public function update($id, $params = [])
    {
        if (isset($id)) {
            $category = $this->model->find($id);
            if (isset($category)) {
                $categoryName = $category->name;
                try {
                    DB::beginTransaction();
                    $category->update($params);

                    $updated = $this->model->find($id);
                    DB::commit();
                    return $this->success($updated, $categoryName.' was updated to '.$updated->name);
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
            $category = $this->model->find($id);
            $categoryName = $category->name;

            if (isset($category)) {
                try {
                    DB::beginTransaction();
                    $category->delete();
                    DB::commit();
                    return $this->success(null, 'Category '.$categoryName.' was successfully deleted');
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
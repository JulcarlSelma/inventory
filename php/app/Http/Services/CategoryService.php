<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\Http\Repositories\CategoryRepository;

class CategoryService extends BaseService
{
    public function __construct()
    {
        $this->repository = new CategoryRepository();
    }

    public function all(array $params = [])
    {
        return $this->repository->all($params);
    }

    public function create($params)
    {
        return $this->repository->create($params);
    }

    public function update($id, $params)
    {
        return $this->repository->update($id, $params);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
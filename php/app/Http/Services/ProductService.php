<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\Http\Repositories\ProductRepository;

class ProductService extends BaseService
{
    public function __construct()
    {
        $this->repository = new ProductRepository();
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create($params = [])
    {
        return $this->repository->create($params);
    }

    public function update($id, $params = [])
    {
        return $this->repository->update($id, $params);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}

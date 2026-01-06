<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Requests\StockRequest;
use App\Http\Service\StockService;

class StockController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new StockService();
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->service->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockRequest $request)
    {
        $params = $request->validated();
        return $this->service->create($params);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->service->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StockRequest $request, $id)
    {
        $params = $request->validated();
        return $this->service->update($id, $params);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}

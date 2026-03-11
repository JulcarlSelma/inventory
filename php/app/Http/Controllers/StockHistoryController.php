<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use App\Http\Requests\StockRequest;
use App\Http\Services\CategoryService;
use App\Http\Services\ProductService;
use App\Http\Services\StockService;

class StockHistoryController extends Controller
{
    protected $services = [];

    public function __construct()
    {
        $this->services = [
            'stock' => new StockService(),
            'category' => new CategoryService(),
            'product' => new ProductService()
        ];
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $data = $this->services['stock']->all($params);
        $dropdown = $this->services['category']->dropdown();
        $products = $this->services['product']->getProductStocks();
        $stocks = $this->services['stock']->getAll()->pluck('id')->toArray();
        return view('inventory.index', compact('data', 'dropdown', 'products', 'stocks'));
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

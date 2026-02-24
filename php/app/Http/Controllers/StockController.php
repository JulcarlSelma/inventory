<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Http\Requests\StockRequest;
use App\Http\Services\CategoryService;
use App\Http\Services\ProductService;
use App\Http\Services\StockService;

class StockController extends Controller
{
    protected $service;
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
        return view('stocks.index', compact('data', 'dropdown', 'products', 'stocks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockRequest $request)
    {
        $params = $request->validated();
        $this->services['stock']->create($params);
        return redirect()->route('stock.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->services['stock']->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StockRequest $request, $id)
    {
        $params = $request->validated();
        $this->services['stock']->update($id, $params);
        return redirect()->route('stock.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->services['stock']->delete($id);
        return redirect()->route('stock.index');
    }
}

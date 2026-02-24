<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ProductService;
use App\Http\Services\CategoryService;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    protected $service;
    protected $services = [];

    public function __construct()
    {
        $this->services = [
            'product' => new ProductService(),
            'category' => new CategoryService()
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $data = $this->services['product']->all($params);
        $dropdown = $this->services['category']->dropdown();
        return view('products.index', compact('data', 'dropdown'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $params = $request->validated();
        $this->services['product']->create($params);
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->services['product']->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $params = $request->validated();
        $this->services['product']->update($id, $params);
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->services['product']->delete($id);
        return redirect()->route('product.index');
    }
}

<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'image_path',
        'name',
        'description',
        'sku',
        'barcode',
        'serial_number',
        'price',
        'selling_price',
        'category_id'
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'product_id', 'id');
    }
}

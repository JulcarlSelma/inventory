<?php

namespace App\Models;

use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;

    protected $table = 'stocks';

    protected $fillable = [
        'product_id',
        'stocked_count',
        'stocked_date'
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function history()
    {
        return $this->belongsToMany(StockHistory::class, 'stock_id', 'id');
    }
}

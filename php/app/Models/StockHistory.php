<?php

namespace App\Models;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockHistory extends Model
{
    use SoftDeletes;

    protected $table = 'stock_history';

    protected $fillable = [
        'stock_id',
        'count',
        'out_date',
        'requestor',
        'approved_by',
        'details',
    ];

    public function stock()
    {
        return $this->hasOne(Stock::class, 'id', 'stock_id');
    }
}

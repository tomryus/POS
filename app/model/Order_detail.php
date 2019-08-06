<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\model\Order;
use App\model\Product;

class Order_detail extends Model
{
    protected $guarded = [];
    //Model relationships ke Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

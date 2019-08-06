<?php

namespace App\model;
use App\model\order_detail;
use App\model\customer;
use App\User;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function order_detail()
    {
        return $this->hasMany(Order_detail::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

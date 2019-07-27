<?php

namespace App\model;
use App\model\category;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo('App\model\Category',  'category_id', 'id');
    }
}

<?php

namespace App\model;
use App\model\category;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','description','stock','price','category_id','code','photo'];
    public function category()
    {
        return $this->belongsTo('App\model\Category',  'category_id', 'id');
    }
}

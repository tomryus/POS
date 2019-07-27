<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','description'];

    public function product()
    {
        return $this->hasMany('App\model\Product', 'category_id', 'id');
    }
}

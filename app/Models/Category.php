<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function news(){
        return $this->hasMany(NewsCategories::class,'category_id','id');
    }
}

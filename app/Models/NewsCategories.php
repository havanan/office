<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsCategories extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function news(){
        return $this->hasOne(News::class,'id','news_id')->select('name','id');
    }

    public function category_info(){
        return $this->hasOne(Category::class,'id','category_id')->select('name','id');
    }
}

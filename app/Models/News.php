<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function tags(){

        return $this->hasMany(NewsTags::class,'news_id','id')->with(['tag_info'])->select('id','tag_id','news_id');
    }

    public function categories(){
        return $this->hasMany(NewsCategories::class,'news_id','id')->with(['category_info'])->select('id','category_id','news_id');
    }

    public function author(){
        return $this->belongsTo(User::class,'author_id')->select('id','fullname');
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $guarded = ['id'];

    public function news(){
        return $this->hasMany(NewsTags::class,'tag_id','id');
    }
}

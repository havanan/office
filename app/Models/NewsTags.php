<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsTags extends Model
{
    protected $guarded = ['id'];

    public function tag_info(){

        return $this->hasOne(Tags::class,'id','tag_id')->select('name','id');

    }

}

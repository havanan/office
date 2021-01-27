<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentImage extends Model
{
    use SoftDeletes;
    protected $fillable = ['comment_id', 'image'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content', 'customer_id', 'lesson_content_id', 'status', 'parent_id', 'order_at'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class)
            ->select("id","avatar","fullname","email","mobile","social_email","gender","status");
    }

    public function images() {
        return $this->hasMany(CommentImage::class);
    }

    public function lessonContent() {
        return self::belongsTo(LessonContent::class)
            ->select('id','title','slug','content','image','video_id','lesson_id','lesson_category_id','is_trial','is_test','is_show_demo','viewer');
    }

    public function customerLikes() {
        return $this->belongsToMany(Customer::class, 'comment_likes', 'comment_id', 'customer_id')->select('id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class,'parent_id')->where('parent_id',0)->with('parent');
    }

    public function children() {
        return $this->hasMany(Comment::class, 'parent_id')->orderAt()->with(['customer', 'customerLikes']);
    }

    public function scopeOrderAt($query) {
        return $query->orderBy('order_at', 'DESC');
    }

    public function scopeCountLike($query) {
        $query->leftJoin('comment_likes', 'comments.id', '=', 'comment_likes');
    }
}

<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Base\BaseRepository;
use DB;

class CommentRepository extends BaseRepository {

    public function __construct(Comment $model) {
        $this->_model = $model;
    }

    public function getList($request) {
        $search = $request->search;
        $query =  DB::table('comments')
        ->join('lesson_contents', 'comments.lesson_content_id', '=', 'lesson_contents.id')
        ->join('lessons', 'lessons.id', '=', 'lesson_contents.lesson_id')
        ->join('courses', 'courses.id', '=', 'lessons.course_id')
        ->join('lesson_category', 'lesson_category.id', '=', 'lesson_contents.lesson_category_id')
        ->join('customers', 'customers.id', '=', 'comments.customer_id')
        ->selectRaw(
            'comments.id as comment_id, customers.fullname as customer_name, comments.content as comment_content,
             lesson_category.name as lesson_category_name, lessons.title as lesson_title,lessons.id as lesson_id,
              courses.name as course_name, comments.created_at as created_at, comments.status as status,
               lesson_contents.id as lesson_content_id, lessons.course_id,lesson_contents.slug as lesson_contents_slug,
               lessons.milestone_id,courses.slug as course_slug'
        )
        ->where(function($q) use($search) {
            $q->where('customers.fullname', 'like', '%' . $search . '%');
            $q->orWhere('comments.content', 'like', '%' . $search . '%');
            $q->orWhere('lesson_category.name', 'like', '%' . $search . '%');
            $q->orWhere('lessons.title', 'like', '%' . $search . '%');
            $q->orWhere('courses.name', 'like', '%' . $search . '%');
        });
        if($request->course) $query = $query->where('courses.id', $request->course);
        if($request->lesson) $query = $query->where('lesson_contents.lesson_id', $request->lesson);
        if($request->category) $query = $query->where('lesson_contents.lesson_category_id', $request->category);
        if($request->status) $query = $query->where('comments.status', $request->status);
        return $query->orderBy('comments.status')->orderBy('comments.created_at', 'DESC');
    }
    public function getWithChildren($request){
        $search = $request->search;
        $parent_id = $request->parent_id;
        $data = $this->_model->with(['children'])->orderBy('id','DESC')
            ->join('lesson_contents', 'comments.lesson_content_id', '=', 'lesson_contents.id')
            ->join('lessons', 'lessons.id', '=', 'lesson_contents.lesson_id')
            ->join('courses', 'courses.id', '=', 'lessons.course_id')
            ->join('lesson_category', 'lesson_category.id', '=', 'lesson_contents.lesson_category_id')
            ->join('customers', 'customers.id', '=', 'comments.customer_id');
        if ($parent_id != null) {
            $data = $data->where('comments.parent_id',$parent_id);
        }else {
            $data = $data->where('comments.parent_id',IS_PARENT);
        }

        if($request->course) $data = $data->where('courses.id', $request->course);
        if($request->lesson) $data = $data->where('lesson_contents.lesson_id', $request->lesson);
        if($request->category) $data = $data->where('lesson_contents.lesson_category_id', $request->category);
        if($request->status) $data = $data->where('comments.status', $request->status);

        if ($search != null) {
            $data = $data  ->where(function ($q) use ($search){
                $q->where('customers.fullname', 'like', '%' . $search . '%');
                $q->orWhere('comments.content', 'like', '%' . $search . '%');
                $q->orWhere('lesson_category.name', 'like', '%' . $search . '%');
                $q->orWhere('lessons.title', 'like', '%' . $search . '%');
                $q->orWhere('courses.name', 'like', '%' . $search . '%');
            });
        }
        return $data->selectRaw('comments.*,lessons.milestone_id,courses.slug as course_slug,
        lesson_contents.id as lesson_content_id,lesson_contents.slug as lesson_contents_slug,
        lesson_contents.title as lesson_contents_title,lesson_category.name as lesson_category_name,
        lessons.course_id, lessons.jp_title as lesson_jp_title,lessons.vn_title as lesson_vn_title,lessons.id as lesson_id,
        customers.fullname as customer_name,customers.avatar as customer_avatar,courses.name as course_name');
    }

    public function replyCommentByAdmin($request) {
        $content = $request->content;
        $status = $request->status;
        $id = $request->id;
        if($status !== '1')
        $this->_model->find($id)->update(['status' => COMMENT_STATUS_READ]);
        if($content) {
            $request['customer_id'] = RAKU_CUSTOMER_ID;
            $request['parent_id'] = $id;
            $request['status'] = COMMENT_STATUS_READ;
            $this->_model->create($request->all());
        }
    }

    public function getComments($lessonContentId, $parentId = 0) {
        return $this->_model->where(['lesson_content_id' => $lessonContentId, 'parent_id' => 0])->orderAt()->with(['children', 'customer', 'customerLikes']);
    }

    public function like($commentId) {
        $like = $this->_model->find($commentId)->customerLikes;
        if(!$like->contains(getUserCurrent('api')->id)) $this->_model->find($commentId)->customerLikes()->attach(getUserCurrent('api')->id);
        else $this->_model->find($commentId)->customerLikes()->detach(getUserCurrent('api')->id);
    }
}

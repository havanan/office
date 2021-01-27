<?php

namespace App\Repositories;

use App\Models\Feedback;
use App\Repositories\Base\BaseRepository;
use DB;

class FeedbackRepository extends BaseRepository {

    protected $_model;

    public function __construct(Feedback $model) {
        $this->_model = $model;
    }
    public function getList($request){
        $search = $request->search;
        $query = $this->_model->orderBy('id','DESC');
        if ($search != null) {
            $query = $query->where('email','LIKE','%'.$search.'%');
        }
        return $query;
    }
}

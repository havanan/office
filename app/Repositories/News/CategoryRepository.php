<?php

namespace App\Repositories\News;

use App\Models\Category;
use App\Repositories\Base\BaseRepository;

class CategoryRepository extends BaseRepository {

    public function __construct(Category $model) {

        $this->_model = $model;
    }

    public function getList($params) {
        $data = $this->_model->with(['news'])->orderBy('created_at', 'DESC');
        if ($params['search']){
            $data = $data->where(function ($q) use ($params){
                $q->where('name','like','%'.$params['search'].'%');
            });
        }
        $data = \paginate($data,$params['page']);
        return $data;
    }

    public function getAll(){
        return $this->_model->select('id','name')->get();
    }
    public function getActive(){
        return $this->_model->where('status',CATEGORY_STATUS_ACTIVE)->select('id','name')->get()->toArray();
    }
}

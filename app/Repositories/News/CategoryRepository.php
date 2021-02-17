<?php

namespace App\Repositories\News;

use App\Helpers\Constants;
use App\Helpers\Helpers;
use App\Models\Category;
use App\Repositories\Base\BaseRepository;
class CategoryRepository extends BaseRepository {

    public function __construct(Category $model) {

        $this->_model = $model;
    }

    public function getList($params) {
        $data = $this->_model->with(['products'])->orderBy('created_at', 'DESC');
        if ($params['search']){
            $data = $data->where(function ($q) use ($params){
                $q->where('name','like','%'.$params['search'].'%');
            });
        }
        $data = Helpers::paginate($data,$params['page']);
        return $data;
    }

    public function getAll(){
        return $this->_model->select('id','name')->get();
    }
    public function getActive(){
        return $this->_model->where('status',Constants::CATEGORY_STATUS_ACTIVE)->select('id','name')->get()->toArray();
    }
    public function getParent(){
        return $this->_model->where('status',Constants::CATEGORY_STATUS_ACTIVE)->where('parent_id',Constants::IS_PARENT)->select('id','name')->get()->toArray();
    }
}

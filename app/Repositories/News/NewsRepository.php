<?php

namespace App\Repositories\News;

use App\Models\News;
use App\Repositories\Base\BaseRepository;

class NewsRepository extends BaseRepository {

    public function __construct(News $model) {

        $this->_model = $model;
    }

    public function getList($params) {

        $data = $this->_model->with(['tags','categories','author'])
            ->orderBy('created_at', 'DESC');
        if ($params['search']){
            $data = $data->where(function ($q) use ($params){
                $q->where('title','like','%'.$params['search'].'%')
                    ->orWhere('description','like','%'.$params['search'].'%')
                    ->orWhere('content','like','%'.$params['search'].'%');
            });
        }
        if ($params['is_publish'] != null){
            $data = $data->where('is_publish',$params['is_publish']);
        }

        if ($params['categories'] != null){
            $data = $data->whereHas('categories',function ($q) use ($params){
                $q->whereIn('category_id',$params['categories']);
            });
        }
        $data = \paginate($data,$params['page']);

        return $data;
    }

    public function findById($newsId){
       
        $data = $this->_model->with(['categories','tags'])->find($newsId);

        return $data;
    }
}

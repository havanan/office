<?php

namespace App\Repositories\News;

use App\Models\Tags;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\DB;

class TagRepository extends BaseRepository {

    public function __construct(Tags $model) {

        $this->_model = $model;
    }

    public function getList($params) {
        $data = $this->_model->with(['news'])->orderBy('created_at', 'DESC');
        if ($params['search']){
            $data = $data->where(function ($q) use ($params){
                $q->where('name','like','%'.$params['search'].'%');
                $q->orWhere('slug','like','%'.$params['search'].'%');
            });
        }
        $data = \paginate($data,$params['page']);
        return $data;
    }
    public function findTag($params){
        $data = $this->_model->orderBy('created_at', 'DESC')
            ->select('id as key','name as value');

        if ($params['search'] && $params['search'] != null){
            $data = $data->where(function ($q) use ($params){
                $q->where('name','like','%'.$params['search'].'%');
                $q->orWhere('slug','like','%'.$params['search'].'%');
            });
        }
        $data = $data->get();
        return $data;
    }
}

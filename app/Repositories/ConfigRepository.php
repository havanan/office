<?php

namespace App\Repositories;

use App\Models\Config;
use App\Repositories\Base\BaseRepository;

class ConfigRepository extends BaseRepository {

    public function __construct(Config $model) {
        $this->_model = $model;
    }

    public function getList($params) {

        $data =  $this->_model->orderBy('id', 'DESC');
        if($params['search'] != null){
            $data = $data->where('key','like','%'.$params['search'].'%');
        }
        return \paginate($data,$params['page']);
    }
    public function getById($configId){
        return $this->_model->findOrFail($configId);
    }
    public function getFirstByKey($configKey){
        $data = $this->_model->where('key',$configKey)->first();
        return $data;
    }
}

<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Repositories\Base\BaseRepository;

class UserRepository extends BaseRepository {
    protected $_model;

    public function __construct(User $user) {
        $this->_model = $user;
    }
    public function getNotifications() {
        return $this->_model->find(\getUserCurrent()->id)->notifications();
    }
    public function getList($params) {
        $data = $this->_model->orderBy('created_at', 'DESC');
        if ($params['search']){
            $data = $data->where(function ($q) use ($params){
                $q->where('fullname','like','%'.$params['search'].'%')
                    ->orWhere('email','like','%'.$params['search'].'%')
                    ->orWhere('mobile','like','%'.$params['search'].'%');
            });
        }
        $data = \paginate($data,$params['page']);
        return $data;
    }
}

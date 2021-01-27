<?php

namespace App\Repositories\Customer;

use App\Models\Customer;
use App\Models\CustomerToken;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Hash;

class CustomerRepository extends BaseRepository {

    public function __construct(Customer $model,CustomerToken $ctm_token) {

        $this->_model = $model;
        $this->_ctm_token = $ctm_token;
    }

    public function getList($params) {
        $data = $this->_model->orderBy('created_at', 'DESC');
        if ($params['search']){
            $data = $data->where(function ($q) use ($params){
                $q->where('fullname','like','%'.$params['search'].'%')
                    ->orWhere('email','like','%'.$params['search'].'%')
                    ->orWhere('id','like','%'.$params['search'].'%')
                    ->orWhere('mobile','like','%'.$params['search'].'%');
            });
        }

        $data = \paginate($data,$params['page']);
        return $data;
    }
    public function saveToken($token,$memberId)
    {
        $customerToken =  $this->_ctm_token->firstOrNew([
            'customer_id' => $memberId
        ]);
        $customerToken->token = $token;

        return  $customerToken->save();
    }
    public function create($params){
        if(!isset($params['password'])){
            return [];
        }
        $params['password'] = Hash::make($params['password']);
        unset($params['password_confirmation']);
        return $this->_model->create($params);
    }
    public function checkStatus($email){
        $info = $this->_model->where('email',$email)->first();
        if ($info) {
            if ($info->status == CUSTOMER_ACTIVE || $info->is_verified == CUSTOMER_ACTIVE) {
                return true;
            }
        }
        return false;
    }
    public function findBySocialId($socialId){
        return $this->_model->where('social_id',$socialId)->first();
    }
    public function getTesterIds(){
        $result = [];
        $check = $this->_model->where('is_tester',IS_TESTER)->count();
        if ($check > 0) {
            $result = $this->_model->where('is_tester',IS_TESTER)->pluck('id')->toArray();
        }
        return $result;
    }
}

<?php

namespace App\Services\Customer;

use App\Repositories\Customer\CustomerRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerService {
  private $model;

  public function __construct(CustomerRepository $model) {
    $this->model = $model;
  }
  public function getList($request = false) {
    $search = $request->search ?? '';
    $page   = $request->page ?? CURRENT_PAGE;
    $params = [
        'search' => $search,
        'page'   => $page
    ];
    return $this->model->getList($params);
  }

  public function delete($customerId){
      return $this->model->delete($customerId);
  }

  public function create($params){
      $this->model->create($params);
      return $this->getList();
  }

  public function update($customerId,$params){
      $this->model->updateById($customerId,$params);
      return $this->getList();
  }
  public function getLineInfo($params) {
      $socialId = $params['userId'];
     $info = $this->model->findBySocialId($socialId);
     $imageLine = isset($params['pictureUrl']) ? $params['pictureUrl'] : null;
     if ($info && $info->avatar == null && $imageLine != null ) {
         $info->avatar = $this->base64ToImage($imageLine,$params['userId']);
         $info->save();
     }
     if (!$info) {
         $input = [
             'social_id' => $params['userId'],
             'social_email' => isset($params['email']) ? $params['email'] : null,
             'avatar' => $imageLine != null ? $this->base64ToImage($imageLine,$params['userId']) : null,
             'fullname' => $params['displayName'],
             'password' => Hash::make($params['userId']),
             'is_verified' => VERIFIED,
             'status' => VERIFIED
         ];
         $info = $this->model->create($input);
     }
     return $info;
  }

  public function profile($params) {
      $id = $params['id'];
      unset($params['id']);
      $this->model->updateById($id, $params);
      return \resSuccess();
  }
  public function base64ToImage($img,$image_name) {
      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace(' ', '+', $img);
      $data = base64_decode($img);
      $image_name = $image_name ? $image_name : 'avatar';
      $image_name .= '.png';
      $path = storage_path().'/app/public/avatar/';
//      Storage::disk($path)->put($image_name, $data);
      file_put_contents($path.$image_name,$data);
      return $image_name;
  }
  public function updateByField($params){
      $id = $params->id;
      $info = $this->model->find($id);
      return $this->model->updateById($id,[
          'is_tester' => !$info->is_tester
      ]);
  }
}


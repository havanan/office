<?php

namespace App\Services;

use App\Repositories\ConfigRepository;

class ConfigService {
  private $model;

  public function __construct(ConfigRepository $model) {
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

      $this->model->delete($customerId);

      return  $this->getList();
  }

  public function create($params){

      $this->model->create($params);

      return $this->getList();

  }

    public function update($customerId,$params){
        $this->model->updateById($customerId,$params);

        return $this->getList();
    }

    public function getById($configId){
      return $this->model->getById($configId);
    }
    public function getFirstByKey($configKey){
        $data = $this->model->getFirstByKey($configKey);
        return $data->json;
    }
}


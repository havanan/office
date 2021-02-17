<?php

namespace App\Services\News;


use App\Helpers\Constants;
use App\Repositories\News\CategoryRepository;

class CategoryService {
  private $model;

  public function __construct(CategoryRepository $model) {
    $this->model = $model;
  }

  public function getList($request = false) {

      $search = $request->search ?? '';
      $page   = $request->page ?? Constants::CURRENT_PAGE;

      $params = [
          'search' => $search,
          'page'   => $page
      ];

      return $this->model->getList($params);
  }

  public function getAll(){

      return $this->model->getAll();

  }
  public function getActive(){

      return $this->model->getActive();

  }
  public function getParent(){
      return $this->model->getParent();
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
}


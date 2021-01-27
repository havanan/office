<?php

namespace App\Services;

use App\Repositories\FeedbackRepository;

class FeedbackService {
  private $_repo;

  public function __construct(FeedbackRepository $repo) {
    $this->_repo = $repo;
  }

  public function create($array) {
    $this->_repo->create($array);
    return resSuccess();
  }
  public function changeStatus($id){
      $info = $this->_repo->find($id);
      $status = 1;
      if ($info->status == ACTIVE ) {
        $status = 0;
      }
      $this->_repo->updateById($id,['status'=> $status]);
      return resSuccess();
  }
    public function getList($request) {
        $currentPage = $request->page ?? CURRENT_PAGE;
        $query = $this->_repo->getList($request);
        return \paginate($query, $currentPage);
    }
}

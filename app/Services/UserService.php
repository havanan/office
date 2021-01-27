<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\NotificationUserRepository;
use Illuminate\Http\Request;

class UserService {
  private $_repo;
  private $_notify;

  public function __construct(UserRepository $repo, NotificationUserRepository $notify) {
    $this->_repo = $repo;
    $this->_notify = $notify;
  }

    public function getList($request = false) {

        $search = $request->search ?? '';
        $page   = $request->page ?? CURRENT_PAGE;
        $params = [
            'search' => $search,
            'page'   => $page
        ];
        return resSuccessData($this->_repo->getList($params));
    }

  public function getNotifications($page, $perPage) {
    $perPage = $perPage ?? PER_PAGE;
    $page = $page ?? CURRENT_PAGE;
//    $query = $this->_repo->getNotifications();
    $array = \paginate($this->_repo->getNotifications(), $page, $perPage);
    $array['unread'] = $this->_notify->countUnread();
    return resSuccessData($array);
  }

  public function readNotification($id, $status) {
    $ids[] = $id;
    if($id < 0) {
      $ids = $this->_repo->find(\getUserCurrent()->id)->notifications()->pluck('notification_user.id');
    }
    $this->_notify->read($ids, $status);
    return \resSuccess();
  }
    public function delete($customerId){
        $this->_repo->delete($customerId);
        return  $this->getList();
    }
    public function update($customerId,$params){
        $this->_repo->updateById($customerId,$params);
        return $this->getList();
    }
    public function create($params){
        $this->_repo->create($params);
        return $this->getList();
    }
}


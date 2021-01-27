<?php

namespace App\Services;

use App\Repositories\CommentRepository;
use App\Repositories\Customer\CustomerRepository;
use App\Repositories\UserRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\Lesson\ContentRepository;
use MRedis;


class CommentService {
  private $_repo;
  private $_notify;
  private $_customer;
  private $_user;
  private $_lessonContent;

  public function __construct(CommentRepository $repo, NotificationRepository $notify, CustomerRepository $customer, UserRepository $user, ContentRepository $lessonContent) {
    $this->_repo = $repo;
    $this->_notify = $notify;
    $this->_customer = $customer;
    $this->_user = $user;
    $this->_lessonContent = $lessonContent;
  }

  public function getList($request) {
    $currentPage = $request->page ?? CURRENT_PAGE;
    $query = $this->_repo->getList($request);
    return \paginate($query, $currentPage);
  }
  public function getParentList($request){
      $currentPage = $request->page ?? CURRENT_PAGE;
      $parent = $this->_repo->getWithChildren($request);
      return \paginate($parent, $currentPage);
  }

  public function replyCommentByAdmin($request) {
    $this->_repo->replyCommentByAdmin($request);
    return \resSuccess();
  }

  public function destroy($id) {
    $this->_repo->delete($id);
    return \resSuccess();
  }

  public function create($request) {
    $this->_repo->create($request->all());
    return $this->getList($request);
  }

  public function addNotify($customerId) {
    $customer = $this->_customer->find($customerId)->fullname;
    $id = $this->_notify->createGetID(['content' => 'Tài khoản <b>' . $customer . '</b> đã bình luận', 'type' => 'comment']);
    $notify = $this->_notify->find($id);
    $notify->users()->attach($customerId);
    $notifies = $this->_user->find($customerId)->notifications();
    return paginate($notifies, 1);
  }

  public function getComments($request) {
    $parentId = $request->parentId ?? 0;
    $lessonContent = $this->_lessonContent->getContentBySlug($request->slug);
    if(!$lessonContent) return resFail();
    $data = $this->_repo->getComments($lessonContent->id, $parentId);
    $page = $parentId == 0 ? ($request->page ?? 1) : -1;
    return \resSuccessData(\paginate($data, $page));
  }

  public function like($commentId) {
    $this->_repo->like($commentId);
    return \resSuccess();
  }

  public function reply($request) {
    $params = $request->all();
    $params['customer_id'] = getuserCurrent('api')->id;
    $params['order_at'] = getMilliseconds();
    if($request->parent_id > 0)
      $this->_repo->updateById($request->parent_id, ['order_at' => \getMilliseconds()]);
    $id = $this->_repo->createGetID($params);
    $data = $this->getList($request);
    MRedis::publish(REDIS_COMMENT_CHANNEL, json_encode($data));
    // $notifies = $this->addNotify(getuserCurrent('api')->id);
    // MRedis::publish(REDIS_NOTIFY_CHANNEL, json_encode($notifies));
    return \resSuccessData(['id' => $id]);
  }

  public function updateStatus($id, $status) {
    $this->_repo->updateById($id, ['status' => $status]);
  }
}


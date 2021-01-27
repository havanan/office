<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $_service;

    public function __construct(UserService $service) {
        $this->_service = $service;
    }

    /**
     *
     * @author  Minhpt
     * @since 2020-14-07
     * @todo Hiển thị Danh sách user
     *
     */
    public function index() {
        return view('admin.users.index');
    }
    public function getList(Request $request){
        return $this->_service->getList($request);
    }
    public function getNotifications(Request $request) {
        return $this->_service->getNotifications($request->page, $request->perPage);
    }

    public function readNotification(Request $request) {
        return $this->_service->readNotification($request->n, $request->s);
    }

    public function notifications() {
        return view('admin.users.notification');
    }
    /**
     * @author  Anhv
     * @since 2020-15-07
     * @todo Tạo mới thông tin tài khoản
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function store(CreateRequest $request)
    {
        $params = $request->all();
        $params['password'] = Hash::make('raku123456');
        $create = $this->_service->create($params);
        if ($create){
            return $create;
        }
        return \resFail();
    }
    /**
     * @author  Anhv
     * @since 2020-15-07
     * @todo Cập nhật thông tin tài khoản
     *
     * @param UpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        $params = $request->all();
        $update = $this->_service->update($id,$params);
        if ($update){
            return $update;
        }
        return \resFail();
    }

    /**
     * @author  Anhv
     * @since 2020-17-07
     * @todo Xóa tài khoản
     */
    public function destroy($id)
    {
        return $this->_service->delete($id);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Config\CreateRequest;
use App\Services\ConfigService;

class ConfigController extends Controller
{
    protected $_service;
    public function __construct(ConfigService $service)
    {
        $this->_service = $service;
    }

    /**
     *
     * @author  Anhv
     * @since 2020-15-07
     * @todo Hiển thị danh sách cài đặt
     * @return Màn hình danh sách
     *
     */
    public function index()
    {
        return  view('admin.config.index');
    }

    /**
     * @author  Anhv
     * @since 2020-15-07
     * @todo Tạo mới thông tin cài đặt
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function store(CreateRequest $request)
    {
        $params = $request->all();
        $create = $this->_service->create($params);
        if ($create){
            return \resSuccessData($create);
        }
        return \resFail();
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * @author  Anhv
     * @since 2020-15-07
     * @todo Cập nhật thông tin cài đặt
     * @param UpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CreateRequest $request, $id)
    {
        $params = $request->all();
        $update = $this->_service->update($id,$params);
        if ($update){
            return \resSuccessData($update);
        }
        return \resFail();
    }

    /**
     * @author  Anhv
     * @since 2020-17-07
     * @todo Xóa cài đặt
     */
    public function destroy($id)
    {
        $data = $this->_service->delete($id);
        return \resSuccessData($data);
    }

    /**
     *
     * @author  Anhv
     * @since 2020-15-07
     * @todo Lấy danh sách cài đặt
     * @return Mảng danh sách cài đặt.
     *
     */
    public function getList(Request $request)
    {
        $data = $this->_service->getList($request);
        return \resSuccessData($data);
    }
}

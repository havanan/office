<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CreateRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Services\Customer\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    protected $_service;
    public function __construct(CustomerService $service)
    {
        $this->_service = $service;
    }

    /**
     *
     * @author  Anhv
     * @since 2020-15-07
     * @todo Hiển thị danh sách khách hàng
     * @return Màn hình danh sách
     *
     */
    public function index()
    {
        return  view('admin.customer.index');
    }

    /**
     * @author  Anhv
     * @since 2020-15-07
     * @todo Tạo mới thông tin khách hàng
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function store(CreateRequest $request)
    {
        $params = $request->all();
        $params['password'] = Hash::make('raku123456');

        $create = $this->_service->create($params);

        if ($create){

            return \resSuccessData($create);

        }

        return \resFail();
    }
    /**
     * Show the form for editing the specified resource.
     *
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
     * @todo Cập nhật thông tin khách hàng
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

            return \resSuccessData($update);

        }

        return \resFail();
    }
    public function updateByField(Request $request){
        $update = $this->_service->updateByField($request);
        if ($update){
            return \resSuccessData($update);
        }
        return \resFail();
    }

    /**
     * @author  Anhv
     * @since 2020-17-07
     * @todo Xóa khách hàng
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
     * @todo Lấy danh sách khách hàng
     * @return object
     *
     */
    public function getList(Request $request){
        $data = $this->_service->getList($request);
        return \resSuccessData($data);
    }
}

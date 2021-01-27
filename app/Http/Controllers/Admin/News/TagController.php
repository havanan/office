<?php

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\Controller;
use App\Http\Requests\News\CreateTagRequest;
use App\Http\Requests\News\UpdateTagRequest;
use App\Services\News\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    protected $_service;

    public function __construct(TagService $service)
    {
        $this->_service = $service;
    }

    /**
     *
     * @author  Anhv
     * @since 2020-31-07
     * @todo Hiển thị danh sách thẻ tag tức
     * @return Màn hình danh sách
     *
     */
    public function index(){
        return  view('admin.tag.index');
    }

    /**
     *
     * @param Request $request
     * @return JsonResponse
     * @todo Lấy danh sách thẻ tag
     * @author  Anhv
     * @since 2020-31-07
     */
    public function getList(Request $request){

        $data = $this->_service->getList($request);

        return \resSuccessData($data);
    }
    /**
     *
     * @param Request $request
     * @return JsonResponse
     * @todo Tìm thẻ tag theo tên or slug
     * @author  Anhv
     * @since 2020-31-07
     */
    public function find(Request $request){

        $data = $this->_service->findTag($request);

        return \resSuccessData($data);
    }
    /**
     *
     * @param CreateTagRequest $request
     * @return JsonResponse
     * @todo Tạo danh sách thẻ tag
     * @author  Anhv
     * @since 2020-31-07
     */
    public function store(CreateTagRequest $request){

        $params = [
            'name'   => $request->get('name'),
            'slug'   => Str::slug($request->get('name')),
            // 'status' => $request->get('status') ? (string) $request->get('status') : CATEGORY_STATUS_ACTIVE
        ];

        $create = $this->_service->create($params);

        if ($create){

            return \resSuccessData($create);

        }

        return \resFail();
    }

    /**
     * @param UpdateTagRequest $request
     * @param int $id
     * @return JsonResponse
     * @author  Anhv
     * @since 2020-31-07
     * @todo Cập nhật thông tin thẻ tag
     *
     */
    public function update(UpdateTagRequest $request, $id)
    {
        $params = [
            'name'   => $request->get('name'),
            // 'status' => $request->get('status') ? (string) $request->get('status') : CATEGORY_STATUS_ACTIVE
        ];

        $update = $this->_service->update($id,$params);

        if ($update){

            return \resSuccessData($update);

        }

        return \resFail();
    }

    /**
     * @author  Anhv
     * @since 2020-31-07
     * @todo Xóa thẻ tag
     */
    public function destroy($id)
    {

        $data = $this->_service->delete($id);

        return \resSuccessData($data);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Http\Requests\News\CreateCategoryRequest;
use App\Http\Requests\News\UpdateCategoryRequest;
use App\Services\Product\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected $_service;

    public function __construct(CategoryService $service)
    {
        $this->_service = $service;
    }

    /**
     * @since 2020-29-07
     * @todo Hiển thị danh sách loại tin tức
     * @author  Anhv
     */
    public function index(){
        $categories  = $this->_service->getParent();
        return  view('admin.category.index',compact('categories'));
    }

    /**
     *
     * @param Request $request
     * @return JsonResponse
     * @todo Lấy danh sách loại tin
     * @author  Anhv
     * @since 2020-15-07
     */
    public function getList(Request $request){
        $data = $this->_service->getList($request);
        return  Responses::resSuccessData($data);
    }

    /**
     *
     * @param CreateCategoryRequest $request
     * @return JsonResponse
     * @todo Tạo danh sách loại tin
     * @author  Anhv
     * @since 2020-31-07
     */
    public function store(CreateCategoryRequest $request){
        $params = [
            'name'   => $request->get('name'),
            'parent_id'   => $request->get('parent_id'),
            'slug' => Str::slug($request->get('name')),
            'status' => (string) $request->get('status')
        ];
        $create = $this->_service->create($params);
        if ($create){
            return Responses::resSuccessData($create);
        }
        return Responses::resFail();
    }

    /**
     * @param UpdateCategoryRequest $request
     * @param int $id
     * @return JsonResponse
     * @author  Anhv
     * @since 2020-31-07
     * @todo Cập nhật thông tin loại tin
     *
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $params = [
            'name'   => $request->get('name'),
            'parent_id'   => $request->get('parent_id'),
            'slug' => Str::slug($request->get('name')),
            'status' => (string) $request->get('status')
        ];
        $update = $this->_service->update($id,$params);
        if ($update){
            return Responses::resSuccessData($update);
        }
        return Responses::resFail();
    }

    /**
     * @author  Anhv
     * @since 2020-31-07
     * @todo Xóa loại tin
     */
    public function destroy($id)
    {
        $data = $this->_service->delete($id);
        return Responses::resSuccessData($data);
    }
}

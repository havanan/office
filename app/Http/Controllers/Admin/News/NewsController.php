<?php

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\Controller;
use App\Http\Requests\News\CreateNewsRequest;
use App\Http\Requests\News\UpdateNewsRequest;
use App\Services\News\CategoryService;
use App\Services\News\NewsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $_service;
    protected $_category_service;
    public function __construct(NewsService $service, CategoryService $categoryService)
    {
        $this->_service = $service;
        $this->_category_service = $categoryService;
    }

    /**
     *
     * @author  Anhv
     * @since 2020-31-07
     * @todo Hiển thị danh sách tin tức
     * @return Màn hình danh sách
     *
     */
    public function index(){
        $categories = $this->_category_service->getActive();
        $categories = json_encode($categories);
        return  view('admin.news.index',compact('categories'));
    }

    /**
     *
     * @author  Anhv
     * @since 2020-31-07
     * @todo Tạo tin tức
     * @return Màn hình tạo mới
     *
     */
    public function create(){
        $categories = $this->_category_service->getActive();
        return  view('admin.news.create',compact('categories'));
    }
    /**
     *
     * @param Request $request
     * @return JsonResponse
     * @todo Lấy danh sách tin tức
     * @author  Anhv
     * @since 2020-31-07
     */
    public function getList(Request $request){

        $data = $this->_service->getList($request);

        return \resSuccessData($data);
    }

    /**
     *
     * @param CreateNewsRequest $request
     * @return JsonResponse
     * @todo Tạo danh sách tin tức
     * @author  Anhv
     * @since 2020-31-07
     */
    public function store(CreateNewsRequest $request){

        $params = $request->all();

        $create = $this->_service->create($params);

        if ($create == true){

            return \resSuccessData($create);

        }

        return \resFail();
    }
    /**
     *
     * @author  Anhv
     * @since 2020-31-07
     * @todo Sửa tin tức
     * @return Màn hình sửa tin
     *
     */
    public function edit($id){

        $categories = $this->_category_service->getActive();
        return  view('admin.news.create',compact('categories','id'));
    }
    /**
     *
     * @author  Anhv
     * @since 2020-31-07
     * @todo Tìm tin theo id tin tức
     * @return json
     *
     */
    public function findById(){
        $id = request('id');

        $info = $this->_service->findById($id);

        return \resSuccessData($info);
    }
    /**
     * @param UpdateNewsRequest $request
     * @param int $id
     * @return JsonResponse
     * @author  Anhv
     * @since 2020-31-07
     * @todo Cập nhật thông tin tin tức
     *
     */
    public function update(UpdateNewsRequest $request, $id)
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
     * @since 2020-31-07
     * @todo Xóa tin tức
     */
    public function destroy($id)
    {

        $data = $this->_service->delete($id);

        return \resSuccessData($data);
    }
}

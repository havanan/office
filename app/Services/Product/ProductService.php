<?php

namespace App\Services\Product;

use App\Models\NewsCategories;
use App\Repositories\News\NewsCategoryRepository;
use App\Repositories\News\NewsRepository;
use App\Repositories\ProductRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductService
{

    private $_repo;
    private $_categoryService;

    public function __construct(
        CategoryService $categoryService,
        ProductRepository $_repo
    )
    {
        $this->_repo = $_repo;
        $this->_categoryService = $categoryService;
    }

    public function getList($request = false)
    {

        $params = [
            'search' => $request->search ?? '',
            'page' => $request->page ?? CURRENT_PAGE,
            'is_publish' => $request->is_publish ?? '',
            'categories' => isset($request->categories) ? json_decode($request->categories) : []
        ];

        return $this->_repo->getList($params);
    }

    public function delete($newsId)
    {

        DB::beginTransaction();

        try {

            $this->_repo->delete($newsId);
            //xóa liên kết bài viết vs bảng category
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
        }

        return $this->getList();
    }

    public function findById($newsId)
    {

        return $this->_repo->findById($newsId);

    }
}


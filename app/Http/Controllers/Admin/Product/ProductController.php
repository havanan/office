<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Services\Product\CategoryService;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $_service;
    protected $_category_service;
    public function __construct( ProductService $service, CategoryService $categoryService)
    {
        $this->_service = $service;
        $this->_category_service = $categoryService;
    }
    public function index(){

    }
    public function create(){
        $categories  = $this->_category_service->getActive();
        return view('admin.product.create',compact('categories'));
    }
}

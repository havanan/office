<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FeedbackService;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{   private $_service;
    public function __construct(FeedbackService $fb) {
        $this->_service = $fb;
    }
    public function index(){
        return view('admin.feedback');
    }
    public function getList(Request $request) {
        return $this->_service->getList($request);
    }
    public function changeStatus($id){
        return $this->_service->changeStatus($id);
    }
}

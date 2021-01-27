<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $counts = [
            'users' => 1,
            'users_unconfirmed' => 2,
            'users_inactive' => 3,
            'protected_pages' => 0,
        ];
        return view('admin.index', compact('counts'));
    }
}

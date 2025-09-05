<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    /**
     * Construct
     */
    public function __construct()
    {
        View::share('user', Auth::guard('admin')->user());
    }

    /**
     * Panel
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}

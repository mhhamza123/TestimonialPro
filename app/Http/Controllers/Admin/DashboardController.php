<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Construct
     */
    public function __construct()
    {
    }

    /**
     * Panel
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}

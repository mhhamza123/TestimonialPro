<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
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
        $testimonials = Testimonial::paginate(100);

        return view('admin.dashboard');
    }
}

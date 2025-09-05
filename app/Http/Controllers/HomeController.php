<?php

namespace App\Http\Controllers;

use App\Enums\TestimonialStatus;
use App\Http\Resources\TestimonialCollection;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $testimonials = new TestimonialCollection(Testimonial::where('status', TestimonialStatus::ACTIVE->value)->get());
        dd($testimonials);
        return view('welcome', compact('testimonials'));
    }
}

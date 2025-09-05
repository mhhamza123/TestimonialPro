<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddTestimonialRequest;
use App\Http\Resources\TestimonialCollection;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * fetch
     */
    public function fetch()
    {
        return response()->json(new TestimonialCollection(Testimonial::with('media')->get()));
    }

    /**
     * Save
     */
    public function save(AddTestimonialRequest $addTestimonialRequest)
    {
        $data = $addTestimonialRequest->validated();
        if(!empty($addTestimonialRequest->id)){
            $testimonial = Testimonial::findOrFail($addTestimonialRequest->id);
            $testimonial->update($data);
        } else {
            $testimonial = Testimonial::create($data);
        }

        if($addTestimonialRequest->hasFile('image'))
            $testimonial->addMediaFromRequest('image')->toMediaCollection('person');

        return response()->json([
            'success' => true,
            'message' => 'Successfully saved!'
        ]);
    }

    /**
     * Delete
     */
    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'numeric|required'
        ]);

        Testimonial::findOrFail($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted'
        ]);
    }
}

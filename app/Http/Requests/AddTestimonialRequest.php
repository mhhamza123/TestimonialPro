<?php

namespace App\Http\Requests;

use App\Enums\TestimonialStatus;
use Illuminate\Foundation\Http\FormRequest;

class AddTestimonialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:200|min:3',
            'status' => 'required|numeric|in:0,1',
            'role' => 'required|max:100',
            'message' => 'required|max:500|min:10',
            'image' => 'image|mimes:png,webp,jpg,jpeg',
        ];
    }

}

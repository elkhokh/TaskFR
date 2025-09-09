<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            "content" => "required|string",
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            "title" => ["required" , "string" , "max:255", "unique:posts,title" , function($attribute,$value,$fail){
                if(str_contains($value,"israel")){
                    $fail("The $attribute cannot contain the word 'israel'");
                }
            }],
        ];
    }
public function messages(): array
{
    return [
        'title.required' => 'The post title is required.',
        'title.string'   => 'The post title must be a valid string.',
        'title.max'      => 'The post title may not be greater than 255 characters.',
        'title.unique'   => 'The post title has already been taken.',

        'content.required' => 'The post content is required.',
        'content.string'   => 'The post content must be a valid string.',

        'image.image' => 'The file must be an image.',
        'image.mimes' => 'The image must be a file of type: jpg, jpeg, png.',
        'image.max'   => 'The image size may not be greater than 2MB.',
    ];
}

}

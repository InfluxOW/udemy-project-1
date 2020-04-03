<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'title' => 'required|unique:blog_posts|min:10',
                    'content' => 'required|max:1000',
                    'thumbnail' => 'image|mimes:jpeg,jpg,png,gif,svg|max:2048'
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'title' => 'required|min:10|unique:blog_posts,title,' . $this->post->id,
                    'content' => 'required|max:1000',
                    'thumbnail' => 'image|mimes:jpeg,jpg,png,gif,svg|max:2048'
                ];
            default:
                break;
        }
    }
}

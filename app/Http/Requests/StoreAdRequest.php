<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdRequest extends FormRequest
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
        return [
            'type' => ['required'],
            'title' => ['required', 'max:20'],
            'description' => ['required', 'max:70'],
            'category' => ['required'],
            'advertiser' => ['required'],
            'start_date' => '',
            'tags' => ['required'],
        ];
    }
}

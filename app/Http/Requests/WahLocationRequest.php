<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WahLocationRequest extends FormRequest
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
            'map_place_id' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'address' => 'required',
            'zipcode' => 'required'
        ];
    }
}

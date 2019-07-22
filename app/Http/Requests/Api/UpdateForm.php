<?php

namespace App\Http\Requests\Api;

class UpdateForm extends ApiRequest
{
    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData()
    {
        return $this->get('generateForm') ?: [];
    }

//    /**
//     * Determine if the user is authorized to make this request.
//     *
//     * @return bool
//     */
//    public function authorize()
//    {
//        $generateForm = $this->route('generateForm');
//
//        return $generateForm->user_id == auth()->id();
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'id' => 'required|integer',
            'name' => 'sometimes|string|max:255',
            'template' => 'sometimes|string|max:255',
            'deal_type' => 'sometimes|string',
            'master_split' => 'sometimes|string',
            'publishing_split' => 'sometimes|string',
            'link' => 'sometimes|string|max:255',
            'artist_id' => 'sometimes|integer|nullable',
        ];
    }
}

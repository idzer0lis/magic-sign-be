<?php

namespace App\Http\Requests\Api;

class CreateForm extends ApiRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'template' => 'required|string|max:255',
            'deal_type' => 'required|string',
            'master_split' => 'required|string',
            'publishing_split' => 'required|string',
            'link' => 'required|string|max:255',
            'artist_id' => 'sometimes|integer',
        ];
    }
}

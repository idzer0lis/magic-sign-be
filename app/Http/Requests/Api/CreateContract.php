<?php

namespace App\Http\Requests\Api;

class CreateContract extends ApiRequest
{
    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData()
    {
        return $this->get('contract') ?: [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'artist_id' => 'required',
            'song_id' => 'required',
            'template_id' => 'required'
        ];
    }
}

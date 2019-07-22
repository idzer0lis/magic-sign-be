<?php

namespace App\Http\Requests\Api;

class CreateArtist extends ApiRequest
{
    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData()
    {
        return $this->get('artist') ?: [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'real_name' => 'required|string|max:255',
            'artist_name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'is_stem_email' => 'required|boolean',
            'is_adult' => 'required|boolean',
            'father_name' => 'sometimes|string|max:255',
            'mother_name' => 'sometimes|string|max:255',
            'father_email' => 'sometimes|string|max:255',
            'mother_email' => 'sometimes|string|max:255',
        ];
    }
}

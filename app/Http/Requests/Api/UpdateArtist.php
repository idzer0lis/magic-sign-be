<?php

namespace App\Http\Requests\Api;

class UpdateArtist extends ApiRequest
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
            'real_name' => 'sometimes|string|max:255',
            'artist_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:255',
            'is_stem_email' => 'sometimes|boolean',
            'is_adult' => 'sometimes|boolean',
            'father_name' => 'sometimes|string|max:255',
            'mother_name' => 'sometimes|string|max:255',
            'father_email' => 'sometimes|string|max:255',
            'mother_email' => 'sometimes|string|max:255',
        ];
    }
}

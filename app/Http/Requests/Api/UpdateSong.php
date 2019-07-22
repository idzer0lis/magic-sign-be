<?php

namespace App\Http\Requests\Api;

class UpdateSong extends ApiRequest
{
    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData()
    {
        return $this->get('song') ?: [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'artist_id' => 'sometimes|number',
            'contract_id' => 'sometimes|number',
            'song_name' => 'sometimes|string|max:255',
            'wav_filename' => 'sometimes|string|max:255',
            'mp3_filename' => 'sometimes|string|max:255',
            'wav_instrumental_filename' => 'sometimes|string|max:255',
            'genre' => 'sometimes|string|max:255',
            'lyrics' => 'sometimes|string',
            'story' => 'sometimes|string',
            'uuid' => 'sometimes|string'
        ];
    }
}

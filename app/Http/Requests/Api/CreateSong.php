<?php

namespace App\Http\Requests\Api;

class CreateSong extends ApiRequest
{
    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData()
    {
        return $this->get('') ?: [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'artist_id' => 'sometimes|string',
            'song_name' => 'sometimes|string|max:255',
            'wav_file' => 'sometimes|binary',
            'mp3_file' => 'sometimes|binary',
            'wav_instrumental_file' => 'sometimes|binary',
            'genre' => 'sometimes|string|max:255',
            'lyrics' => 'sometimes|string',
            'story' => 'sometimes|string',
        ];
    }
}

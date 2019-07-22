<?php

namespace App\Social\Transformers;

class ArtistTransformer extends Transformer
{
    protected $resourceName = 'artist';

    public function transform($data)
    {
        return [
            'id'                => $data['id'],
            'real_name'         => $data['real_name'],
            'artist_name'       => $data['artist_name'],
            'email'             => $data['email'],
            'address'           => $data['address'],
            'is_stem_email'     => $data['is_stem_email'],
            'is_adult'          => $data['is_adult'],
            'father_name'       => $data['father_name'],
            'mother_name'       => $data['mother_name'],
            'father_email'      => $data['father_email'],
            'mother_email'      => $data['father_email'],
            'created_at'        => $data['created_at'],
            'updated_at'        => $data['updated_at'],
            'songs' => $data['songs']
        ];
    }
}

// 'id'                => $data['songs'],
//'artist_id'         => $data['songs']['artist_id'],
//                'song_name'         => $data['songs']['song_name'],
//                'wav_filename'      => $data['songs']['wav_filename'],
//                'mp3_filename'      => $data['songs']['mp3_filename'],
//                'wav_filename_instrumental' => $data['songs']['wav_filename_instrumental'],
//                'genre'       => $data['songs']['genre'],
//                'lyrics'       => $data['songs']['lyrics'],
//                'story'      => $data['songs']['story'],
//                'created_at'      => $data['songs']['created_at'],
//                'updated_at'        => $data['songs']['updated_at'],
//                'path'          => $data['songs']['path']

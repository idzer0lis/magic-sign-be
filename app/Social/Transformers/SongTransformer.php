<?php

namespace App\Social\Transformers;

class SongTransformer extends Transformer
{
    protected $resourceName = 'song';

    public function transform($data)
    {
        return [
            'id'                => $data['id'],
            'artist_id'         => $data['artist_id'],
            'song_name'         => $data['song_name'],
            'wav_filename'      => $data['wav_filename'],
            'mp3_filename'      => $data['mp3_filename'],
            'wav_filename_instrumental' => $data['wav_filename_instrumental'],
            'genre'       => $data['genre'],
            'lyrics'       => $data['lyrics'],
            'story'      => $data['story'],
            'created_at'      => $data['created_at'],
            'updated_at'        => $data['updated_at'],
            'path'          => $data['path']
//            'author' => [
//                'username'  => $data['user']['username'],
//                'bio'       => $data['user']['bio'],
//                'image'     => $data['user']['image'],
//                'following' => $data['user']['following'],
//            ]
        ];
    }
}

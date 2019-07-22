<?php

namespace App\Social\Transformers;

class FormTransformer extends Transformer
{
    protected $resourceName = 'generateForm';

    public function transform($data)
    {
        return [
            'id'                => $data['id'],
            'artist_id'         => $data['artist_id'],
            'name'              => $data['name'],
            'template'          => $data['template'],
            'deal_type'         => $data['deal_type'],
            'master_split'      => $data['master_split'],
            'publishing_split'  => $data['publishing_split'],
            'link'              => $data['link'],
            'user' => [
                'id'        => $data['user']['id'],
                'username'  => $data['user']['username'],
                'bio'       => $data['user']['bio'],
                'image'     => $data['user']['image'],
            ],
            'artist' => [
                'id'        => $data['artist']['id'],
                'artist_name'  => $data['artist']['artist_name'],
                'real_name'       => $data['artist']['real_name'],
                'is_stem_email'     => $data['artist']['is_stem_email'],
                'email'         => $data['artist']['email'],
                'address'       => $data['artist']['address'],
                'is_adult'          => $data['artist']['is_adult'],
                'father_name'       => $data['artist']['father_name'],
                'mother_name'       => $data['artist']['mother_name'],
                'father_email'      => $data['artist']['father_email'],
                'mother_email'      => $data['artist']['father_email'],
                'created_at'        => $data['artist']['created_at'],
                'updated_at'        => $data['artist']['updated_at'],

            ]
        ];
    }
}

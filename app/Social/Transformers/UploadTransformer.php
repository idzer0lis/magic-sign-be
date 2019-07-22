<?php

namespace App\Social\Transformers;

class UploadTransformer extends Transformer
{
    protected $resourceName = 'file';

    public function transform($data)
    {
        return [
            'song_name' => $data['song_name'],
            'id'    => $data['id']
        ];
    }
}

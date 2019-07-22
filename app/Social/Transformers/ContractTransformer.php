<?php

namespace App\Social\Transformers;

class ContractTransformer extends Transformer
{
    protected $resourceName = 'contract';

    public function transform($data)
    {
        return [
            'id'                => $data['id'],
            'artist_id'         => $data['artist_id'],
            'song_id'           => $data['song_id'],
            'template_id'       => $data['template_id'],
            'signed'            => $data['signed'],
            'createdAt'         => $data['created_at']->toAtomString(),
            'updatedAt'         => $data['updated_at']->toAtomString(),
            'artist' => [
                'id'                => $data['artist']['id'],
                'real_name'         => $data['artist']['real_name'],
                'artist_name'       => $data['artist']['artist_name'],
                'email'             => $data['artist']['email'],
                'address'           => $data['artist']['address'],
                'is_stem_email'     => $data['artist']['is_stem_email'],
                'is_adult'          => $data['artist']['is_adult'],
                'father_name'       => $data['artist']['father_name'],
                'mother_name'       => $data['artist']['mother_name'],
                'father_email'      => $data['artist']['father_email'],
                'mother_email'      => $data['artist']['father_email'],
                'created_at'        => $data['artist']['created_at'],
                'updated_at'        => $data['artist']['updated_at'],
            ],
            'template' => [
                'id'                => $data['template']['id'],
                'artist_id'         => $data['template']['artist_id'],
                'name'              => $data['template']['name'],
                'template'          => $data['template']['template'],
                'deal_type'         => $data['template']['deal_type'],
                'master_split'      => $data['template']['master_split'],
                'publishing_split'  => $data['template']['publishing_split'],
                'link'              => $data['template']['link'],
            ],
        ];
    }
}

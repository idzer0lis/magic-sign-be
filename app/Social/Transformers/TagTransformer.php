<?php

namespace App\Social\Transformers;

class TagTransformer extends Transformer
{
    protected $resourceName = 'tag';

    public function transform($data)
    {
        return $data;
    }
}

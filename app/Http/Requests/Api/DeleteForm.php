<?php

namespace App\Http\Requests\Api;

class DeleteForm extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $form = $this->route('generateForm');

        return $form->user_id == auth()->id();
    }
}

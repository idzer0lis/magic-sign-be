<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateForm;
use App\Form;
use App\Http\Requests\Api\UpdateForm;
use App\Http\Requests\Api\DeleteForm;
use App\Social\Transformers\FormTransformer;

class FormController extends ApiController
{
    /**
     * ArticleController constructor.
     *
     * @param FormTransformer $transformer
     */
    public function __construct(FormTransformer $transformer)
    {
        $this->transformer = $transformer;

        $this->middleware('auth.api')->except(['index', 'show']);
        $this->middleware('auth.api:optional')->only(['index', 'show']);
    }

    /**
     * Get all the forms.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $forms = Form::all();

        return $this->respondWithTransformer($forms);
    }

    /**
     * Create a new generateForm and return it if successful.
     *
     * @param CreateForm $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateForm $request)
    {
        $user = auth()->user();

        $form = $user->forms()->create([
            'artist_id' => $request->input('generateForm.artist_id'),
            'name' => $request->input('generateForm.name'),
            'template' => $request->input('generateForm.template'),
            'deal_type' => $request->input('generateForm.deal_type'),
            'master_split' => $request->input('generateForm.master_split'),
            'publishing_split' => $request->input('generateForm.publishing_split'),
            'link' => $request->input('generateForm.link'),
        ]);

        return $this->respondWithTransformer($form);
    }

    /**
     * Get the generateForm given by its id.
     *
     * @param Form $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Form $form)
    {
        return $this->respondWithTransformer($form);
    }

    /**
     * Update the generateForm given by its id and return the generateForm if successful.
     *
     * @param UpdateForm $request
     * @param Form $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateForm $request, Form $form)
    {
        if ($request->has('generateForm')) {
            $form->update($request->get('generateForm'));
        }

        return $this->respondWithTransformer($form);
    }

    /**
     * Delete the comment given by its id.
     *
     * @param DeleteForm $request
     * @param $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteForm $request, $form)
    {
        $form->delete();

        return $this->respondSuccess();
    }

}

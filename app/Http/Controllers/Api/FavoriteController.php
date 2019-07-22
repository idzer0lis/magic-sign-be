<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Social\Transformers\FormTransformer;

class FavoriteController extends ApiController
{
    /**
     * FavoriteController constructor.
     *
     * @param FormTransformer $transformer
     */
    public function __construct(FormTransformer $transformer)
    {
        $this->transformer = $transformer;

        $this->middleware('auth.api');
    }

    /**
     * Favorite the article given by its slug and return the article if successful.
     *
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Article $article)
    {
        $user = auth()->user();

        $user->favorite($article);

        return $this->respondWithTransformer($article);
    }

    /**
     * Unfavorite the article given by its slug and return the article if successful.
     *
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(Article $article)
    {
        $user = auth()->user();

        $user->unFavorite($article);

        return $this->respondWithTransformer($article);
    }
}

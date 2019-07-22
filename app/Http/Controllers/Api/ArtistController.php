<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateArtist;
use App\Artist;
use App\Http\Requests\Api\UpdateArtist;
use App\Social\Filters\ArtistFilter;
use App\Social\Transformers\ArtistTransformer;
use App\Social\Paginate\Paginate;

class ArtistController extends ApiController
{
    /**
     * ArticleController constructor.
     *
     * @param ArtistTransformer $transformer
     */
    public function __construct(ArtistTransformer $transformer)
    {
        $this->transformer= $transformer;

        //$this->middleware('auth.api')->except(['index', 'show']);
        //$this->middleware('auth.api:optional')->only(['index', 'show']);
    }

    /**
     * Get all the artists.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $artists = Artist::all();

        return $this->respondWithTransformer($artists);
    }


    /**
     * Get the artists by filters.
     *
     * @param ArtistFilter $filter
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(ArtistFilter $filter)
    {
        $artists = new Paginate(Artist::loadRelations()->filter($filter));

        return $this->respondWithPagination($artists);
    }

    /**
     * Create a new Artist and return it if successful.
     *
     * @param CreateArtist $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateArtist $request)
    {
        $artist = new Artist();

        $artist = $artist->create([
            'real_name' => $request->input('artist.real_name'),
            'artist_name' => $request->input('artist.artist_name'),
            'email' => $request->input('artist.email'),
            'address' => $request->input('artist.address'),
            'is_stem_email' => $request->input('artist.is_stem_email'),
            'is_adult' => $request->input('artist.is_adult'),
            'father_name' => $request->input('artist.father_name'),
            'mother_name' => $request->input('artist.mother_name'),
            'mother_email' => $request->input('artist.mother_email'),
            'father_email' => $request->input('artist.father_email'),
        ]);

        return $this->respondWithTransformer($artist);
    }

    /**
     * Get the artist given by its id.
     *
     * @param Artist $artist
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Artist $artist)
    {
        return $this->respondWithTransformer($artist);
    }

    /**
     * Update the artist given by its id and return the artist if successful.
     *
     * @param UpdateArtist $request
     * @param Artist $artist
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateArtist $request, Artist $artist)
    {
        if ($request->has('artist')) {
            $artist->update($request->get('artist'));
        }

        return $this->respondWithTransformer($artist);
    }

}

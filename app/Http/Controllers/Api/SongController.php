<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateSong;
use App\Song;
use App\Http\Requests\Api\UpdateSong;
use App\Social\Transformers\SongTransformer;
use Storage;
use File;

class SongController extends ApiController
{
    /**
     * ArticleController constructor.
     *
     * @param SongTransformer $transformer
     */
    public function __construct(SongTransformer $transformer)
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
        $artists = Song::all();

        return $this->respondWithTransformer($artists);
    }

    /**
     * Create a new Song and return it if successful.
     *
     * @param CreateSong $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateSong $request)
    {
        if ( $request->hasFile('wav_file') ) {
            $public_path = public_path();
            $song_name = $request->input('song_name');
            // Save location
            $save_location = $public_path . '/audio/' . $song_name;

            // The wav file
            $wav_file = $request->file('wav_file');


            // File extension
            $extension = $wav_file->getClientOriginalExtension();

            $wav_name = $song_name . '.' . $extension;

            // Move file to /public/audio/...
            $wav_file->move($save_location, $wav_name);

            $fileData = File::get($save_location . '/' . $wav_name);
            Storage::disk('google')->put($wav_name, $fileData);

            // The mp3 file
            $mp3_file = $request->file('mp3_file');
            $extension = $mp3_file->getClientOriginalExtension();
            $mp3_name = $song_name . '.' . $extension;
            $mp3_file->move($save_location, $mp3_name);
            $fileData = File::get($save_location . '/' . $mp3_name);
            Storage::disk('google')->put($wav_name, $fileData);

            if($request->has('wav_instrumental_file')) {
                $wav_instrumental_file = $request->file('wav_instrumental_file');
                $wav_instrumental_name = $song_name . '-Instrumental.' . $extension;
                $wav_instrumental_file->move($save_location, $wav_instrumental_name);
                $fileData = File::get($save_location . '/' . $wav_instrumental_name);
                Storage::disk('google')->put($wav_name, $fileData);
            }

            $song = new Song();

            $song = $song->create([
                'artist_id' => $request->input('artist_id'),
                'song_name' => $song_name,
                'wav_filename' => $wav_name,
                'mp3_filename' => $mp3_name,
                'wav_instrumental_filename' => $wav_instrumental_name ?? NULL,
                'genre' => $request->input('genre'),
                'lyrics' => $request->input('lyrics'),
                'story' => $request->input('story'),
                'path' => $save_location
            ]);

            return $this->respondWithTransformer($song);
        }
    }

    /**
     * Get the song given by its id.
     *
     * @param Song $song
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Song $song)
    {
        return $this->respondWithTransformer($song);
    }

    /**
     * Update the artist given by its id and return the artist if successful.
     *
     * @param UpdateSong $request
     * @param Song $song
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSong $request, Song $song)
    {
        if ($request->has('song')) {
            $song->update($request->get('song'));
        }

        return $this->respondWithTransformer($song);
    }

}

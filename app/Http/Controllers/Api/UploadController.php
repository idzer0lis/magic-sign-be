<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateArtist;
use App\Http\Requests\Api\UploadSong;
use App\Artist;
use App\Http\Requests\Api\UpdateArtist;
use App\Social\Transformers\ArtistTransformer;
use App\Social\Transformers\UploadTransformer;
use App\Song;

class UploadController extends ApiController
{
    /**
     * UploadController constructor.
     *
     * @param UploadTransformer $transformer
     */
    public function __construct(UploadTransformer $transformer)
    {
        $this->transformer= $transformer;

    }

    public function upload(UploadSong $request)
    {
        if ( $request->hasFile('file') ) {
            // The file
            $file = $request->file('file');
            // File extension
            $extension = $file->getClientOriginalExtension();

            $uploadName = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
            $name = $uploadName . '.' . $extension;
            // Path
            $public_path = public_path();
            $pathId = uniqid();
            // Save location
            $location = $public_path . '/audio/' . $pathId . '/' . $extension;
            // Move file to /public/audio/mp3 and save it as my-audio-song.mp3
            $file->move($location, $name);

            $song = new Song();

            $song = $song->create([
                'uuid' => $pathId,
                'song_name' => $uploadName
            ]);

            //var_dump($request);
            //return json_encode($request);
            //return $this->respondSuccess();
            return $this->respondWithTransformer($song);
        }
    }

}

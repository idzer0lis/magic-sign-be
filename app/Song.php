<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'artist_id',
        'song_name',
        'wav_filename',
        'mp3_filename',
        'wav_instrumental_filename',
        'genre',
        'lyrics',
        'story',
        'path'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        //'artist'
    ];

    /**
     * Get the artist that owns the song.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    /**
     * Get the key name for route model binding.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }
}

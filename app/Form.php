<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'artist_id', 'name', 'template', 'deal_type', 'master_split', 'publishing_split', 'link'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        //'tags'
    ];

    /**
     * Get the user that owns the form template.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the artist that owns the form template.
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
        return 'link';
    }
}

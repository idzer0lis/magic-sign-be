<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Social\Filters\Filterable;

class Artist extends Model
{
    use Filterable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'real_name',
        'artist_name',
        'email',
        'address',
        'is_stem_email',
        'is_adult',
        'father_name',
        'mother_name',
        'father_email',
        'mother_email',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
    ];

    /**
     * Get the key name for route model binding.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * Get all the songs for the artist.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function songs()
    {
        return $this->hasMany(Song::class)->latest();
    }

    /**
     * Load all required relationships with only necessary content.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLoadRelations($query)
    {
        return $query;
    }
}

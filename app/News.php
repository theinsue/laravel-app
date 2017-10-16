<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'link', 'guid', 'pubDate', 'thumbnail', 'creator'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'pubDate'
    ];

    public function path()
    {
        return "/news/{$this->id}";
    }

    public static function scopeExisting($query, $guid)
    {
        return $query->where('guid', $guid);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listening extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'artist_id',
        'spotify_track_id',
        'track_name',
        'played_at',

    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebConfig extends Model
{
    use HasFactory;

    protected $table = 'web_config';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'logo',
        'zalo',
        'google_map',
        'google_analytic',
        'facebook_id',
        'youtube',
        'tiktok',
        'telegram',
        'whats_app',
        'dribble',
        'pinterest'
    ];
}

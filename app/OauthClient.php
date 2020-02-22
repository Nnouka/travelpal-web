<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OauthClient extends Model
{
    protected $guarded = ['id'];
    protected $hidden = [
        'client_secret',
        'updated_at',
        'created_at'
    ];

    // generate
    public static function generateAppKey() {
        return Str::random(32);
    }
}

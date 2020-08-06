<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Location extends Model
{
    //
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public static function last() {
        return DB::table('locations')
            ->orderBy('id', 'desc')->first();
    }
}

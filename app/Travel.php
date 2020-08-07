<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    //
    protected $guarded = ['id'];

    protected $dates = [
        'notified_at',
        'started_at',
        'finished_at'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function origin() {
        return $this->hasOne('App\Location', 'origin_location_id');
    }

    public function destination() {
        return $this->hasOne('App\Location', 'destination_location_id');
    }
}

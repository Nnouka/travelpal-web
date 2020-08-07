<?php

namespace App;

use App\Utils\Distance;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;
    const CURRENT = 'CURRENT';
    const TYPE = ["travel_intent" => "App\Notifications\TravelIntent"];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles() {
        return $this->belongsToMany('App\Role');
    }

    public function locations() {
        return $this->hasMany('App\Location');
    }

    public function travels() {
        return $this->hasMany('App\Travel');
    }

    public function currentLocation() {
        return $this->hasMany('App\Location')->where('name', "=",self::CURRENT)->first();
    }

    public function nearDrivers($lng, $lat, $id) {
        $drivers = User::where('is_driver', true)->get();

        $nearDrivers = [];

        foreach ($drivers as $driver) {
            $location = $driver->currentLocation();
            // exclude current user
            if ($driver->id != $id) {
                if ($location != null) {
                    $distance = Distance::calculate($lat, $lng, $location->latitude, $location->longitude); // in Km
                    if ($distance <= 20.0) {// 20Km circumference
                        array_push($nearDrivers, ["driver" => $driver, "distance" => $distance]);
                    }
                }
            }
        }

        return $nearDrivers;
    }

    /**
     * @param $id
     * @return bool|int
     */
    public static function markNotificationAsRead($id) {
        return DB::table('notifications')->where('id', "=", $id)->update(["read_at" => Carbon::now()]);
    }

    public static function markAllTravelIntentNotificationsAsRead($user_id) {
        return DB::table('notifications')
            ->where('notifiable_id', '=', $user_id)
            ->where("type", "=", self::TYPE["travel_intent"])
            ->where("read_at", "=", null)
            ->update(["read_at" => Carbon::now()]);
    }
}

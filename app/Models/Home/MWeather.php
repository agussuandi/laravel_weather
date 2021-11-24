<?php

namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;

class MWeather extends Model
{
    protected $table = 'm_weather';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function details()
    {
        return $this->hasMany('App\Models\Home\MWeatherDetail', 'foreign_key', 'local_key');
    }
}
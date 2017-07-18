<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shortener extends Model
{
    protected $table='shortener';
    protected $fillable=['short_url','long_url'];
}

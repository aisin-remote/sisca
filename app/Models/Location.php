<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'tm_locations';
    protected $guarded = [];

    public function apars(){
        return $this->hasMany(Apar::class);
    }

    public function hydrants(){
        return $this->hasMany(Hydrant::class);
    }

    public function nitrogens(){
        return $this->hasMany(Nitrogen::class);
    }

    public function co2s(){
        return $this->hasMany(Co2::class);
    }

    public function tandus(){
        return $this->hasMany(Tandu::class);
    }

    public function eyewashers(){
        return $this->hasMany(Eyewasher::class);
    }

    public function slings(){
        return $this->hasMany(Sling::class);
    }
}

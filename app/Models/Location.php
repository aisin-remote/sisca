<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function apars(){
        return $this->hasMany(Apar::class);
    }

    public function hydrants(){
        return $this->hasMany(Hydrant::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facp extends Model
{
    use HasFactory;
    protected $table  = 'tm_facps';
    protected $guarded = [];

    public function locations()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}

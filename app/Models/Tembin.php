<?php

namespace App\Models;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tembin extends Model
{
    use HasFactory;
    protected $table = 'tm_tembins';
    protected $guarded = [];

    public function locations()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}

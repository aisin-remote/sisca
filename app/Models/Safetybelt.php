<?php

namespace App\Models;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Safetybelt extends Model
{
    use HasFactory;
    protected $table = 'tm_safetybelts';
    protected $guarded = [];

    public function locations()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}

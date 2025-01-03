<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProsedurkHeadCrane extends Model
{
    use HasFactory;

    protected $table = 'tm_prosedur_head_crane';

    protected $guarded = ['id'];
    public function itemChecks()
    {
        return $this->belongsToMany(ItemCheckHeadCrane::class, 'proseduritemcheckheadcrane', 'prosedur_id', 'item_check_id');
    }
}

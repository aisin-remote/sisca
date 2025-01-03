<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProsedurItemCheckHeadCrane extends Model
{
    use HasFactory;
    public function itemCheck()
    {
        return $this->belongsTo(ItemCheckHeadCrane::class, 'id_item_check');
    }

    // Relasi ke ProsedurHeadCrane
    public function procedure()
    {
        return $this->belongsTo(ProsedurkHeadCrane::class, 'id_prosedur');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCheckHeadCrane extends Model
{
    use HasFactory;

    protected $table = 'tm_item_check_head_crane';
    protected $guarded = ['id'];

    public function checkSheetItems()
    {
        return $this->hasMany(CheckSheetItemHeadcrane::class, 'item_check_id');
    }
}

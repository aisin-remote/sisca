<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetTandu extends Model
{
    use HasFactory;

    protected $table = 'tt_check_sheet_tandus';

    protected $fillable = [
        'tanggal_pengecekan',
        'npk',
        'tandu_number',
        'kunci_pintu',
        'catatan_kunci_pintu',
        'photo_kunci_pintu',
        'pintu',
        'catatan_pintu',
        'photo_pintu',
        'sign',
        'catatan_sign',
        'photo_sign',
        'hand_grip',
        'catatan_hand_grip',
        'photo_hand_grip',
        'body',
        'catatan_body',
        'photo_body',
        'engsel',
        'catatan_engsel',
        'photo_engsel',
        'kaki',
        'catatan_kaki',
        'photo_kaki',
        'belt',
        'catatan_belt',
        'photo_belt',
        'rangka',
        'catatan_rangka',
        'photo_rangka',
    ];

    public function tandus()
    {
        return $this->belongsTo(Tandu::class, 'tandu_number', 'no_tandu');
    }

    public $timestamps = true;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetBodyHarnest extends Model
{
    use HasFactory;

    protected $table = 'tt_check_sheet_body_harnests';

    protected $fillable = [
        'tanggal_pengecekan',
        'npk',
        'bodyharnest_number',
        'shoulder_straps',
        'catatan_shoulder_straps',
        'photo_shoulder_straps',
        'hook',
        'catatan_hook',
        'photo_hook',
        'buckles_waist',
        'catatan_buckles_waist',
        'photo_buckles_waist',
        'buckles_chest',
        'catatan_buckles_chest',
        'photo_buckles_chest',
        'leg_straps',
        'catatan_leg_straps',
        'photo_leg_straps',
        'buckles_leg',
        'catatan_buckles_leg',
        'photo_buckles_leg',
        'back_d_ring',
        'catatan_back_d_ring',
        'photo_back_d_ring',
        'carabiner',
        'catatan_carabiner',
        'photo_carabiner',
        'straps_rope',
        'catatan_straps_rope',
        'photo_straps_rope',
        'shock_absorber',
        'catatan_shock_absorber',
        'photo_shock_absorber',
    ];

    public function bodyharnests()
    {
        return $this->belongsTo(Bodyharnest::class, 'bodyharnest_number', 'no_bodyharnest');
    }

    public $timestamps = true;
}

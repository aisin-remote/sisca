<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetSlingWire extends Model
{
    use HasFactory;

    protected $table = 'tt_check_sheet_sling_wires';

    protected $fillable = [
        'tanggal_pengecekan',
        'npk',
        'sling_number',
        'serabut_wire',
        'catatan_serabut_wire',
        'photo_serabut_wire',
        'bagian_wire_1',
        'catatan_bagian_wire_1',
        'photo_bagian_wire_1',
        'bagian_wire_2',
        'catatan_bagian_wire_2',
        'photo_bagian_wire_2',
        'kumpulan_wire_1',
        'catatan_kumpulan_wire_1',
        'photo_kumpulan_wire_1',
        'diameter_wire',
        'catatan_diameter_wire',
        'photo_diameter_wire',
        'kumpulan_wire_2',
        'catatan_kumpulan_wire_2',
        'photo_kumpulan_wire_2',
        'hook_wire',
        'catatan_hook_wire',
        'photo_hook_wire',
        'pengunci_hook',
        'catatan_pengunci_hook',
        'photo_pengunci_hook',
        'mata_sling',
        'catatan_mata_sling',
        'photo_mata_sling',
    ];

    public function slings()
    {
        return $this->belongsTo(Sling::class, 'sling_number', 'no_sling');
    }

    public $timestamps = true;
}

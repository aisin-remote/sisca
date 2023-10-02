<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetSlingBelt extends Model
{
    use HasFactory;

    protected $table = 'tt_check_sheet_sling_belts';

    protected $fillable = [
        'tanggal_pengecekan',
        'npk',
        'sling_number',
        'kelengkapan_tag_sling_belt',
        'catatan_kelengkapan_tag_sling_belt',
        'photo_kelengkapan_tag_sling_belt',
        'bagian_pinggir_belt_robek',
        'catatan_bagian_pinggir_belt_robek',
        'photo_bagian_pinggir_belt_robek',
        'pengecekan_lapisan_belt_1',
        'catatan_pengecekan_lapisan_belt_1',
        'photo_pengecekan_lapisan_belt_1',
        'pengecekan_jahitan_belt',
        'catatan_pengecekan_jahitan_belt',
        'photo_pengecekan_jahitan_belt',
        'pengecekan_permukaan_belt',
        'catatan_pengecekan_permukaan_belt',
        'photo_pengecekan_permukaan_belt',
        'pengecekan_lapisan_belt_2',
        'catatan_pengecekan_lapisan_belt_2',
        'photo_pengecekan_lapisan_belt_2',
        'pengecekan_aus',
        'catatan_pengecekan_aus',
        'photo_pengecekan_aus',
        'hook_wire',
        'catatan_hook_wire',
        'photo_hook_wire',
        'pengunci_hook',
        'catatan_pengunci_hook',
        'photo_pengunci_hook',
    ];

    public function slings()
    {
        return $this->belongsTo(Sling::class, 'sling_number', 'no_sling');
    }

    public $timestamps = true;
}

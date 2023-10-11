<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetTembin extends Model
{
    use HasFactory;

    protected $table = 'tt_check_sheet_tembins';

    protected $fillable = [
        'tanggal_pengecekan',
        'npk',
        'tembin_number',
        'master_link',
        'catatan_master_link',
        'photo_master_link',
        'body_tembin',
        'catatan_body_tembin',
        'photo_body_tembin',
        'mur_baut',
        'catatan_mur_baut',
        'photo_mur_baut',
        'shackle',
        'catatan_shackle',
        'photo_shackle',
        'hook_atas',
        'catatan_hook_atas',
        'photo_hook_atas',
        'pengunci_hook_atas',
        'catatan_pengunci_hook_atas',
        'photo_pengunci_hook_atas',
        'mata_chain',
        'catatan_mata_chain',
        'photo_mata_chain',
        'chain',
        'catatan_chain',
        'photo_chain',
        'hook_bawah',
        'catatan_hook_bawah',
        'photo_hook_bawah',
        'pengunci_hook_bawah',
        'catatan_pengunci_hook_bawah',
        'photo_pengunci_hook_bawah',
    ];

    public function tembins()
    {
        return $this->belongsTo(Tandu::class, 'tembin_number', 'no_equip');
    }

    public $timestamps = true;
}

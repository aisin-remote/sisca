<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheetChainblock extends Model
{
    use HasFactory;

    protected $table = 'tt_check_sheet_chainblocks';

    protected $fillable = [
        'tanggal_pengecekan',
        'npk',
        'chainblock_number',
        'geared_trolley',
        'catatan_geared_trolley',
        'photo_geared_trolley',
        'chain_geared_trolley_1',
        'catatan_chain_geared_trolley_1',
        'photo_chain_geared_trolley_1',
        'chain_geared_trolley_2',
        'catatan_chain_geared_trolley_2',
        'photo_chain_geared_trolley_2',
        'hooking_geared_trolly',
        'catatan_hooking_geared_trolly',
        'photo_hooking_geared_trolly',
        'latch_hook_atas',
        'catatan_latch_hook_atas',
        'photo_latch_hook_atas',
        'hook_atas',
        'catatan_hook_atas',
        'photo_hook_atas',
        'hand_chain',
        'catatan_hand_chain',
        'photo_hand_chain',
        'load_chain',
        'catatan_load_chain',
        'photo_load_chain',
        'latch_hook_bawah',
        'catatan_latch_hook_bawah',
        'photo_latch_hook_bawah',
        'hook_bawah',
        'catatan_hook_bawah',
        'photo_hook_bawah',
    ];

    public function chainblocks()
    {
        return $this->belongsTo(Chainblock::class, 'chainblock_number', 'no_chainblock');
    }

    public $timestamps = true;
}

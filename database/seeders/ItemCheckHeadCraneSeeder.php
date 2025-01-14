<?php

namespace Database\Seeders;

use App\Models\ItemCheckHeadCrane;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemCheckHeadCraneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tm_item_check_head_crane')->insert([
            [
                'item_check' => 'Visual Check',
                'prosedur'   => 'Status Equipment',
                'standart'   => 'Tidak Ada TAG OUT Repair / Preventive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Cross Traveling',
                'prosedur'   => 'Arah Pergerakan Hoist',
                'standart'   => 'Sesuai tombol pendant yang ditekan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Cross Traveling',
                'prosedur'   => 'Suara Saat Hoist Berjalan',
                'standart'   => 'Tidak Ada Suara Abnormal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Cross Traveling',
                'prosedur'   => 'Kelancaran Pergerakan Hoist',
                'standart'   => 'Bergerak Dengan Lancar, Tidak Ada Guncangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Cross Traveling',
                'prosedur'   => 'Rem Cross Traveling',
                'standart'   => 'Berfungsi Dengan Baik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Cross Traveling',
                'prosedur'   => 'Limit Switch Cross Traveling',
                'standart'   => 'Hoist Akan Berhenti Saat Posisi Maximum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Cross Traveling',
                'prosedur'   => 'Kecepatan Cross Traveling',
                'standart'   => 'Hoist Akan Melambat Sebelum Posisi Maximum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Long Traveling',
                'prosedur'   => 'Arah Pergerakan Hoist',
                'standart'   => 'Sesuai tombol pendant yang ditekan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Long Traveling',
                'prosedur'   => 'Suara Saat Hoist Berjalan',
                'standart'   => 'Tidak Ada Suara Abnormal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Long Traveling',
                'prosedur'   => 'Kelancaran Pergerakan Hoist',
                'standart'   => 'Bergerak Dengan Lancar, Tidak Ada Guncangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Long Travelling',
                'prosedur'   => 'Rem Long Travelling',
                'standart'   => 'Berfungsi Dengan Baik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Long Travelling',
                'prosedur'   => 'Limit Switch Long Traveling',
                'standart'   => 'Hoist Akan Berhenti Saat Posisi Maximum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Long Traveling',
                'prosedur'   => 'Kecepatan Long Traveling',
                'standart'   => 'Hoist Akan Melambat Sebelum Posisi Maximum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Up Direction',
                'prosedur'   => 'Arah Pergerakan Hoist',
                'standart'   => 'Sesuai tombol pendant yang ditekan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Up Direction',
                'prosedur'   => 'Suara Saat Hoist Berjalan',
                'standart'   => 'Tidak Ada Suara Abnormal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Up Direction',
                'prosedur'   => 'Kelancaran Pergerakan Hoist',
                'standart'   => 'Bergerak Dengan Lancar, Tidak Ada Guncangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Up Direction',
                'prosedur'   => 'Rem Up Direction',
                'standart'   => 'Berfungsi Dengan Baik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Up Direction',
                'prosedur'   => 'Jarak Hoist Saat Stop Diatas',
                'standart'   => 'Minimal 70cm',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Down Direction',
                'prosedur'   => 'Arah Pergerakan Hoist',
                'standart'   => 'Sesuai tombol pendant yang ditekan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Down Direction',
                'prosedur'   => 'Suara Saat Hoist Berjalan',
                'standart'   => 'Tidak Ada Suara Abnormal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Down Direction',
                'prosedur'   => 'Kelancaran Pergerakan Hoist',
                'standart'   => 'Bergerak Dengan Lancar, Tidak Ada Guncangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Down Direction',
                'prosedur'   => 'Rem Down Direction',
                'standart'   => 'Berfungsi Dengan Baik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Down Direction',
                'prosedur'   => 'Jarak Hoist Saat Stop Dibawah',
                'standart'   => 'Minimal 20 cm Dari Lantai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Pendant Hoist',
                'prosedur'   => 'Push Button Pendant',
                'standart'   => 'Tidak Ada Abnormal / Rusak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Pendant Hoist',
                'prosedur'   => 'Cover Pendant',
                'standart'   => 'Tidak Ada Abnormal / Rusak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Pendant Hoist',
                'prosedur'   => 'Kabel Pendant',
                'standart'   => 'Tidak Ada Abnormal / Rusak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Wire Rope / Chain',
                'prosedur'   => 'Bentuk Wire Rope / Chain',
                'standart'   => 'Tidak Ada Deformasi / Rusak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Wire Rope / Chain',
                'prosedur'   => 'Kondisi Wire Rope / Chain',
                'standart'   => 'Tidak Ada Karat / Putus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Block Hook',
                'prosedur'   => 'Safety Lacth',
                'standart'   => 'Dapat Mengunci Hook Dengan Sempurna',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Block Hook',
                'prosedur'   => 'Hook',
                'standart'   => 'Berputar Dengan Lancar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Block Hook',
                'prosedur'   => 'Sheave',
                'standart'   => 'Tidak Abnormal / Aus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Horn',
                'prosedur'   => 'Suara Horn',
                'standart'   => 'Berbunyi Saat Hoist Bergerak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_check' => 'Emergency Stop',
                'prosedur'   => 'Fungsi Emergency Stop',
                'standart'   => 'Hoist Berhenti Saat EMC Ditekan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

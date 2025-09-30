<?php

namespace Modules\Education\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campuses = [
            ['campus_name' => 'Universitas Indonesia', 'city' => 'Depok', 'province' => 'Jawa Barat'],
            ['campus_name' => 'Institut Teknologi Bandung', 'city' => 'Bandung', 'province' => 'Jawa Barat'],
            ['campus_name' => 'Universitas Gadjah Mada', 'city' => 'Yogyakarta', 'province' => 'Yogyakarta'],
            ['campus_name' => 'Institut Teknologi Sepuluh Nopember', 'city' => 'Surabaya', 'province' => 'Jawa Timur'],
            ['campus_name' => 'Universitas Brawijaya', 'city' => 'Malang', 'province' => 'Jawa Timur'],
            ['campus_name' => 'Universitas Diponegoro', 'city' => 'Semarang', 'province' => 'Jawa Tengah'],
            ['campus_name' => 'Universitas Sebelas Maret', 'city' => 'Surakarta', 'province' => 'Jawa Tengah'],
            ['campus_name' => 'Universitas Padjadjaran', 'city' => 'Bandung', 'province' => 'Jawa Barat'],
            ['campus_name' => 'Universitas Airlangga', 'city' => 'Surabaya', 'province' => 'Jawa Timur'],
            ['campus_name' => 'Universitas Hasanuddin', 'city' => 'Makassar', 'province' => 'Sulawesi Selatan'],
            ['campus_name' => 'Universitas Sumatera Utara', 'city' => 'Medan', 'province' => 'Sumatera Utara'],
            ['campus_name' => 'Universitas Andalas', 'city' => 'Padang', 'province' => 'Sumatera Barat'],
            ['campus_name' => 'Universitas Udayana', 'city' => 'Denpasar', 'province' => 'Bali'],
            ['campus_name' => 'Universitas Negeri Jakarta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta'],
            ['campus_name' => 'Universitas Pendidikan Indonesia', 'city' => 'Bandung', 'province' => 'Jawa Barat'],
        ];

        foreach ($campuses as $campus) {
            DB::table('campuses')->insert([
                'campus_name' => $campus['campus_name'],
                'city' => $campus['city'],
                'province' => $campus['province'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

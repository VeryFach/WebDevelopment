<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hospital;

class HospitalSeeder extends Seeder
{
    public function run()
    {
        $hospitals = [
            [
                'name' => 'RSUP Dr. Sardjito',
                'address' => 'Jl. Kesehatan No.1, Sekip, Yogyakarta',
                'city' => 'Yogyakarta',
                'province' => 'DI Yogyakarta',
                'phone' => '0274-587333',
                'email' => 'info@sardjito.co.id',
                'latitude' => -7.7678,
                'longitude' => 110.3728,
                'type' => 'public',
                'services' => ['IGD', 'ICU', 'Bedah', 'Jantung', 'Anak'],
                'emergency_service' => true,
                'bed_capacity' => 750,
                'status' => 'active'
            ],
            [
                'name' => 'RS Bethesda',
                'address' => 'Jl. Jend. Sudirman No.70, Yogyakarta',
                'city' => 'Yogyakarta',
                'province' => 'DI Yogyakarta',
                'phone' => '0274-563333',
                'email' => 'info@bethesda.or.id',
                'latitude' => -7.7826,
                'longitude' => 110.3664,
                'type' => 'private',
                'services' => ['IGD', 'ICU', 'Bedah', 'Mata', 'THT'],
                'emergency_service' => true,
                'bed_capacity' => 200,
                'status' => 'active'
            ],
            [
                'name' => 'RSUD Kota Yogyakarta',
                'address' => 'Jl. Kenari No.55, Yogyakarta',
                'city' => 'Yogyakarta',
                'province' => 'DI Yogyakarta',
                'phone' => '0274-512002',
                'email' => 'rsudkota@jogjakota.go.id',
                'latitude' => -7.7956,
                'longitude' => 110.3695,
                'type' => 'public',
                'services' => ['IGD', 'Poli Umum', 'KIA', 'Gigi'],
                'emergency_service' => true,
                'bed_capacity' => 150,
                'status' => 'active'
            ],
            [
                'name' => 'RS Mata Dr. Yap',
                'address' => 'Jl. Cik Di Tiro 5, Yogyakarta',
                'city' => 'Yogyakarta',
                'province' => 'DI Yogyakarta',
                'phone' => '0274-547447',
                'email' => 'info@rsmatayap.com',
                'latitude' => -7.7815,
                'longitude' => 110.3758,
                'type' => 'specialized',
                'services' => ['Mata', 'Refraksi', 'Operasi Katarak'],
                'emergency_service' => false,
                'bed_capacity' => 50,
                'status' => 'active'
            ]
        ];

        foreach ($hospitals as $hospital) {
            Hospital::create($hospital);
        }
    }
}
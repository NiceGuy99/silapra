<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Officer;

class OfficerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat 3 petugas dummy
        Officer::create([
            'name' => 'Petugas 1',
            'is_active' => true,
        ]);

        Officer::create([
            'name' => 'Petugas 2',
            'is_active' => true,
        ]);

        Officer::create([
            'name' => 'Petugas 3',
            'is_active' => true,
        ]);
    }
}

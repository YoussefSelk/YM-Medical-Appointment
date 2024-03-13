<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Address::create([
                'rue' => 'rue ' . rand(1, 100),
                'ville' => 'ville ' . rand(1, 50)
            ]);
        }
        
    }
}

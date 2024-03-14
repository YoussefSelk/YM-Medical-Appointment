<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $specialities = [
            ['name' => 'Genaraliste'],
            ['name' => 'Cardiology'],
            ['name' => 'Dermatology'],
            ['name' => 'Endocrinology'],
            ['name' => 'Gastroenterology'],
            ['name' => 'Hematology'],
            ['name' => 'Infectious Disease'],
            ['name' => 'Nephrology'],
            ['name' => 'Neurology'],
            ['name' => 'Obstetrics and Gynecology'],
            ['name' => 'Oncology'],
            ['name' => 'Ophthalmology'],
            ['name' => 'Orthopedics'],
            ['name' => 'Otolaryngology'],
            ['name' => 'Pediatrics'],
            ['name' => 'Psychiatry'],
            ['name' => 'Pulmonology'],
            ['name' => 'Radiology'],
            ['name' => 'Rheumatology'],
            ['name' => 'Urology'],
            ['name' => 'Anesthesiology'],
            ['name' => 'Dental Medicine'],
            ['name' => 'Dietetics'],
            ['name' => 'Emergency Medicine'],
            ['name' => 'Family Medicine'],
            ['name' => 'Geriatrics'],
            ['name' => 'Hepatology'],
            ['name' => 'Immunology'],
            ['name' => 'Internal Medicine'],
            ['name' => 'Medical Genetics'],
            ['name' => 'Nuclear Medicine'],
            ['name' => 'Orthodontics'],
            ['name' => 'Pain Medicine'],
            ['name' => 'Pathology'],
            ['name' => 'Physical Therapy'],
            ['name' => 'Plastic Surgery'],
            ['name' => 'Podiatry'],
            ['name' => 'Reproductive Medicine'],
            ['name' => 'Sleep Medicine'],
            ['name' => 'Sports Medicine'],
            ['name' => 'Surgery'],
            ['name' => 'Toxicology'],
            ['name' => 'Transplant Surgery'],
            ['name' => 'Vascular Medicine'],
            ['name' => 'Veterinary Medicine'],
            ['name' => 'Wilderness Medicine'],
            ['name' => 'Wound Care'],
        ];

        DB::table('specialities')->insert($specialities);
    }
}

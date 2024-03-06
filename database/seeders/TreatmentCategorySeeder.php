<?php

namespace Database\Seeders;

use App\Models\TreatmentCategory;
use Illuminate\Database\Seeder;

class TreatmentCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'General',
            'Dental',
            'Orthodontic',
            'Periodontic',
            'Endodontic',
            'Prosthodontic',
            'Oral Surgery',
            'Pediatric',
            'Preventive',
            'Cosmetic',
            'Implant',
            'Restorative',
            'Emergency',
            'Other',
        ];

        foreach ($categories as $category) {
            TreatmentCategory::create([
                'category' => $category,
            ]);
        }
    }
}

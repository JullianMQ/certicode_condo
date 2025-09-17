<?php

namespace Database\Seeders;

use App\Models\Condo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CondoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $condos = [
            [
                'condo_id' => 'C-001',
                'building_name' => 'The Radiance Manila Bay',
                'address' => 'Roxas Boulevard, Pasay City, Metro Manila',
                'developer' => 'Robinsons Land Corporation',
                'unit_id' => 'U-1805',
                'unit_type' => '1-Bedroom',
                'floor_area_sqm' => 42.0,
                'current_status' => 'Occupied',
                'owner_id' => 'U-101',
                'listing_details' => [
                    'rent_price_php' => 45000,
                    'is_for_rent' => false,
                    'images' => [
                        'https://example.com/images/radiance_exterior.jpg',
                        'https://example.com/images/radiance_unit1805.jpg'
                    ],
                    'amenities_access' => ['Pool', 'Gym', 'Function Room', 'Play Area']
                ],
            ],
            [
                'condo_id' => 'C-002',
                'building_name' => 'SMDC Light Residences',
                'address' => 'EDSA-Boni, Mandaluyong City, Metro Manila',
                'developer' => 'SM Development Corporation',
                'unit_id' => 'U-25C',
                'unit_type' => 'Studio',
                'floor_area_sqm' => 23.0,
                'current_status' => 'Vacant',
                'owner_id' => null,
                'listing_details' => [
                    'rent_price_php' => 18500,
                    'is_for_rent' => true,
                    'images' => [
                        'https://example.com/images/smdc_light_tower.jpg',
                        'https://example.com/images/smdc_light_unit25c.jpg'
                    ],
                    'amenities_access' => ['Pool', 'Gym', 'Mall Access']
                ],
            ],
            [
                'condo_id' => 'C-003',
                'building_name' => 'One Serendra',
                'address' => 'Bonifacio Global City, Taguig, Metro Manila',
                'developer' => 'Ayala Land Premier',
                'unit_id' => 'U-35B',
                'unit_type' => '2-Bedroom',
                'floor_area_sqm' => 125.0,
                'current_status' => 'Occupied',
                'owner_id' => 'U-102',
                'listing_details' => [
                    'rent_price_php' => 120000,
                    'is_for_rent' => true,
                    'images' => [
                        'https://example.com/images/serendra_garden.jpg',
                        'https://example.com/images/serendra_unit35b.jpg'
                    ],
                    'amenities_access' => ['Pool', 'Gym', 'Function Room', 'Tennis Court']
                ],
            ],
            [
                'condo_id' => 'C-004',
                'building_name' => 'The Radiance Manila Bay',
                'address' => 'Roxas Boulevard, Pasay City, Metro Manila',
                'developer' => 'Robinsons Land Corporation',
                'unit_id' => 'U-1203',
                'unit_type' => '2-Bedroom',
                'floor_area_sqm' => 68.0,
                'current_status' => 'Occupied',
                'owner_id' => 'U-103',
                'listing_details' => [
                    'rent_price_php' => 65000,
                    'is_for_rent' => false,
                    'images' => [
                        'https://example.com/images/radiance_exterior.jpg',
                        'https://example.com/images/radiance_unit1203.jpg'
                    ],
                    'amenities_access' => ['Pool', 'Gym', 'Function Room', 'Play Area']
                ],
            ],
        ];

        foreach ($condos as $condo) {
            Condo::create($condo);
        }
    }
}

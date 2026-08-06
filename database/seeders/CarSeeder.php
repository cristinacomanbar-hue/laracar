<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sourceFolder = database_path('seeders/data/cars');
        $destinationFolder = storage_path('app/public/cars');

        File::ensureDirectoryExists($destinationFolder);

        $cars = [
            [
                'brand' => 'Toyota',
                'model' => 'RAV4',
                'year' => 2024,
                'price_per_day' => 89.99,
                'available' => true,
                'fuel_type' => 'Hybrid',
                'transmission' => 'Automatic',
                'seats' => 5,
                'category' => 'SUV',
                'photo' => 'cars/toyota-rav4.png',
                'image' => 'toyota-rav4.png',
            ],
            [
                'brand' => 'Mini',
                'model' => 'Cooper',
                'year' => 2023,
                'price_per_day' => 59.99,
                'available' => true,
                'fuel_type' => 'Gasoline',
                'transmission' => 'Automatic',
                'seats' => 4,
                'category' => 'Compact',
                'photo' => 'cars/mini-cooper.png',
                'image' => 'mini-cooper.png',
            ],
            [
                'brand' => 'Dodge',
                'model' => 'Caravan',
                'year' => 2022,
                'price_per_day' => 99.99,
                'available' => true,
                'fuel_type' => 'Gasoline',
                'transmission' => 'Automatic',
                'seats' => 7,
                'category' => 'Van',
                'photo' => 'cars/dodge-caravan.png',
                'image' => 'dodge-caravan.png',
            ],
        ];

        foreach ($cars as $car) {
            File::copy(
                $sourceFolder . DIRECTORY_SEPARATOR . $car['image'],
                $destinationFolder . DIRECTORY_SEPARATOR . $car['image']
            );

            unset($car['image']);

            Car::updateOrCreate(
                [
                    'brand' => $car['brand'],
                    'model' => $car['model'],
                ],
                $car
            );
        }
    }
}
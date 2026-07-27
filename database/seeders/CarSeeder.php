<?php

namespace Database\Seeders;
use App\Models\Car;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    Car::create([
        'brand' => 'Toyota',
        'model' => 'RAV4',
        'year' => 2024,
        'price_per_day' => 89.99,
        'available' => true,
        'fuel_type' => 'Gasoline',
        'transmission' => 'Automatic',
        'seats' => 5,
        'category' => 'SUV',
        'photo' => 'cars/toyota-rav4.jpg',
    ]);

    Car::create([
        'brand' => 'Mini',
        'model' => 'Cooper',
        'year' => 2023,
        'price_per_day' => 69.99,
        'available' => true,
        'fuel_type' => 'Gasoline',
        'transmission' => 'Automatic',
        'seats' => 4,
        'category' => 'Hatchback',
        'photo' => 'cars/mini-cooper.jpg',
    ]);

    Car::create([
        'brand' => 'Ford',
        'model' => 'Mustang',
        'year' => 2024,
        'price_per_day' => 129.99,
        'available' => true,
        'fuel_type' => 'Gasoline',
        'transmission' => 'Automatic',
        'seats' => 4,
        'category' => 'Sports',
        'photo' => 'cars/mustang.jpg',
    ]);
}
}

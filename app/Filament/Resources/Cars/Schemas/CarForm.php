<?php

namespace App\Filament\Resources\Cars\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class CarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('brand')
                    ->required(),
                TextInput::make('model')
                    ->required(),
                Select::make('year')
                    ->options(array_combine(
                        range(date('Y') + 1, 2000),
                        range(date('Y') + 1, 2000)
                    ))
                    ->required(),
                TextInput::make('price_per_day')
                    ->required()
                    ->numeric(),                           
                Select::make('fuel_type')
                    ->options([
                        'Gasoline' => 'Gasoline',
                        'Diesel' => 'Diesel',
                        'Hybrid' => 'Hybrid',
                        'Electric' => 'Electric',
                    ])
                    ->required(),
                Select::make('category')
                    ->options([
                        'Economy' => 'Economy',
                        'Compact' => 'Compact',
                        'Sedan' => 'Sedan',
                        'SUV' => 'SUV',
                        'Pickup' => 'Pickup',
                        'Luxury' => 'Luxury',
                    ])
                    ->required(),
                Select::make('transmission')
                    ->options([
                        'Automatic' => 'Automatic',
                        'Manual' => 'Manual',
                    ])
                    ->required(),

               Select::make('seats')
                    ->options([
                        2 => '2 seats',
                        4 => '4 seats',
                        5 => '5 seats',
                        7 => '7 seats',
                        8 => '8 seats',
                    ])
                    ->required(),

                Checkbox::make('available')
                    ->default(true),
            ]);
    }
}

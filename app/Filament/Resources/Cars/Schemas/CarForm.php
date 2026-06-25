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
                Checkbox::make('available')
                    ->default(true),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Reservations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Closure;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Model;

class ReservationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([           
                Select::make('car_id')
                    ->label('Car')
                    ->relationship('car', 'brand')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->brand . ' ' . $record->model)
                    ->required(),
                TextInput::make('customer_name')
                    ->required(),
                TextInput::make('customer_email')
                    ->email()
                    ->required(),
                TextInput::make('customer_phone')
                    ->tel()
                    ->mask('(999) 999 9999')
                    ->required(),        
                DatePicker::make('start_date')
                    ->minDate(today())
                    ->required(),    

                DatePicker::make('end_date')
                    ->afterOrEqual('start_date')
                    ->rules([
                        fn (Get $get, ?Model $record): Closure => function (string $attribute, $value, Closure $fail) use ($get, $record) {
                            $query = \App\Models\Reservation::overlapping(
                                $get('car_id'),
                                $get('start_date'),
                                $value
                            );

                            if ($record) {
                                $query->whereKeyNot($record->getKey());
                            }

                            if ($query->exists()) {
                                $fail('This car is already reserved for the selected period.');
                            }
                        },
                    ])
                    ->required(),

                Textarea::make('message')
                    ->columnSpanFull(),
            ]);
    }
}

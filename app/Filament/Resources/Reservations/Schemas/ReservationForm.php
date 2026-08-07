<?php

namespace App\Filament\Resources\Reservations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

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
                    ->required(),
                DatePicker::make('end_date')
                    ->required(),
                Textarea::make('message')
                    ->columnSpanFull(),
            ]);
    }
}

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
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Filament\Infolists\Components\TextEntry;


class ReservationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([           
                Select::make('car_id')
                    ->label('Car')                  
                    ->relationship(
                        'car',
                        'brand',
                        modifyQueryUsing: fn ($query) => $query->where('available', true)
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->brand . ' ' . $record->model)
                    ->live()
                    ->required(),
                TextInput::make('customer_name')
                    ->required(),
                TextInput::make('customer_email')
                    ->email()
                    ->required(),

                PhoneInput::make('customer_phone')
                    ->label('Customer phone')
                    ->initialCountry('ca')
                    ->separateDialCode()
                    ->formatAsYouType()
                    ->strictMode()                   
                    ->required(),

                DatePicker::make('start_date')
                    ->minDate(today())
                    ->live()
                    ->required(),    

                DatePicker::make('end_date')
                    ->afterOrEqual('start_date')
                    ->live()
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
                
                TextEntry::make('estimated_total')
                    ->label('Estimated total')
                    ->state(function (Get $get) {
                        $carId = $get('car_id');
                        $startDate = $get('start_date');
                        $endDate = $get('end_date');

                        if (! $carId || ! $startDate || ! $endDate) {
                            return 'Select car and dates to calculate';
                        }

                        $car = \App\Models\Car::find($carId);

                        if (! $car) {
                            return '-';
                        }

                        $days = \Carbon\Carbon::parse($startDate)
                            ->diffInDays(\Carbon\Carbon::parse($endDate)) + 1;

                        return '$' . number_format(
                            $days * $car->price_per_day,
                            2
                        );
                    }),

                Textarea::make('message')
                    ->columnSpanFull(),
            ]);
    }
}

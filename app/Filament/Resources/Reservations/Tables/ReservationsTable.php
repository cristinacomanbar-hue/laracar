<?php

namespace App\Filament\Resources\Reservations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;

class ReservationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('start_date', 'asc')
            ->columns([                
                TextColumn::make('id')
                    ->label('No')                  
                    ->sortable(),

               TextColumn::make('car.brand')
                    ->label('Car')
                    ->formatStateUsing(fn ($record) => $record->car->brand . ' ' . $record->car->model)
                    ->sortable() 
                    ->searchable(),
                TextColumn::make('customer_name')
                    ->searchable(),
                TextColumn::make('customer_email')
                    ->searchable(),                        
              
                PhoneColumn::make('customer_phone')
                    ->label('Customer phone')
                    ->displayFormat(PhoneInputNumberType::INTERNATIONAL)
                    ->searchable(),

                TextColumn::make('start_date')
                    ->date('M j')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date('M j')
                    ->sortable(),
                TextColumn::make('days')
                    ->label('Days')
                    ->state(fn ($record) =>
                        $record->start_date->diffInDays($record->end_date) + 1
                ),
                TextColumn::make('total')
                    ->label('Total')
                    ->state(fn ($record) =>
                        ($record->start_date->diffInDays($record->end_date) + 1)
                        * $record->car->price_per_day
                    )
                   ->money('CAD', locale: 'en_CA'),
               TextColumn::make('status')
                    ->label('Status')
                    ->state(function ($record) {
                        $today = today();

                        if ($record->status === 'cancelled') {
                            return 'Cancelled';
                        }

                        if ($record->end_date->lt($today)) {
                            return 'Completed';
                        }

                        if ($record->start_date->lte($today) && $record->end_date->gte($today)) {
                            return 'Active';
                        }

                        return 'Upcoming';
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Active' => 'success',
                        'Upcoming' => 'warning',
                        'Completed' => 'gray',
                        'Cancelled' => 'danger',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
          ->filters([
               

                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'upcoming' => 'Upcoming',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->query(function ($query, array $data) {
                        return match ($data['value'] ?? null) {
                            'active' => $query
                                ->where('status', 'confirmed')
                                ->whereDate('start_date', '<=', today())
                                ->whereDate('end_date', '>=', today()),

                            'upcoming' => $query
                                ->where('status', 'confirmed')
                                ->whereDate('start_date', '>', today()),

                            'completed' => $query
                                ->where('status', 'confirmed')
                                ->whereDate('end_date', '<', today()),

                            'cancelled' => $query
                                ->where('status', 'cancelled'),

                            default => $query,
                        };
                    }),

                SelectFilter::make('car')
                    ->relationship('car', 'brand')
                    ->getOptionLabelFromRecordUsing(
                        fn ($record) => $record->brand . ' ' . $record->model
                    )
                    ->label('Car'),

                Filter::make('start_date')
                    ->form([
                        DatePicker::make('start_date')
                            ->label('Start date'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['start_date'],
                                fn ($query, $date) => $query->whereDate('start_date', $date)
                            );
                    }),    

            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

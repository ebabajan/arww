<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CollectionResource\Pages;
use App\Models\Collection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Pages\Page;

class CollectionResource extends Resource
{
    protected static ?string $model = Collection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // public static function getLabel(): string
    // {
    //     return __('Custom Label');
    // }

    // public static function getPluralLabel(): string
    // {
    //     return __('Custom Labels');
    // }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $get, callable $set) => self::updateValues($get, $set)), 
                Forms\Components\TextInput::make('hawala_amount')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->label("Hawala")
                    ->afterStateUpdated(fn ($state, callable $get, callable $set) => self::updateValues($get, $set)), 
                Forms\Components\DateTimePicker::make('pickup_time'),
                Forms\Components\DateTimePicker::make('rate_time')
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $get, callable $set) => self::updateValues($get, $set)), 
                Forms\Components\TextInput::make('ex_rate_supplier')
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $get, callable $set) => self::updateValues($get, $set)), 
                Forms\Components\TextInput::make('supplier_rate')
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $get, callable $set) => self::updateValues($get, $set)), 
                Forms\Components\TextInput::make('amount_to_pay')
                    ->numeric()
                    ->disabled()
                    ->hidden(fn (Page $livewire) => $livewire instanceof Pages\CreateCollection),
                Forms\Components\TextInput::make('overheads')
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $get, callable $set) => self::updateValues($get, $set)),  
                Forms\Components\TextInput::make('exchange_rate')
                ->numeric()
                ->reactive()
                ->hidden(fn (Page $livewire) => $livewire instanceof Pages\CreateCollection)
                ->afterStateUpdated(fn ($state, callable $get, callable $set) => self::updateValues($get, $set)),
                Forms\Components\TextInput::make('profit')
                    ->numeric(),
                Forms\Components\Select::make('collector_id')
                    ->relationship('collector', 'name')
                    ->required(),
            ]);
    }

    protected static function updateValues(callable $get, callable $set)
    {
        // Update amount_to_pay
        $amount = $get('amount') ?? 0;
        $hawalaAmount = $get('hawala_amount') ?? 0;
        $supplierRate = $get('supplier_rate') ?? 0;
        $exRateSupplier = $get('ex_rate_supplier') ?? 1;
        $overheads = $get('overheads') ?? 0;
        $netAmount = $amount - $hawalaAmount;
        $amountToPay = ($netAmount - ($netAmount * $supplierRate / 100)) * $exRateSupplier;
        $set('amount_to_pay', $amountToPay);

        // Update profit
        $exchangeRate = $get('exchange_rate') ?? 1;
        $collection = new Collection([
            'amount' => $amount,
            'hawala_amount' => $hawalaAmount,
            'supplier_rate' => $supplierRate,
            'exchange_rate' => $exchangeRate,
            'amount_to_pay' => $amountToPay,
            'overheads' => $overheads,
            'collector_id' => $get('collector_id'),
        ]);

        // Ensure the collector is loaded
        if ($collection->collector) {
            $profit = $collection->profit();
            $set('profit', $profit);
        }
    }


    protected static function updateAmountToPay(callable $set)
    {
        return function ($state, callable $get) use ($set) {
            $amount = $get('amount') ?? 0;
            $hawalaAmount = $get('hawala_amount') ?? 0;
            $supplierRate = $get('supplier_rate') ?? 0;
            $exRateSupplier = $get('ex_rate_supplier') ?? 1;

            $netAmount = $amount - $hawalaAmount;
            $amountToPay = ($netAmount - ($netAmount * $supplierRate / 100)) * $exRateSupplier;
            $set('amount_to_pay', $amountToPay);
        };
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('amount')
                    ->label('Hawala')
                    ->sortable(),
                Tables\Columns\TextColumn::make('hawala_amount')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pickup_time')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('rate_time')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('ex_rate_supplier')
                    ->sortable(),
                Tables\Columns\TextColumn::make('supplier_rate')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount_to_pay')
                    ->sortable(),
                Tables\Columns\TextColumn::make('exchange_rate')
                    ->sortable(),
                Tables\Columns\TextColumn::make('profit')
                    ->sortable(),
                Tables\Columns\TextColumn::make('collector.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add any table filters if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver(),
                Tables\Actions\Action::make('Calculate')
                    ->action(function (Collection $record) {
                        $record->calculateProfit();
                    })
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define any relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCollections::route('/'),
            'create' => Pages\CreateCollection::route('/create'),
            //'edit' => Pages\EditCollection::route('/{record}/edit'),
        ];
    }
}

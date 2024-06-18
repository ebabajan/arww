<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CollectionResource\Pages;
use App\Filament\Resources\CollectionResource\RelationManagers;
use App\Models\Collection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CollectionResource extends Resource
{
    protected static ?string $model = Collection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('amount_collected')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('hawala_amount')
                    ->required()
                    ->numeric(),
                Forms\Components\DateTimePicker::make('pickup_time'),
                Forms\Components\TextInput::make('amount_to_pay')
                    ->numeric(),
                Forms\Components\TextInput::make('overheads')
                    ->numeric(),
                Forms\Components\Select::make('supply_id')
                    ->relationship('supply', 'id')
                    ->required(),
                Forms\Components\Select::make('collector_id')
                    ->relationship('collector', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('amount_collected')
                    ->label('Collected')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hawala_amount')
                    ->label("Hawala")
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pickup_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount_to_pay')
                    ->label("Expected Amount")
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('overheads')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('supply.amount')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('collector.name')
                    ->numeric()
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCollections::route('/'),
            'create' => Pages\CreateCollection::route('/create'),
            'edit' => Pages\EditCollection::route('/{record}/edit'),
        ];
    }
}

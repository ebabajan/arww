<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BalanceResource\Pages;
use App\Filament\Resources\BalanceResource\RelationManagers;
use App\Models\Balance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BalanceResource extends Resource
{
    protected static ?string $model = Balance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('supply_id')
                ->relationship('supply', 'id')
                ->required(),
                Forms\Components\TextInput::make('total_payable')
                    ->hidden()
                    ->numeric(),
                Forms\Components\TextInput::make('amount_paid_1')
                    ->label('Paid 1 USD')
                    ->numeric(),
                Forms\Components\TextInput::make('amount_paid_2')
                    ->numeric(),
                Forms\Components\TextInput::make('amount_paid_3')
                    ->numeric(),
                Forms\Components\TextInput::make('amount_paid_4')
                    ->numeric(),
                Forms\Components\TextInput::make('amount_paid_5')
                    ->numeric(),
                Forms\Components\TextInput::make('remaining')
                    ->disabled()
                    ->numeric(),
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supply.amount')
                ->label("Supply GBP")
                ->numeric()
                ->sortable(),
                Tables\Columns\TextColumn::make('total_payable')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount_paid_1')
                    ->label('Paid USD')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount_paid_2')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount_paid_3')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount_paid_4')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('amount_paid_5')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('remaining')
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
            'index' => Pages\ListBalances::route('/'),
            'create' => Pages\CreateBalance::route('/create'),
            'edit' => Pages\EditBalance::route('/{record}/edit'),
        ];
    }
}

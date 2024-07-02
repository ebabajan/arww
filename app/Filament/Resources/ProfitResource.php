<?php 

namespace App\Filament\Resources;

use App\Filament\Resources\ProfitResource\Pages;
use App\Models\Profit;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProfitResource extends Resource
{
    protected static ?string $model = Profit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('collection_id')
                    ->relationship('collection', 'id')
                    ->required(),
                Forms\Components\DatePicker::make('rate_time'),
                Forms\Components\TextInput::make('converted')
                    ->numeric(),
                Forms\Components\TextInput::make('profit')
                    ->numeric(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('collection.amount_collected')
                    ->label('Collection GBP')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rate_time')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('converted')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('profit')
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
                // Add your filters here
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('calculate Profit')
                    ->icon('heroicon-o-calculator')
                    ->action(function ($record) {
                        $record->profit($record);
                    }),
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
            // Define relations here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfits::route('/'),
            'create' => Pages\CreateProfit::route('/create'),
            'edit' => Pages\EditProfit::route('/{record}/edit'),
        ];
    }
}

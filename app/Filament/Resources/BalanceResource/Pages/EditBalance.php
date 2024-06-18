<?php

namespace App\Filament\Resources\BalanceResource\Pages;

use App\Filament\Resources\BalanceResource;
use App\Models\Balance;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;


class EditBalance extends EditRecord
{
    protected static string $resource = BalanceResource::class;

    protected function afterSave(): void
    {
        $this->record->updateRemaining();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

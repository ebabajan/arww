<?php

namespace App\Filament\Resources\CollectionRateResource\Pages;

use App\Filament\Resources\CollectionRateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCollectionRate extends EditRecord
{
    protected static string $resource = CollectionRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

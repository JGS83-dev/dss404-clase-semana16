<?php

namespace App\Filament\Resources\VentasResource\Pages;

use App\Filament\Resources\VentasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVentas extends EditRecord
{
    protected static string $resource = VentasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

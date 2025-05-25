<?php

namespace App\Filament\Resources\SubcateogryResource\Pages;

use App\Filament\Resources\SubcateogryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubcateogry extends EditRecord
{
    protected static string $resource = SubcateogryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

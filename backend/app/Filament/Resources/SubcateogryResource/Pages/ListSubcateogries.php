<?php

namespace App\Filament\Resources\SubcateogryResource\Pages;

use App\Filament\Resources\SubcateogryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubcateogries extends ListRecords
{
    protected static string $resource = SubcateogryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

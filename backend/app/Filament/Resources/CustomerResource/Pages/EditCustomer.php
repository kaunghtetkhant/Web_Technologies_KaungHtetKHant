<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if ($data['password']) {
            $data['password'] = '';
        }
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if($data['password'] == false){
            $data['password'] = bcrypt($data['password']);
        }
        $record->update($data);
        return $record;
    }
}

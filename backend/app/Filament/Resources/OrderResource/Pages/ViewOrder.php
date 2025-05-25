<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;



    public function infolist(Infolist $infolist): Infolist
    {

        return $infolist
            ->schema([
               TextEntry::make('customer.name')->size('md')->label('Customer Name'),
               TextEntry::make('invoice_no')->size('md')->color('primary'),
               TextEntry::make('created_at')->label('Orderdate')->size('md'),
                IconEntry::make('status')->label('Confirm Status')
                   ->url(fn ($record): string => route('filament.admin.resources.orders.edit', ['record' => $record]))
                   ->openUrlInNewTab()
                    ->icon(fn (string $state): string => match ($state) {
                        '0' => 'heroicon-o-pencil',
                        '1' => 'heroicon-o-check',

                    })->color(fn (string $state): string => match ($state) {
                        '0' => 'danger',
                        '1' => 'success',
                    }),
                TextEntry::make('address')->size('md')->label('Delivery Address')

            ]);
    }

    public function getAllRelationManagers(): array
    {
        return [
            OrderResource\RelationManagers\OrderdetailsRelationManager::class
        ];
    }


}

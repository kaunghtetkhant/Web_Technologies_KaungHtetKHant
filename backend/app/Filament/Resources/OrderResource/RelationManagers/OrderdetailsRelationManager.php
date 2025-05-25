<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\Orderdetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderdetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderdetails';

    public function getTableHeading(): string
    {
        return 'Invoice Details'; // Custom heading
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('order_id')
            ->columns([
                Tables\Columns\TextColumn::make('product.name')->searchable(),
                Tables\Columns\ImageColumn::make('product.logo')->label('Logo'),
                Tables\Columns\TextColumn::make('product.price')->label('Unit Price In MMK'),
                Tables\Columns\TextColumn::make('qty'),
                Tables\Columns\TextColumn::make('id')->formatStateUsing(function(Orderdetail $record){
                    return $record->product->price * $record->qty;
                })->label('Sub Total in MMK'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

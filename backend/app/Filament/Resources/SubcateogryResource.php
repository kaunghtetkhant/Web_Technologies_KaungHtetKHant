<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubcateogryResource\Pages;
use App\Filament\Resources\SubcateogryResource\RelationManagers;
use App\Models\Category;
use App\Models\Subcategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubcateogryResource extends Resource
{
    protected static ?string $model = Subcategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-4';

    protected static ?string $navigationGroup = 'Categroy';

    protected static ?string $navigationLabel = 'Subcategory List';
    public static function form(Form $form): Form
    {
        return $form
            ->columns([
                'sm' => 2,
                'xl' => 1
            ])
            ->schema([
                Forms\Components\TextInput::make('name'),
                Forms\Components\FileUpload::make('logo'),
                Forms\Components\Select::make('category_id')
                    ->options(function (): array {
                    return Category::all()->pluck('name', 'id')->all();
                })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('category.name')->label('Category'),
                Tables\Columns\ImageColumn::make('logo'),
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
            'index' => Pages\ListSubcateogries::route('/'),
            'create' => Pages\CreateSubcateogry::route('/create'),
            'edit' => Pages\EditSubcateogry::route('/{record}/edit'),
        ];
    }
}

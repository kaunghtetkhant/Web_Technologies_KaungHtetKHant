<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use function Termwind\render;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationGroup = 'Product List';

    protected static ?string $navigationLabel = 'Products';

    protected static ?int $navigationSort = 3;


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns([
                'sm' => 2,
                'xl' => 1
            ])
            ->schema([
                Forms\Components\TextInput::make('name')->label('Name'),
                Forms\Components\FileUpload::make('logo')->label('Logo'),
                Forms\Components\Grid::make()->columns([
                    'sm' => 2,
                    'xl' => 2
                ])->schema([
                    Forms\Components\Select::make('category_id')->label('Choose Category')
                        ->live()
                        ->options(function () {
                            return Category::pluck('name', 'id')->all();
                        }),
                    Forms\Components\Select::make('subcategory_id')->label('Choose Subcategory')
                        ->required(true)
                        ->options(function (Forms\Get $get){

                            return Subcategory::where('category_id', $get('category_id'))->pluck('name','id');
                        }),
                ]),
                Forms\Components\Grid::make()->columns([
                    'sm' => 2,
                    'xl'=> 2
                ])->schema([
                    Forms\Components\Select::make('brand_id')->label('Choose Brand')
                        ->options(Brand::pluck('name','id')),
                    Forms\Components\TextInput::make('qty')->type('number')->label('In Stock'),

                ]),

                Forms\Components\Grid::make()->columns([
                    'sm' => 2,
                    'xl'=> 2
                ])->schema([
                    Forms\Components\TextInput::make('price')->label('Price per unit')->type('number'),
                    Forms\Components\TextInput::make('discount')->type('number')
                ]),
                Forms\Components\RichEditor::make('description')->label('Description')->toolbarButtons([

                    'blockquote',
                    'bold',
                    'bulletList',
                    'h2',
                    'h3',
                    'italic',
                    'link',
                    'orderedList',
                    'redo',
                    'strike',
                    'underline',
                    'undo',
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->formatStateUsing(fn (Product $record): string => "{$record->name}({$record->code_no})")->color('primary'),
                Tables\Columns\TextColumn::make('brand.name'),
                Tables\Columns\TextColumn::make('subcategory.name'),
                Tables\Columns\TextColumn::make('subcategory.category.name')->label('Main Category'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('qty')->label('In Stock')
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

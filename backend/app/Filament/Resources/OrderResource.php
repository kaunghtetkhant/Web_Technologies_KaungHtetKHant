<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Customer;
use App\Models\Order;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Infolist;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Reports';

    protected static ?string $navigationLabel = 'Orders';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getEloquentQuery(): Builder
    {
        $query = static::getModel()::query();

        if (
            static::isScopedToTenant() &&
            ($tenant = Filament::getTenant())
        ) {
            static::scopeEloquentQueryToTenant($query, $tenant);
        }

        return $query->orderBy('id','desc');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns([

            ])
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->options(Customer::pluck('username','id'))->label('Customer Name'),
                Forms\Components\TextInput::make('invoice_no')
                    ->readOnly(true),
                Forms\Components\TextInput::make('created_at')
                    ->label('Order Date')
                    ->readOnly(true),
                Forms\Components\Checkbox::make('status')
                    ->label('Check if the order is confirmed!')


            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')->label('Customer')->searchable()->placeholder('Search:customer'),
                Tables\Columns\TextColumn::make('invoice_no')->label('Voucher No'),
                Tables\Columns\TextColumn::make('created_at')->date('d-m-Y')->label('Ordered Date')->sortable(),
                Tables\Columns\CheckboxColumn::make('status')
                    ->label('Order Status')->tooltip('Check if order is confirmed')
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }





}

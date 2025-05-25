<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Product;
use App\Models\Subcategory;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomerOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $total_imcome = collect(Orderdetail::with('order')->whereHas('order', fn($q) => $q->where('status',1))->get(['product_id','qty'])->toArray())->sum(function (array $item) {

                $price = Product::find($item['product_id'])->first()->price;
                return $price * $item['qty'];
            });
        return [

            Stat::make('Sub Catgory Count', Subcategory::count())
                ->description(Subcategory::count().' increase')
                ->descriptionIcon('heroicon-m-ellipsis-horizontal')
                ->url(route('filament.admin.resources.subcateogries.index')),
            Stat::make('Pending Orders', Order::where('status', 0)->count())->description('Waiting to deliver')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->url(route('filament.admin.resources.orders.index')),
            Stat::make('Confirmed Orders', Order::where('status', 1)->count())->description($total_imcome.' MMK collected')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->url(route('filament.admin.resources.orders.index')),
            Stat::make('Registered User', Customer::count())
                ->descriptionIcon('heroicon-m-user-plus')->description(Customer::count() .'ppl')
                ->url(route('filament.admin.resources.customers.index')),


        ];
    }
}

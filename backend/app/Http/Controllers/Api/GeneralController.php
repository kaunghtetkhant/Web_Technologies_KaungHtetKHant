<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function categories(Request $request)
    {
        return Category::query()->when($request->search, function($q, $item){
            return $q->where('name', 'like', "%{$item}%");
        })->paginate($request->limit? $request->limit:1000);


    }

    public function subcategories(Request $request)
    {
        return Subcategory::query()->with('category:id,name')->when($request->search, function($q, $item){
            return $q->where('name', 'like', "%{$item}%");
        })->when($request->category_id,function($q,$id){
            return $q->where('category_id', $id);
        })->paginate($request->limit? $request->limit:1000);
    }

    public function brands(Request $request)
    {
        return Brand::query()->when($request->search, function ($q, $item) {
            return $q->where('name', 'like', "%{$item}%");
        })->paginate($request->limit ? $request->limit : 1000);
    }

    public function products(Request $request)
    {
        return Product::query()->with('subcategory:id,name','brand:id,name')
            ->when($request->subcategory_id,function($q,$id){
            return $q->where('subcategory_id', $id);
        })->when($request->brand_id,function($q,$id){
            return $q->where('brand_id', $id);
        })->when($request->search, function($q, $item){
                return $q->where('name', 'like', "%{$item}%")
                    ->orWhere('code_no', 'like', "%{$item}%");
            })
            ->paginate($request->limit? $request->limit:1000);
    }

    public function download($file)
    {
            if(!file_exists(public_path("storage/$file"))){
                return abort(404);
            }
            return response()->file(public_path("storage/$file"));
            // ->deleteFileAfterSend(true);

    }

    public  function productDetails($product)
    {
        $product = Product::where('id',$product)->with('subcategory','subcategory.category','brand')->first();

        return ApiResponseClass::sendResponse($product, 'Prodcut Detail');
    }


}

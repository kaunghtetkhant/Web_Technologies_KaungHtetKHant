<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function details()
    {
        return $this->hasMany(Orderdetail::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {

            $serial = (Order::orderBy('id','desc')->first()->id ?? 0) + 1;


            // Compose the full serial
            $model->invoice_no = 'INV' . '-' . $serial.'-'.date('m-Y');
        });
    }

    public function orderdetails()
    {
        return $this->hasMany(Orderdetail::class);
    }


}

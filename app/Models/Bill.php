<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{

    use SoftDeletes;
    protected $dates=['deleted_at'];
    protected $fillable = [
        'name' , 'phone','type','discount','is_selling', 'user_id','product_id', 'client_id'
    ];

    public function client()
    {
    	return $this->belongsTo(Client::class);
    }
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
    public function product()
    {
    	return $this->belongsToMany(Product::class);
    }
    public function orders()
    {
    	return $this->hasMany(Order::class);
    }

    public function billedProducts(){
        return $this->hasMany(BillsProduct::class,'bill_id')->with('product');
    }
}

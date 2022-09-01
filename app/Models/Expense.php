<?php

namespace App\models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use  SoftDeletes;
    protected $fillable = ['note','value','user_id' ];
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}

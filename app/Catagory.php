<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catagory extends Model
{
		use SoftDeletes;

		protected $dates = ['deleted_at'];
    protected $fillable = [
    "name",
    "description"
    ];

    public function products()
    {
    	return $this->belongsToMany(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';

    // Add your validation rules here
    public static $rules = [
       //
    ];

    // Don't forget to fill this array
    protected $fillable = [];

    protected $guarded = array('id');

    // use boot function to do auto updates of product uuid
    public static function boot()
    {
        parent::boot();

        static::creating(function($product)
        {
            $product->uuid = (string) \Str::uuid();
        });
    }
}

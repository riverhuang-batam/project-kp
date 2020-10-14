<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id', 'name', 'unit_price',
    ];

    public static function rules($merge = [])
    {
        return array_merge(
            [
                'variants.*.name' => 'required',
                'variants.*.unit_price' =>'required|numeric|min:0',
            ]
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

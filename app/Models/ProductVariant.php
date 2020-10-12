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
        'product_id', 'name', 'unit_price', 'quantity', 'sub_total'
    ];

    public static function rules($merge = [])
    {
        return array_merge(
            [
                'product_id' => 'required',
                'name' => 'required',
                'unit_price' => 'nullable',
                'quantity' => 'nullable',
                'sub_total' => 'nullable',
            ]
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

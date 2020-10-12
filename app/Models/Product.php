<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code', 'name', 'sku', 'photo'
    ];

    public static function rules($merge = [])
    {
        return array_merge(
            [
                'name' => 'required',
                'sku' => 'nullable',
                'photo' => 'nullable'
            ]
        );
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code', 'name', 'sku', 'photo'
    ];

    public static function rules($id = 0, $merge = [])
    {
        $codeRule = ['required'];
        if($id == 0) {
            $codeRule[] = Rule::unique('products', 'code');
        } else {
            $codeRule[] = Rule::unique('products', 'code')->ignore($id);
        }
        return array_merge(
            [
                'code' => $codeRule,
                'name' => 'required',
                'sku' => 'nullable',
                'photo' => 'nullable|mimes:jpeg,jpg,png',
            ]
        );
    }

    public function variant()
    {
        return $this->hasMany(ProductVariant::class);
    }
}

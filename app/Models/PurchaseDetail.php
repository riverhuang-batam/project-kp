<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'purchase_id', 'product_id', 'product_variant_id', 'quantity', 'sub_total'
      ];
    
    public static function rules($merge = [])
    {
      return array_merge(
        [
          'purchase_id' => 'required',
          'product_variant_id' => 'required',
          'quantity' => 'required',
        ],
        $merge
      );
    }
}

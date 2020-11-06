<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'sale_id', 'product_id', 'quantity', 'sub_total'
      ];
    public static function rules($merge = [])
    {
      return array_merge(
        [
          'sale_id' => 'required',
          'quantity' => 'required',
        ],
        $merge
      );
    }

    public function sale(){
      return $this->belongTo(Sale::class);
  }
}

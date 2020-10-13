<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code', 'order_date', 'product_total', 'grand_total', 'grand_total(rp)', 'status', 'supplier_id', 'transfer_fee', 'currency_rate', 'transport_company', 'transport_cost', 'remark', 'tracking_number', 'total_pieces_ctn', 'container_number', 'load_date', 'estimated_unload', 'cubication', 'shipping_cost'
      ];
    
    public static function rules($merge = [])
    {
      return array_merge(
        [
          'code' => 'required|unique:purchases',
          'order_date' => 'required|date',
          'product_total' => 'required|numeric',
          'grand_total' => 'required|numeric',
          'grand_total(rp)' => 'required|numeric',
          'status' => 'required|integer',
          'supplier_id' => 'required|integer',
          'transfer_fee' => 'required|numeric',
          'currency_rate' => 'required|numeric',
        ],
        $merge
      );
    }
  
    public static function getMarkingName($id){
      try {
        return Marking::find($id)->name;
      } catch (\Throwable $th) {
        return "Marking was delete from the list";
      }
    }
  
    public static function getItemName($id){
      try {
        return Item::find($id)->name;
      } catch (\Throwable $th) {
        return "Item was delete from the list";
      }
    }

    // public function items(){
    //   return $this->belongTo(Item::class);
    // }

    // public function marking(){
    //   return $this->belongTo(Marking::class);
    // }

    public function payment(){
      return $this->hasMany(Payment::class);
    }

    protected static function boot(){
      parent::boot();

      static::deleting(function($purchase){
        foreach($purchase->payment()->get() as $p){
          $p->delete();
        }
      });
    }

}

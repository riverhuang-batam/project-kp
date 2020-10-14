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
        'code', 'order_date', 'product_total', 'grand_total', 'grand_total_rp', 'status', 'supplier_id', 'transfer_fee', 'currency_rate', 'transport_company', 'transport_cost', 'remarks', 'tracking_number', 'total_piece_ctn', 'container_number', 'load_date', 'estimated_unload_date', 'cubication', 'shipping_cost'
      ];
    
    public static function rules($merge = [])
    {
      return array_merge(
        [
          'code' => 'required',
          'order_date' => 'required|date',
          'product_total' => 'required|numeric|gt:0',
          'grand_total' => 'required|numeric|gt:0',
          'grand_total_rp' => 'required|numeric|gt:0',
          'status' => 'required',
          'supplier_id' => 'required',
          'transfer_fee' => 'required|numeric|min:0',
          'currency_rate' => 'required|numeric|gt:0',
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

    public static function getSupplierName($id){
      try {
        return Supplier::find($id)->name;
      } catch (\Throwable $th) {
        return "Item was delete from the list";
      }
    }

    public static function getProductVariantName($id){
      try {
        return ProductVariant::find($id)->name;
      } catch (\Throwable $th) {
        return "Item was delete from the list";
      }
    }

    public function payment(){
      return $this->hasMany(Payment::class);
    }

    public function purchaseDetail(){
      return $this->hasMany(PurchaseDetail::class);
    }

    protected static function boot(){
      parent::boot();

      static::deleting(function($purchase){
        foreach($purchase->payment()->get() as $p){
          $p->delete();
        }

        foreach($purchase->purchaseDetail()->get() as $pd){
          $pd->delete();
        }
      });
    }

}

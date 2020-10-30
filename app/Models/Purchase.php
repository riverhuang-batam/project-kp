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
        'code', 'order_date', 'grand_total', 'supplier_id', 'remarks',
      ];
    
    public static function rules($merge = [])
    {
      return array_merge(
        [
          'code' => 'required',
          'order_date' => 'required|date',
          'grand_total' => 'required|numeric|min:0',
          'supplier_id' => 'required',
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

    public function supplier(){
      return $this->hasOne(Supplier::class);
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

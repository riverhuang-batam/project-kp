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
        'purchase_code', 'date', 'marking', 'item_id', 'quantity', 'ctns', 'volume', 'pl', 'resi', 'expected_date', 'status', 'remarks'
      ];
    
    public static function rules($merge = [])
    {
      return array_merge(
        [
          'date' => 'required',
          'marking' => 'required',
          'item_id' => 'required',
          'quantity' => 'required',
          'status' => 'required',
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

    public function items(){
      return $this->belongTo(Item::class);
    }

    public function marking(){
      return $this->belongTo(Marking::class);
    }

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

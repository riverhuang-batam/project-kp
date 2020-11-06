<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
	use HasFactory;
	use SoftDeletes;

	protected $fillable = [
		'code', 'order_date', 'grand_total', 'full_name', 'address', 'remarks',
	];

	public static function rules($merge = [])
	{
	  return array_merge(
		[
			'full_name' => 'required',
			'address' => 'required',
			'code' => 'required',
			'order_date' => 'required|date',
			'grand_total' => 'required|numeric|min:0',
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
  
	  public static function getUserName($id){
		try {
		  return User::find($id)->name;
		} catch (\Throwable $th) {
		  return "Item was delete from the list";
		}
	  }
  
	  public function payment(){
		return $this->hasMany(Payment::class);
	  }
  
	  public function saleDetail(){
		return $this->hasMany(SaleDetail::class);
	  }
  
	  protected static function boot(){
		parent::boot();
  
		static::deleting(function($sale){
		//   foreach($sale->payment()->get() as $p){
		// 	$p->delete();
		//   }
  
		  foreach($sale->saleDetail()->get() as $pd){
			$pd->delete();
		  }
		});
	  }
  
}

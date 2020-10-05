<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $fillable = [
    'date', 'marking', 'items', 'qty', 'ctns', 'volume', 'pl', 'resi', 'expected_date', 'status', 'invoice', 'remarks', 'purchase_code'
  ];

  public static function rules($merge = [])
  {
    return array_merge(
      [
        'date' => 'required',
        'marking' => 'required',
        'items' => 'required',
        'qty' => 'required',
        'expected_date' => 'required',
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
}
 
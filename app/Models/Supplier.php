<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['code', 'name'];

    public static function rules($merge = [])
    {
        return array_merge(
            [
                'code' => 'required',
                'name' => 'required'
            ],
            $merge
        );
    }

    public function purchase(){
        return $this->hasMany(Purchase::class);
    }

    protected static function boot(){
        parent::boot();

        static::deleting(function($supplier){
            foreach($supplier->purchase()->get() as $purchase){
                $purchase->delete();
            }
        });
    }
}

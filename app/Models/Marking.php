<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marking extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name'];

    public static function rules($merge = [])
    {
        return array_merge(
            [
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

        static::deleting(function($marking){
            foreach ($marking->purchase()->get() as $pc){
                $pc->delete();
            }
        });
    }
}
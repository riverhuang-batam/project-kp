<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['order_id', 'type', 'file_name'];

    public static function rules($merge = [])
    {
        return array_merge(
            [
                'order_id' => 'required',
                'type' => 'required'
            ],
            $merge
            );
    }

}

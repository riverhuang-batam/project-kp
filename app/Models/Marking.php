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
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name'];

    public static function rules($merge = [])
    {
        return array_merge(
            [
                'code' => 'required',
                'name' => 'required',
            ],
            $merge
        );
    }
}

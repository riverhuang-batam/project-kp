<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabaRugi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'laba_rugi';

    protected $fillable = ['laba_rugi'];
}

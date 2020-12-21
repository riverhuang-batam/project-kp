<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurnal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'transaction_no', 'transaction_date', 'total_debit', 'total_credit',
    ];

    public static function rules($merge = [])
    {
        return array_merge(
            [
                'transaction_date' => 'required',
                'total_debit' => 'numeric|nullable',
                'total_credit' => 'numeric|nullable',
            ],
            $merge
        );
    }

    public function jurnalDetails()
    {
        return $this->hasMany(JurnalDetail::class);
    }
}

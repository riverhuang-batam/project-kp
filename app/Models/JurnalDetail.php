<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JurnalDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'akun_id', 'jurnal_id', 'debit', 'credit', 'description',
    ];

    public static function rules($merge = [])
    {
        return array_merge(
            [
                'akuns.*.akun_id' => 'required',
                'akuns.*.debit' => 'numeric|nullable',
                'akuns.*.credit' => 'numeric|nullable',
                'akuns.*.description' => 'nullable',
            ],
            $merge
        );
    }

    public function jurnal()
    {
        return $this->belongsTo(Jurnal::class);
    }
}

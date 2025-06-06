<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PeriodeModel extends Model
{
    use HasFactory;

    protected $table = 'table_periode';

    protected $primaryKey = 'periode_id';

    protected $fillable = [ 
        'nama_periode',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    public function rekomendasi(): HasOne {
        return $this->hasOne(RekomendasiModel::class, 'periode_id', 'periode_id');
    }
}

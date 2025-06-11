<?php

namespace App\Models;

use App\Models\SPK\AlternatifModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RekomendasiModel extends Model
{
    use HasFactory;

    protected $table = 'table_rekomendasi';

    protected $primaryKey = 'rekomendasi_id';

    protected $fillable = [
        'alternatif_id',
        'nilai_akhir',
        'ranking',
        'periode_id'
    ];

    public function periode(): BelongsTo {
        return $this->belongsTo(PeriodeModel::class, 'periode_id', 'periode_id');
    }

    public function alternatif(): HasMany {
        return $this->hasMany(AlternatifModel::class, 'alternatif_id', 'alternatif_id');
    }
}

<?php

namespace App\Models;

use App\Models\SPK\AlternatifModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function alternatif(): BelongsTo {
        return $this->belongsTo(AlternatifModel::class, 'alternatif_id', 'alternatif_id');
    }

    public function umpanBalik(): HasMany {
        return $this->hasMany(UmpanBalikModel::class, 'rekomendasi_id', 'rekomendasi_id');
    }
}

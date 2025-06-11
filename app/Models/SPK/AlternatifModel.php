<?php

namespace App\Models\SPK;

use App\Models\LaporanModel;
use App\Models\RekomendasiModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlternatifModel extends Model
{
    use HasFactory;

    protected $table = 'table_alternatif';
    protected $primaryKey = 'alternatif_id';

    protected $fillable = ['alternatif_kode', 'laporan_id'];

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id', 'laporan_id');
    }

    public function penilaian()
    {
        return $this->hasMany(PenilaianModel::class, 'alternatif_id');
    }

    public function rekomendasi(): BelongsTo {
        return $this->belongsTo(RekomendasiModel::class, 'fasilitas_id', 'fasilitas_id');
    }
}

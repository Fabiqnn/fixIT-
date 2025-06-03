<?php

namespace App\Models\SPK;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KriteriaModel extends Model
{
    use HasFactory;

    protected $table = 'table_kriteria';
    protected $primaryKey = 'kriteria_id';

    protected $fillable = ['nama_kriteria', 'bobot', 'tipe_kriteria'];

    public function penilaian()
    {
        return $this->belongsTo(PenilaianModel::class, 'penilaian_id');
    }
}

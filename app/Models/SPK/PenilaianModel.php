<?php

namespace App\Models\SPK;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PenilaianModel extends Model
{
    use HasFactory;

    protected $table = 'table_penilaian';
    protected $primaryKey = 'penilaian_id';

    protected $fillable = ['alternatif_id', 'kriteria_id',  'nilai'];

    public function alternatif(): BelongsTo 
    {
        return $this->belongsTo(AlternatifModel::class, 'alternatif_id', 'alternatif_id');
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(KriteriaModel::class, 'kriteria_id', 'kriteria_id');
    } 
}

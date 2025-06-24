<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UmpanBalikModel extends Model
{
    use HasFactory;

    protected $table = 'table_umpanbalik';

    protected $primaryKey = 'umpanbalik_id';

    protected $fillable = [
        'rekomendasi_id',
        'no_induk',
        'komentar',
        'skala_kepuasan',
        'picture'
    ];

    public function rekomendasi(): BelongsTo
    {
        return $this->belongsTo(RekomendasiModel::class, 'rekomendasi_id', 'rekomendasi_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModels::class, 'no_induk', 'no_induk');
    }
}

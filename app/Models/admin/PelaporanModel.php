<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PelaporanModel extends Model
{
    use HasFactory;

    protected $table = 'table_laporan';
    protected $primaryKey = 'laporan_id';

    protected $fillable = ['deskripsi_kerusakan', 'status_perbaikan', 'status_acc'];

    public function fasilitas(): BelongsTo
    {
        return $this->BelongsTo(FasilitasModel::class, 'fasilitas_id', 'fasilitas_id');
    }
}

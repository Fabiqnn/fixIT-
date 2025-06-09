<?php

namespace App\Models;

use App\Models\admin\FasilitasModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SPK\AlternatifModel;



class LaporanModel extends Model
{
    use HasFactory;
    protected $table = 'table_laporan';

    protected $primaryKey = 'laporan_id';

    protected $fillable = [
        'kode_laporan',
        'no_induk',
        'fasilitas_id',
        'tanggal_laporan',
        'deskripsi_kerusakan',
        'status_perbaikan',
        'status_acc',
        'foto_kerusakan'
    ];

    public $timestamps = false;

    public function fasilitas()
    {
        return $this->belongsTo(FasilitasModel::class, 'fasilitas_id');
    }
    public function user()
    {
        return $this->belongsTo(UserModels::class, 'no_induk');
    }
    public function rekomendasi()
    {
        return $this->hasOneThrough(
            RekomendasiModel::class,
            AlternatifModel::class,
            'laporan_id',
            'alternatif_id',
            'laporan_id',
            'alternatif_id'
        )->with('periode');
    }
}

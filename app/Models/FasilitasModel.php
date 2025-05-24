<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use function PHPUnit\Framework\returnSelf;

class FasilitasModel extends Model
{
    use HasFactory;

    protected $table = 'table_fasilitas';
    protected $primaryKey = 'fasilitas_id';

    protected $fillable = ['ruangan_id', 'nama_fasilitas', 'kode_fasilitas', 'tanggal_pengadaan', 'status'];

    public function ruangan(): BelongsTo {
        return $this->belongsTo(RuanganModel::class, 'ruangan_id', 'id_ruangan');
    }

    public function getGedungName(): string {
        return $this->ruangan->getGedungName();
    }

    
}

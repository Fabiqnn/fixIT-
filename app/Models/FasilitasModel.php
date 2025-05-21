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

    protected $fillable = ['gedung_id', 'nama_fasilitas', 'kode_fasilitas', 'tanggal_pengadaan', 'status', 'lantai', 'ruangan'];

    public function Gedung(): BelongsTo {
        return $this->belongsTo(GedungModel::class, 'gedung_id', 'gedung_id');
    }
    
}

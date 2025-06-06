<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RuanganModel extends Model
{
    use HasFactory;

    protected $table = 'table_ruangan';
    protected $primaryKey = 'id_ruangan';

    protected $fillable = ['kode_ruangan', 'keterangan', 'gedung_id', 'id_lantai'];

    public function gedung(): BelongsTo {
        return $this->belongsTo(GedungModel::class, 'gedung_id', 'gedung_id');
    }
    
    public function lantai():BelongsTo {
        return $this->belongsTo(LantaiModel::class, 'id_lantai', 'id_lantai');
    }

    public function getGedungName(): string {
        return $this->gedung->gedung_nama;
    }

    public function getLantaiName(): string {
        return $this->lantai->nama_lantai;
    }

}

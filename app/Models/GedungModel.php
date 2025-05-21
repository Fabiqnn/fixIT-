<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GedungModel extends Model
{
    use HasFactory;

    protected $table = 'table_gedung';
    protected $primaryKey = 'gedung_id';

    protected $fillable = ['gedung_nama'];

    public function fasilitas(): BelongsTo {
        return $this->belongsTo(FasilitasModel::class);
    }
}

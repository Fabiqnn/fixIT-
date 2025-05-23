<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LantaiModel extends Model
{
    use HasFactory;

    protected $table = 'table_lantai';
    protected $primaryKey = 'id_lantai';

    protected $fillable = ['nama_lantai', 'gedung_id'];

    public function gedung(): BelongsTo {
        return $this->belongsTo(GedungModel::class, 'gedung_id', 'gedung_id');
    }
}

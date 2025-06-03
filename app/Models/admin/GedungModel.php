<?php

namespace App\Models\admin;

use App\Models\admin\RuanganModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GedungModel extends Model
{
    use HasFactory;

    protected $table = 'table_gedung';
    protected $primaryKey = 'gedung_id';

    protected $fillable = ['gedung_nama'];
    public $timestamps = false;


    public function ruangan(): HasMany
    {
        return $this->hasMany(RuanganModel::class, 'gedung_id', 'gedung_id');
    }
    public function lantai(): HasMany
    {
        return $this->hasMany(LantaiModel::class, 'gedung_id', 'gedung_id');
    }
}

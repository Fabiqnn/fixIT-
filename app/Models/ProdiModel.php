<?php

namespace App\Models;

use App\Models\JurusanModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserModels;


class ProdiModel extends Model
{
    protected $table = 'table_prodi';

    protected $primaryKey = 'prodi_id';

    protected $fillable = [
        'prodi_nama',
        'jurusan_id'
    ];

    public $timestamps = true;

    // Relasi ke jurusan
    public function jurusan()
    {
        return $this->belongsTo(JurusanModel::class, 'jurusan_id', 'jurusan_id');
    }

    // Relasi ke user (jika 1 prodi banyak user)
    public function users()
    {
        return $this->hasMany(UserModels::class, 'prodi_id', 'prodi_id');
    }
}

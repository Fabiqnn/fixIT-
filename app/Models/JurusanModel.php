<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserModels;


class JurusanModel extends Model
{
    protected $table = 'table_jurusan'; // sesuaikan dengan nama tabel

    protected $primaryKey = 'jurusan_id';

    protected $fillable = [
        'jurusan_nama'
    ];

    public $timestamps = true;

    // Relasi ke prodi
    public function prodi()
    {
        return $this->hasMany(ProdiModel::class, 'jurusan_id', 'jurusan_id');
    }

    // Relasi ke user (jika ada)
    public function users()
    {
        return $this->hasMany(UserModels::class, 'jurusan_id', 'jurusan_id');
    }
}

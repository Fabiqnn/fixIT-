<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserModels extends Authenticatable
{
    use Notifiable;

    protected $table = 'table_users';
    protected $primaryKey = 'no_induk';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'no_induk',
        'password',
        'level_id',
        'prodi_id',
        'jurusan_id',
        'nama_lengkap',
        'email',
        'nomor_telp',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'level_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(JurusanModel::class, 'jurusan_id');
    }

    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'prodi_id');
    }

    public function UmpanBalik(): HasMany {
        return $this->hasMany(UmpanBalikModel::class, 'no_induk', 'no_induk');
    }
}

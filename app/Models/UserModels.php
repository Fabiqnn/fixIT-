<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserModels extends Authenticatable
{
    use Notifiable;

    protected $table = 'table_users'; 
    protected $primaryKey = 'user_id';

    public $timestamps = true; 

    protected $fillable = [
        'level_id',
        'prodi_id',
        'jurusan_id',
        'username',
        'password',
        'nama_lengkap',
        'email',
        'nomor_telp',
        'nip',
        'nim',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function username()
    {
        return 'username';
    }
}

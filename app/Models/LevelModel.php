<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    use HasFactory;
    protected $table = 'table_level';

    protected $fillable = [
        'level_nama'
    ];
    public $timestamps = true;
    protected $primaryKey = 'level_id';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_matrix extends Model
{
    use HasFactory;

    protected $table = 'tb_matrix';

    protected $fillable = [
        'panjang',
        'tinggi',
    ];

    public $timestamps = true;
}

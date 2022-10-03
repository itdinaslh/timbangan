<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $connection = 'bg_db';
    protected $table = 'absensi';
    public $timestamps = false;
}

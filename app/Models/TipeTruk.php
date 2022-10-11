<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeTruk extends Model
{
    protected $connection = 'bg_db';
    protected $table = 'tipe_truk';
    public $timestamps = false;
}

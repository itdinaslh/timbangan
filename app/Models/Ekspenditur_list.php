<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekspenditur_list extends Model
{
    protected $connection = 'bg_db';
    protected $table = 'ekspenditur_list';
    public $timestamps = false;
}

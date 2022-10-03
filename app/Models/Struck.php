<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Struck extends Model
{
    protected $connection = 'bg_db';
    protected $table = 'transaction_log';
    public $timestamps = false;
}

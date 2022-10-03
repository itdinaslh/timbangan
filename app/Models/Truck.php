<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $connection = 'bg_db';
    protected $table = 'rfid_card';
    public $timestamps = false;
}

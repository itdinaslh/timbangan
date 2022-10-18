<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Truck;
use App\Models\Ekspenditur_list;
use App\Models\Absensi;
use Auth;
use DateTime;
use Carbon\Carbon;

class InfoController extends Controller
{
    public function truck()
    {
        return view('admin.info.truck');
    }

    public function ekspenditur()
    {
        return view('admin.info.ekspenditur');
    }
}

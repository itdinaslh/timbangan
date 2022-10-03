<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function setting()
    {
        $ipmasuk = DB::connection('bg_db')->table('setting')->where('setting_name', '=', 'ip_scale_masuk')->select('setting_value')
            ->first();
        $ipkeluar = DB::connection('bg_db')->table('setting')->where('setting_name', '=', 'ip_scale_keluar')->select('setting_value')
            ->first();
        $portmasuk = DB::connection('bg_db')->table('setting')->where('setting_name', '=', 'port_scale_masuk')->select('setting_value')
            ->first();
        $portkeluar = DB::connection('bg_db')->table('setting')->where('setting_name', '=', 'port_scale_keluar')->select('setting_value')
            ->first();
        $mode_timbangan = DB::connection('bg_db')->table('setting')->where('setting_name', '=', 'mode_timbangan')->select('setting_value')
            ->first();
        return view('setting',['ipmasuk'=> $ipmasuk, 'ipkeluar'=>$ipkeluar, 'portmasuk'=>$portmasuk, 'portkeluar'=>$portkeluar, 'mode_timbangan'=>$mode_timbangan]);
    }

    public function settingstore(Request $v) {

        $updateipmasuk = DB::connection('bg_db')->table('setting')->where('setting_name', '=', 'ip_scale_masuk')->update(['setting_value' => $v->ipmasuk]);

        $updateipkeluar = DB::connection('bg_db')->table('setting')->where('setting_name', '=', 'ip_scale_keluar')->update(['setting_value' => $v->ipkeluar]);

        $updateportmasuk = DB::connection('bg_db')->table('setting')->where('setting_name', '=', 'port_scale_masuk')->update(['setting_value' => $v->portmasuk]);

        $updateportkeluar = DB::connection('bg_db')->table('setting')->where('setting_name', '=', 'port_scale_keluar')->update(['setting_value' => $v->portkeluar]);
        
        $get = DB::connection('bg_db')->table('setting')->where('setting_name', '=', 'mode_timbangan')->update(['setting_value' => $v->mode_timbangan]);

        return ['success' => true];
    }
}

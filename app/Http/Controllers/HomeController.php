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

    //Modul Timbangan
    public function socket($type)
    {
        //return "35000";
        if ($type == "masuk")
        {
            ini_set('default_socket_timeout', "2");
            //$host = "192.168.1.27"; host masuk socket
            $dbh = DB::table('setting')->where('setting_name', '=', 'ip_scale_masuk')
                ->first();
            $dbp = DB::table('setting')->where('setting_name', '=', 'port_scale_masuk')
                ->first();
            $host = $dbh->setting_value;
            $port = $dbp->setting_value;
            $socket = @socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
            $bind = @socket_bind($socket, $host);
            @socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array(
                "sec" => 4,
                "usec" => 0
            ));
            @socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array(
                "sec" => 4,
                "usec" => 0
            ));
            $result = @socket_connect($socket, $host, $port) or die("0");
            $input = @socket_read($socket, 1024);
            $output = preg_replace('/[^0-9]/', '', $input);
            return $output * 1;
            socket_close($socket);
        }
        else if ($type == "keluar")
        {
            ini_set('default_socket_timeout', "2");
            $dbh = DB::table('setting')->where('setting_name', '=', 'ip_scale_keluar')
                ->first();
            $dbp = DB::table('setting')->where('setting_name', '=', 'port_scale_keluar')
                ->first();
            $host = $dbh->setting_value;
            $port = $dbp->setting_value;
            $socket = @socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
            $bind = @socket_bind($socket, $host);
            @socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array(
                "sec" => 4,
                "usec" => 0
            ));
            @socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array(
                "sec" => 4,
                "usec" => 0
            ));
            $result = @socket_connect($socket, $host, $port) or die("0");
            $input = @socket_read($socket, 1024);
            $output = preg_replace('/[^0-9]/', '', $input);
            return $output * 1;
            socket_close($socket);
        }
        return "No Action";
    }
}

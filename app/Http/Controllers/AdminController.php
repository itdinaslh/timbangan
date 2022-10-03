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

class AdminController extends Controller
{
    //
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function ChangePassword(Request $v) {
        $user = User::findOrFail($v->myID);

        $user->password = Hash::make($v->passwd);

        return ['success' => true];
    }

    public function AdminDashboard() {
        if (Auth::user()->hasRole(['Admin'])) {
            return view('admin.index');
        } elseif (Auth::user()->hasRole(['Admin'])) {    
            return '/ascan/home';
        } 
        elseif (Auth::user()->hasRole(['manualmasuk'])) {
            $setting = DB::connection('bg_db')->table('setting')->where('setting_name', '=', 'mode_timbangan')
            ->first();
            $getnopol = DB::connection('bg_db')->table('display_transaction')->where('tipe', '=', 'masuk')
                ->first();
            $transaction = DB::connection('bg_db')->select(DB::raw("select * from transaction_log where stat_timbang = '0' and trans_date between date_sub(NOW(), INTERVAL 24 hour) and NOW() ORDER BY `transaction_log`.`trans_date` DESC"));
            $socket = "50000";
            $date = date('Y-m-d');
            $groupname = DB::connection('bg_db')->table('group_user')->join('group_list', 'group_user.group_id', '=', 'group_list.id')
                ->select('group_list.groupname', 'group_user.id', 'group_user.group_id')
                ->where('group_user.user_id', '=', Auth::user()
                ->id)
                ->first();
            $cek = Absensi::where('groupuser_id', '=', 2)
                ->where('tanggal_kehadiran', '=', $date)->get();
            if ($cek == "[]")
            {
                $getgroup = DB::connection('bg_db')->table('group_user')->join('group_list', 'group_user.group_id', '=', 'group_list.id')
                    ->select('group_user.id', 'group_user.group_id')
                    ->where('group_user.group_id', '=', 2)
                    ->get();
                foreach ($getgroup as $p)
                {
                    $save = new Absensi;
                    $save->groupuser_id = $p->id;
                    $save->tanggal_kehadiran = date('Y-m-d');
                    $save->save();
                }
            }
            $existinggroup = DB::connection('bg_db')->table('group_user')->where('user_id', '=', Auth::user()
                ->id)
                ->first();
            $group = DB::connection('bg_db')->table('group_user')->join('users', 'group_user.user_id', '=', 'users.id')
                ->join('group_list', 'group_user.group_id', '=', 'group_list.id')
                ->join('absensi', 'group_user.id', '=', 'absensi.groupuser_id')
                ->select('group_user.*', 'group_list.groupdivision', 'group_list.groupname', 'users.name', 'absensi.kehadiran')
                ->where('group_list.groupdivision', '=', 1)
                ->where('group_id', '=', 2)
                ->where('tanggal_kehadiran', '=', $date)->get();

            $daftarblock = Ekspenditur_list::where('status', '!=', "")->where('status', '!=', 'none')
                ->get();
            $blokir = DB::connection('bg_db')->table('rfid_card')->join('ekspenditur_list', 'rfid_card.ekspenditur', '=', 'ekspenditur_list.id')
                ->select('rfid_card.*', 'ekspenditur_list.ekspenditur_name', 'ekspenditur_list.status', 'ekspenditur_list.tgl_izin')
                ->where('ekspenditur_list.status', '!=', '')
                ->where('ekspenditur_list.status', '!=', 'none')
                ->get();
            $listdoor = Truck::select('door_id')->get();
            return view('admin.timbanganmasuk', compact('transaction', 'socket', 'listdoor', 'daftarblock', 'group', 'groupname', 'blokir', 'getnopol', 'setting'));
        } 
        elseif (Auth::user()->hasRole(['manualkeluar'])) {
            $setting = DB::connection('bg_db')->table('setting')->where('setting_name', '=', 'mode_timbangan')
            ->first();
            $getnopol = DB::connection('bg_db')->table('display_transaction')->where('tipe', '=', 'keluar')
                ->first();
            $transaction =  DB::connection('bg_db')->select(DB::raw("select * from transaction_log where trans_date_after between date_sub(NOW(), INTERVAL 24 hour) and NOW() ORDER BY trans_date_after DESC"));
            $socket = "50000";
            $date = date('Y-m-d');
            $groupname = DB::connection('bg_db')->table('group_user')->join('group_list', 'group_user.group_id', '=', 'group_list.id')
                ->select('group_list.groupname', 'group_user.id', 'group_user.group_id')
                ->where('group_user.user_id', '=', Auth::user()
                ->id)
                ->first();
            $cek = Absensi::where('groupuser_id', '=', 2)
                ->where('tanggal_kehadiran', '=', $date)->get();
            if ($cek == "[]")
            {
                $getgroup = DB::connection('bg_db')->table('group_user')->join('group_list', 'group_user.group_id', '=', 'group_list.id')
                    ->select('group_user.id', 'group_user.group_id')
                    ->where('group_user.group_id', '=', 2)
                    ->get();
                foreach ($getgroup as $p)
                {
                    $save = new Absensi;
                    $save->groupuser_id = $p->id;
                    $save->tanggal_kehadiran = date('Y-m-d');
                    $save->save();
                }
            }
            $group = DB::connection('bg_db')->table('group_user')->join('users', 'group_user.user_id', '=', 'users.id')
                ->join('group_list', 'group_user.group_id', '=', 'group_list.id')
                ->join('absensi', 'group_user.id', '=', 'absensi.groupuser_id')
                ->select('group_user.*', 'group_list.groupdivision', 'group_list.groupname', 'users.name', 'absensi.kehadiran')
                ->where('group_list.groupdivision', '=', 2)
                ->where('tanggal_kehadiran', '=', $date)->get();
            $blokir = DB::connection('bg_db')->table('rfid_card')->join('ekspenditur_list', 'rfid_card.ekspenditur', '=', 'ekspenditur_list.id')
                ->select('rfid_card.*', 'ekspenditur_list.ekspenditur_name', 'ekspenditur_list.status', 'ekspenditur_list.tgl_izin')
                ->where('ekspenditur_list.status', '!=', '')
                ->where('ekspenditur_list.status', '!=', 'none')
                ->get();
            $listdoor = Truck::select('door_id')->get();
            return view('admin.timbangankeluar', compact('transaction', 'socket', 'listdoor', 'groupname', 'group', 'blokir', 'getnopol', 'setting'));
            // return view('admin.timbangkeluar');
        }
        elseif (Auth::user()->hasRole(['opsj'])){
            return '/adminspj';
        }
        elseif (Auth::user()->hasRole(['validasi'])){
            return '/home';
        }
        elseif (Auth::user()->hasRole(['pegawai'])){
            return '/pegawai';
        }
    }

    public function GantiPassword(Request $request) {
        if ($request->id == 0) {
            $user = new User;
        } else {
            $user = User::findOrFail($request->id);
        }

        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();
        return back();
    }

    public function getdoorid(Request $request)
    {
        $data = DB::select("select * from transaction_log where door_id = '" . $request->getdata . "' and DATE(trans_date_after) between now() - INTERVAL 1 MONTH AND now() and stat_timbang = '1' and weight - weight_after not between -100 and 100 order by trans_date_after desc LIMIT 30");

        $door = DB::connection('bg_db')->table('rfid_card')->leftJoin('tipe_truk', 'rfid_card.tipe', '=', 'tipe_truk.initial')
            ->select('rfid_card.avg_in', 'rfid_card.truck_id', 'tipe_truk.tipe', 'rfid_card.door_id')
            ->where('door_id', '=', $request->getdata)
            ->first();

        $weight_total = null;
        $weight_after_total = null;
        foreach ($data as $rowavg)
        {
            $weight_total += $rowavg->weight;
            $weight_after_total += $rowavg->weight_after;
        }
        $getcount = count($data);
        if ($getcount != 0) $total = round($weight_total / $getcount / 10) * 10;
        else $total = 0;
        return "<div class='row'><div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'><div class='nk-int-mk'><h2>Berat</h2></div><div class='form-group ic-cmp-int'><div class='form-ic-cmp'></div><div class='nk-int-st'><input type='text' name='beratmasuk' class='form-control' value='" . $total . "'></div></div></div></div><div class='row' style='padding-top:30px;padding-left:40px;'><div class='col-md-4'>Berat Rata-rata 30 Transaksi</div><div class='col-md-4'>:</div><div class='col-md-4'><div class='form-group ic-cmp-int'><input type='number' name='avg' class='form-control' value='" . $total . "' readonly></div></div></div><div class='row' style='padding-top:30px;padding-left:40px;'><div class='col-md-4'>Nomor polisi</div><div class='col-md-4'>:</div><div class='col-md-4'><div class='form-group ic-cmp-int'><input type='text' name='truck_id' class='form-control' readonly value='" . $door->truck_id . "'></div></div></div><div class='row' style='padding-top:30px;padding-bottom:50px;padding-left:40px;'><div class='col-md-4'>Tipe</div><div class='col-md-4'>:</div><div class='col-md-4'><div class='form-group ic-cmp-int'><input type='text' name='tipe' class='form-control' readonly value='" . $door->tipe . "'></div></div></div>";

    }

    public function getberat(Request $request)
    {

        if ($request->getdata != null)
        {
            $data = DB::select("select * from transaction_log where door_id = '" . $request->getdata . "' and DATE(trans_date_after) between now() - INTERVAL 1 MONTH AND now() and stat_timbang = '1' and weight - weight_after not between -100 and 100 order by trans_date_after asc LIMIT 30");

            $weight_total = null;
            $kir = Truck::where('door_id', '=', $request->getdata)
                ->first();
            $weight_after_total = null;
            foreach ($data as $rowavg)
            {
                $weight_total += $rowavg->weight;
                $weight_after_total += $rowavg->weight_after;
            }
            $getcount = count($data);
            if ($getcount != 0) $total = round($weight_total / $getcount / 10) * 10;
            else $total = 0;
            return "<input type='text' id='show' name='avg_sm' class='form-control' value='" . $total . "' style='display:block'><div class='row' style='padding-top:30px;padding-left:0px;padding-bottom:30px;'><div class='col-md-2'>KIR</div><div class='col-md-1'>:</div><div class='col-md-8'>" . $kir->kir . "</div></div>
            <button type='button' class='btn btn-default' style='display:block;margin-top:25px;' id='rata2' onclick='getberat()'>Berat Rata-rata</button>";
        }
        else
        {
            return "Input Nomor Pintu";
        }
    }

    //Modul Timbangan
    public function socket($type)
    {
        //return "35000";
        if ($type == "masuk")
        {
            ini_set('default_socket_timeout', "2");
            //$host = "192.168.1.27"; host masuk socket
            $dbh = DB::connection('bg_db')->table('setting')->where('setting_name', '=', 'ip_scale_masuk')
                ->first();
            $dbp = DB::connection('bg_db')->table('setting')->where('setting_name', '=', 'port_scale_masuk')
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
            $dbh = DB::connection('bg_db')->table('setting')->where('setting_name', '=', 'ip_scale_keluar')
                ->first();
            $dbp = DB::connection('bg_db')->table('setting')->where('setting_name', '=', 'port_scale_keluar')
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

    public function simpanabsensi(Request $request)
    {
        $date = date('Y-m-d');
        $i = 0;
        while ($i < count($request->groupid))
        {
            $data = Absensi::where('groupuser_id', '=', $request->groupid[$i])
            ->where('tanggal_kehadiran', '=', $date)->first();
            if (!$data)
            {
                $query = new Absensi;
                $query->groupuser_id = $request->groupid[$i];
                $query->kehadiran = $request->hadir[$i];
                $query->tanggal_kehadiran = $date;
                $query->save();
            }
            else
            {
                $query = Absensi::where('id', '=', $data->id)
                    ->first();
                $query->groupuser_id = $request->groupid[$i];
                $query->kehadiran = $request->hadir[$i];
                $query->tanggal_kehadiran = $date;
                $query->save();
            }
            $i++;
        }
        return redirect()->back();
    }

    public function storetm(Request $request)
    {
        $doorfalse = Truck::where('door_id', '=', $request->door_id)
            ->get();
        $cek = DB::select(DB::raw("select count(*) as total from transaction_log where door_id = '" . $request->door_id . "' and trans_date between date_sub(NOW(), INTERVAL 120 MINUTE) and NOW()"));
        $cekrfid = Truck::select('ekspenditur', 'status')->where('truck_id', '=', $request->truck_id)
            ->first();
        if (!empty($cekrfid->ekspenditur))
        {
            $cekeks = Ekspenditur_list::where('id', '=', $cekrfid->ekspenditur)
                ->first();
            if ($cekeks->status == "syarat")
            {
                return redirect()
                    ->route('timbanganmasuk')
                    ->with('error', 'Perusahaan ini belum melengkapi persyaratan perusahaan');
            }
            else if ($cekeks->status == "izin")
            {
                return redirect()
                    ->route('timbanganmasuk')
                    ->with('error', 'Izin perusahaan abis!');
            }
            else if ($cekeks->status == "retri")
            {
                return redirect()
                    ->route('timbanganmasuk')
                    ->with('error', 'Perusahaan ini belum bayar retribusi');
            }
            else if ($cekrfid->status == "blok")
            {
                return redirect()
                    ->route('timbanganmasuk')
                    ->with('error', 'Nomor Lambung ini sudah diblokir');
            }
            else
            {

                $total = null;
                foreach ($cek as $a)
                {
                    $total = $a->total;
                }

                if ($total == 0)
                {
                    if (!$request->status)
                    {
                        $status = "Timbangan Masuk";
                        $data = new Struck;
                        $data->trans_scale = $status;
                        $data->trans_id = "";
                        $data->rfid_tag = "";
                        $data->weight_after = 0;
                        $data->id_struk = "";
                        $data->dwell = "";
                        $data->trans_date = Carbon::now();
                        $data->truck_id = $request->truck_id;
                        $data->door_id = $request->door_id;
                        $data->weight = $request->beratmasuk;
                        $data->stat_timbang = 0;
                        $data->pd_pasar = 0;
                        $data->save();

                        $rfid = Truck::where('door_id', '=', $request->door_id)
                            ->first();
                        if ($rfid->avg_masuk == 0) $rfid->avg_masuk = ($request->beratmasuk + $rfid->avg_masuk) / 2;
                        else $rfid->avg_masuk = $request->beratmasuk;
                        $rfid->save();
                    }
                    else
                    {
                        $status = "Timbangan Masuk";
                        $data = new Struck;
                        $data->trans_scale = $status;
                        $data->trans_id = "";
                        $data->rfid_tag = "";
                        $data->weight_after = 0;
                        $data->id_struk = "";
                        $data->dwell = "";
                        $data->trans_date = Carbon::now();
                        $data->truck_id = $request->truck_id;
                        $data->door_id = $request->door_id;
                        $data->weight = $request->beratmasuk;
                        $data->stat_timbang = 0;
                        $data->pd_pasar = 0;
                        $data->save();

                        $rfid = Truck::where('door_id', '=', $request->door_id)
                            ->first();
                        if ($rfid->avg_keluar == 0) $rfid->avg_keluar = ($request->beratmasuk + $rfid->avg_keluar) / 2;
                        else $rfid->avg_keluar = $request->beratmasuk;
                        if ($rfid->avg_masuk == 0) $rfid->avg_masuk = ($request->beratmasuk + $rfid->avg_masuk) / 2;
                        else $rfid->avg_masuk = $request->beratmasuk;

                        $rfid->save();
                    }

                    if ($data->save())
                    {
                        return redirect()
                            ->route('timbanganmasuk')
                            ->with('success', 'Timbangan berhasil disimpan');
                    }
                    else
                    {
                        return redirect()
                            ->route('timbanganmasuk')
                            ->with('error', 'Terjadi kesalahan dari pihak server silahkan coba lagi.');
                    }

                }
                else
                {
                    return redirect()
                        ->route('timbanganmasuk')
                        ->with('error', 'Kendaraan ini sudah melewati timbangan masuk.');
                }
            }
        }
        else
        {
            return redirect()
                ->route('timbanganmasuk')
                ->with('error', 'Ekspenditur_list tidak terdaftar pada pintu ini');
        }
    }

    public function checkdoor(Request $request)
    {
        $data = DB::select(DB::raw("select * from transaction_log where door_id = '" . $request->getdata . "' and stat_timbang = '0' and trans_date between DATE_SUB(NOW(), INTERVAL 24 HOUR) AND NOW() order by id desc limit 0,1"));
        $kir = Truck::where('door_id', '=', $request->getdata)
            ->first();
        $arr = array();
        if ($data != null)
        {
            foreach ($data as $a)
            {
                $arr[1] = "<div class='row' style='padding-top:30px;padding-bottom:20px;padding-left:40px;'><div class='col-md-2'>Foto</div><div class='col-md-1'>:</div><div class='col-md-8'><img src='" . asset('images/cctv.jpg') . "'></div></div><div class='row' style='padding-top:30px;padding-left:40px;'><div class='col-md-2'>Detail</div><div class='col-md-1'>:</div><div class='col-md-8'>" . $a->truck_id . " - " . $a->door_id . "</div></div><div class='row' style='padding-top:30px;padding-left:40px;'><div class='col-md-2'>Berat Masuk</div><div class='col-md-1'>:</div><div class='col-md-8'>" . $a->weight . " KG</div></div><div class='row' style='padding-top:30px;padding-left:40px;padding-bottom:30px;'><div class='col-md-2'>Masuk</div><div class='col-md-1'>:</div><div class='col-md-8'>" . date('d M Y, H:i', strtotime($a->trans_date)) . "</div></div><div class='row' style='padding-top:30px;padding-left:40px;padding-bottom:30px;'><div class='col-md-2'>KIR</div><div class='col-md-1'>:</div><div class='col-md-8'>" . $kir->kir . "</div></div><input type='text' style='display:none;' value='" . $a->id . "' name='id'>";
            }

            $arr[2] = $kir->kir;
            return $arr;
        }
        else
        {
            return "<center style='padding-top:80px;font-size:25px;'><b>Data timbangan awal tidak ada</b></center>";
        }
    }

    public function storetk(Request $request)
    {
        if ($request->id != "")
        {
            $data = Struck::where('id', '=', $request->id)
                ->first();
            $cekrfid = Truck::select('ekspenditur')->where('door_id', '=', $request->door_id)
                ->first();
            $cekeks = Ekspenditur_list::where('id', '=', $cekrfid->ekspenditur)
                ->first();
            if ($cekeks->status == "syarat")
            {
                return redirect()
                    ->route('timbangankeluar')
                    ->with('error', 'Perusahaan ini belum melengkapi persyaratan perusahaan');
            }
            else if ($cekeks->status == "izin")
            {
                return redirect()
                    ->route('timbangankeluar')
                    ->with('error', 'Izin perusahaan abis!');
            }
            else if ($cekeks->status == "retri")
            {
                return redirect()
                    ->route('timbangankeluar')
                    ->with('error', 'Perusahaan ini belum bayar retribusi');
            }

            if ($data->trans_date_after != "")
            {
                $lastinterval = Carbon::now();
                $firstinterval = DB::select(DB::raw("SELECT DATE_ADD('" . $data->trans_date_after . "', INTERVAL 0 Second) result LIMIT 1"));
                foreach ($firstinterval as $a)
                {
                    $d = Carbon::parse($a->result);
                }
                $cekwaktu = $d->diffInHours($lastinterval, true);
                if ($cekwaktu < 2)
                {
                    return redirect()->route('timbangankeluar')
                        ->with('error', 'Anda sudah masuk, jeda 2 jam sekali');
                }
            }
            $getstruk = Struck::select('id_struk')->where('stat_timbang', '=', 1)
                ->orderBy('trans_date_after', 'desc')
                ->first();
            $current = $getstruk->id_struk;
            if ($current != "")
            {
                $cur_tgl = substr($current, 0, 4);
                $cur_cnt = substr($current, 4, 4);
                if ($cur_tgl == date("md"))
                {
                    $id_struk_tgl = $cur_tgl;
                    $id_struk_cnt = $cur_cnt + 1;
                }
                else
                {
                    $id_struk_tgl = date("md");
                    $id_struk_cnt = '1';
                }
            }
            else
            {
                $id_struk_tgl = date("md");
                $id_struk_cnt = '1';
            }

            $panjang = strlen($id_struk_cnt);
            if ($panjang == 3)
            {
                $id_struk_cnt = "0" . $id_struk_cnt;
            }
            elseif ($panjang == 2)
            {
                $id_struk_cnt = "00" . $id_struk_cnt;
            }
            elseif ($panjang == 1)
            {
                $id_struk_cnt = "000" . $id_struk_cnt;
            }
            $id_struk = $id_struk_tgl . $id_struk_cnt;

            if (!$request->status)
            {
                $data->weight_after = $request->avg;
                $data->trans_scale = "Timbangan Keluar";
                $data->trans_date_after = Carbon::now();
                $data->dwell = Carbon::now()->timestamp - Carbon::parse($data->trans_date)->timestamp;
                $data->stat_timbang = 1;
                $data->id_struk = $id_struk;
                $data->save();

                $rfid = Truck::where('door_id', '=', $request->door_id)
                    ->first();
                if ($rfid->avg_keluar == 0) $rfid->avg_keluar = ($request->avg + $rfid->avg_keluar) / 2;
                else $rfid->avg_keluar = $request->avg;
            }
            else
            {
                $data->weight_after = $request->avg_sm;
                $data->trans_scale = "Timbangan Keluar";
                $data->trans_date_after = Carbon::now();
                $data->dwell = Carbon::now()->timestamp - Carbon::parse($data->trans_date)->timestamp;
                $data->stat_timbang = 1;
                $data->id_struk = $id_struk;
                $data->save();

                $rfid = Truck::where('door_id', '=', $request->door_id)
                    ->first();
                if ($rfid->avg_masuk == 0) $rfid->avg_masuk = ($request->avg_sm + $rfid->avg_masuk) / 2;
                else $rfid->avg_masuk = $request->avg_sm;
                $rfid->save();
            }
            if ($data->save())
            {
                $datase = Struck::where('id', '=', $data->id)
                    ->first();
                $truck = Truck::where('truck_id', '=', $datase->truck_id)
                    ->first();
                $ekspenditur = Ekspenditur_list::where('id', '=', $truck->ekspenditur)
                    ->first();
                $pre = explode("-", $datase->trans_date_after);
                $pre = $pre[1];
                $groupname = DB::connection('bg_db')->table('group_user')->join('group_list', 'group_user.group_id', '=', 'group_list.id')
                    ->select('group_list.groupname', 'group_user.id', 'group_user.group_id')
                    ->where('group_user.user_id', '=', Auth::user()
                    ->id)
                    ->first();
                return exec("curl http://192.168.1.10/bantargebang/admin/reprint_auto.php?id=" . $datase->id . "&user=auto");
                // return view('bantaradmin.printview', compact('datase', 'ekspenditur', 'pre', 'groupname'));
            }
            else
            {
                return redirect()
                    ->route('timbangankeluar')
                    ->with('error', 'Terjadi kesalahan dari pihak server silahkan coba lagi.');
            }
        }
        else
        {
            $dataa = Struck::where('door_id', '=', $request->door_id)
                ->orderBy('trans_date_after', 'desc')
                ->first();
            $cekrfid = Truck::select('ekspenditur')->where('door_id', '=', $request->door_id)
                ->first();
            $cekeks = Ekspenditur_list::where('id', '=', $cekrfid->ekspenditur)
                ->first();

            if ($cekeks->status == "syarat")
            {
                return redirect()
                    ->route('timbangankeluar')
                    ->with('error', 'Perusahaan ini belum melengkapi persyaratan perusahaan');
            }
            else if ($cekeks->status == "izin")
            {
                return redirect()
                    ->route('timbangankeluar')
                    ->with('error', 'Izin perusahaan abis!');
            }
            else if ($cekeks->status == "retri")
            {
                return redirect()
                    ->route('timbangankeluar')
                    ->with('error', 'Perusahaan ini belum bayar retribusi');
            }
            if ($dataa != "")
            {
                $lastinterval = Carbon::now();
                $firstinterval = DB::select(DB::raw("SELECT DATE_ADD('" . $dataa->trans_date_after . "', INTERVAL 0 Second) result LIMIT 1"));
                foreach ($firstinterval as $a)
                {
                    $d = Carbon::parse($a->result);
                }
                $cekwaktu = $d->diffInHours($lastinterval, true);
                if ($cekwaktu < 2)
                {
                    return redirect()->route('timbangankeluar')
                        ->with('error', 'Anda sudah masuk, jeda 2 jam sekali');
                }
            }

            $data = new Struck;
            $getstruk = Struck::select('id_struk')->where('stat_timbang', '=', 1)
                ->orderBy('trans_date_after', 'desc')
                ->first();
            $cekrfid = Truck::select('ekspenditur')->where('door_id', '=', $request->door_id)
                ->first();
            $cekeks = Ekspenditur_list::where('id', '=', $cekrfid->ekspenditur)
                ->first();

            $current = $getstruk->id_struk;
            if ($current != "")
            {
                $cur_tgl = substr($current, 0, 4);
                $cur_cnt = substr($current, 4, 4);
                if ($cur_tgl == date("md"))
                {
                    $id_struk_tgl = $cur_tgl;
                    $id_struk_cnt = $cur_cnt + 1;
                }
                else
                {
                    $id_struk_tgl = date("md");
                    $id_struk_cnt = '1';
                }
            }
            else
            {
                $id_struk_tgl = date("md");
                $id_struk_cnt = '1';
            }

            $panjang = strlen($id_struk_cnt);
            if ($panjang == 3)
            {
                $id_struk_cnt = "0" . $id_struk_cnt;
            }
            elseif ($panjang == 2)
            {
                $id_struk_cnt = "00" . $id_struk_cnt;
            }
            elseif ($panjang == 1)
            {
                $id_struk_cnt = "000" . $id_struk_cnt;
            }
            $id_struk = $id_struk_tgl . $id_struk_cnt;
            if (!$request->status)
            {
                $trucks = Truck::where('door_id', '=', $request->door_id)
                    ->first();
                $data->weight = $request->avg;
                $data->weight_after = $request->avg;
                $data->trans_scale = "Timbangan Keluar";
                $data->trans_date = Carbon::now();
                $data->trans_date_after = Carbon::now();
                $data->dwell = Carbon::now()->timestamp - Carbon::now()->timestamp;
                $data->stat_timbang = 1;
                $data->door_id = $request->door_id;
                $data->id_struk = $id_struk;
                $data->pd_pasar = 0;
                $data->truck_id = $trucks->truck_id;
                $data->save();

                $rfid = Truck::where('door_id', '=', $request->door_id)
                    ->first();
                if ($rfid->avg_keluar == 0) $rfid->avg_keluar = ($request->avg + $rfid->avg_keluar) / 2;
                else $rfid->avg_keluar = $request->avg;
                if ($rfid->avg_masuk == 0) $rfid->avg_masuk = ($request->avg + $rfid->avg_masuk) / 2;
                else $rfid->avg_masuk = $request->avg;

                $rfid->save();
            }
            else
            {
                $trucks = Truck::where('door_id', '=', $request->door_id)
                    ->first();
                $data->weight = $request->avg_sm;
                $data->weight_after = $request->avg_sm;
                $data->trans_scale = "Timbangan Keluar";
                $data->trans_date = Carbon::now();
                $data->trans_date_after = Carbon::now();
                $data->dwell = Carbon::now()->timestamp - Carbon::now()->timestamp;
                $data->stat_timbang = 1;
                $data->door_id = $request->door_id;
                $data->id_struk = $id_struk;
                $data->pd_pasar = 0;
                $data->truck_id = $trucks->truck_id;
                $data->save();

                $rfid = Truck::where('door_id', '=', $request->door_id)
                    ->first();
                if ($rfid->avg_keluar == 0) $rfid->avg_keluar = ($request->avg_sm + $rfid->avg_keluar) / 2;
                else $rfid->avg_keluar = $request->avg_sm;
                if ($rfid->avg_masuk == 0) $rfid->avg_masuk = ($request->avg_sm + $rfid->avg_masuk) / 2;
                else $rfid->avg_masuk = $request->avg_sm;

                $rfid->save();
            }
            if ($data->save())
            {
                $datase = Struck::where('id', '=', $data->id)
                    ->first();
                $truck = Truck::where('door_id', '=', $datase->door_id)
                    ->first();
                $ekspenditur = Ekspenditur_list::where('id', '=', $truck->ekspenditur)
                    ->first();
                $pre = explode("-", $datase->trans_date_after);
                $pre = $pre[1];
                $groupname = DB::connection('bg_db')->table('group_user')->join('group_list', 'group_user.group_id', '=', 'group_list.id')
                    ->select('group_list.groupname', 'group_user.id', 'group_user.group_id')
                    ->where('group_user.user_id', '=', Auth::user()
                    ->id)
                    ->first();
                // return view('bantaradmin.printview', compact('datase', 'ekspenditur', 'pre', 'groupname'));
                return exec("curl http://192.168.1.10/bantargebang/admin/reprint_auto.php?id=" . $datase->id . "&user=auto");
            }
            else
            {
                return redirect()
                    ->route('timbangankeluar')
                    ->with('error', 'Terjadi kesalahan dari pihak server silahkan coba lagi.');
            }
        }

    }

}

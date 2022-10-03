<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekspenditur;
use App\Models\Struck;
use DB;
use Auth;
use DataTables;
use Carbon\Carbon;
use Datetime;
use Illuminate\Support\Facades\Redis;

class APIController extends Controller
{
    public function update_log()
    {
        $data = DB::table('log_batch')->get();
        return $data;
    }

    public function rfid()
    {
        $tblist = DB::table('rfid_card')->join('ekspenditur_list', 'rfid_card.ekspenditur', '=', 'ekspenditur_list.id')
            ->leftJoin('tipe_truk', 'rfid_card.tipe', '=', 'tipe_truk.initial')
            ->select('rfid_card.*', 'tipe_truk.*', 'ekspenditur_list.ekspenditur_name', 'rfid_card.id as idrfid', DB::raw("CONCAT(rfid_card.door_id, ' - ', rfid_card.status) AS datapintu"))
            ->get();

        return response()
            ->json($tblist, 201);
    }

    public function tableshowunduh(Request $request)
    {
        if ($request->status == "masuk")
        {
            if ($request->no_truck != null && $request->no_polisi == null)
            {
                $data = DB::select(DB::raw("select transaction_log.*, rfid_card.area  from transaction_log left join rfid_card on transaction_log.truck_id = rfid_card.truck_id where DATE(transaction_log.trans_date) between DATE('" . $request->tgl_awal . "') and DATE('" . $request->tgl_akhir . "') and transaction_log.truck_id = '" . $request->no_truck . "' and transaction_log.stat_timbang = '0' order by transaction_log.trans_date desc"));
            }
            else if ($request->no_truck == null && $request->no_polisi != null)
            {
                $data = DB::select(DB::raw("select transaction_log.*, rfid_card.area  from transaction_log left join rfid_card on transaction_log.truck_id = rfid_card.truck_id where DATE(transaction_log.trans_date) between DATE('" . $request->tgl_awal . "') and DATE('" . $request->tgl_akhir . "') and transaction_log.door_id = '" . $request->no_polisi . "'  and transaction_log.stat_timbang = '0' order by transaction_log.trans_date desc"));
            }
            else if ($request->no_truck != null && $request->no_polisi != null)
            {
                $data = DB::select(DB::raw("select transaction_log.*, rfid_card.area  from transaction_log left join rfid_card on transaction_log.truck_id = rfid_card.truck_id where DATE(transaction_log.trans_date) between DATE('" . $request->tgl_awal . "') and DATE('" . $request->tgl_akhir . "') and transaction_log.door_id = '" . $request->no_polisi . "' and transaction_log.truck_id = '" . $request->no_truck . "' and transaction_log.stat_timbang = '0' order by transaction_log.trans_date desc"));
            }
            else
            {
                $data = DB::select(DB::raw("select transaction_log.*, rfid_card.area  from transaction_log left join rfid_card on transaction_log.truck_id = rfid_card.truck_id where DATE(transaction_log.trans_date) between DATE('" . $request->tgl_awal . "') and DATE('" . $request->tgl_akhir . "') and transaction_log.stat_timbang = '0' order by transaction_log.trans_date desc"));
            }
        }
        else if ($request->status == "keluar")
        {
            if ($request->no_truck != null && $request->no_polisi == null)
            {
                $data = DB::select(DB::raw("select transaction_log.*, rfid_card.area  from transaction_log left join rfid_card on transaction_log.truck_id = rfid_card.truck_id where DATE(transaction_log.trans_date_after) between DATE('" . $request->tgl_awal . "') and DATE('" . $request->tgl_akhir . "') and transaction_log.truck_id = '" . $request->no_truck . "' and transaction_log.stat_timbang = '1' order by transaction_log.trans_date_after asc"));
            }
            else if ($request->no_truck == null && $request->no_polisi != null)
            {
                $data = DB::select(DB::raw("select transaction_log.*, rfid_card.area  from transaction_log left join rfid_card on transaction_log.truck_id = rfid_card.truck_id where DATE(transaction_log.trans_date_after) between DATE('" . $request->tgl_awal . "') and DATE('" . $request->tgl_akhir . "') and transaction_log.door_id = '" . $request->no_polisi . "'  and transaction_log.stat_timbang = '1' order by transaction_log.trans_date_after asc"));
            }
            else if ($request->no_truck != null && $request->no_polisi != null)
            {
                $data = DB::select(DB::raw("select transaction_log.*, rfid_card.area  from transaction_log left join rfid_card on transaction_log.truck_id = rfid_card.truck_id where DATE(transaction_log.trans_date_after) between DATE('" . $request->tgl_awal . "') and DATE('" . $request->tgl_akhir . "') and transaction_log.door_id = '" . $request->no_polisi . "' and transaction_log.truck_id = '" . $request->no_truck . "' and transaction_log.stat_timbang = '1' order by transaction_log.trans_date_after asc"));
            }
            else
            {
                $data = DB::select(DB::raw("select transaction_log.*, rfid_card.area  from transaction_log left join rfid_card on transaction_log.truck_id = rfid_card.truck_id where DATE(transaction_log.trans_date_after) between DATE('" . $request->tgl_awal . "') and DATE('" . $request->tgl_akhir . "') and transaction_log.stat_timbang = '1' order by transaction_log.trans_date_after asc"));
            }
        }
        else if ($request->status == "allmasuk")
        {
            if ($request->no_truck && !$request->no_polisi)
            {
                $data = DB::select(DB::raw("select transaction_log.*, rfid_card.area  from transaction_log left join rfid_card on transaction_log.truck_id = rfid_card.truck_id where DATE(transaction_log.trans_date_after) between DATE('" . $request->tgl_awal . "') and DATE('" . $request->tgl_akhir . "') and transaction_log.truck_id = '" . $request->no_truck . "' order by transaction_log.trans_date_after asc"));
            }
            else if (!$request->no_truck && $request->no_polisi)
            {
                $data = DB::select(DB::raw("select transaction_log.*, rfid_card.area  from transaction_log left join rfid_card on transaction_log.truck_id = rfid_card.truck_id where DATE(transaction_log.trans_date_after) between DATE('" . $request->tgl_awal . "') and DATE('" . $request->tgl_akhir . "') and transaction_log.door_id = '" . $request->no_polisi . "' order by transaction_log.trans_date_after asc"));
            }
            else if ($request->no_truck && $request->no_polisi)
            {
                $data = DB::select(DB::raw("select transaction_log.*, rfid_card.area  from transaction_log left join rfid_card on transaction_log.truck_id = rfid_card.truck_id where DATE(transaction_log.trans_date_after) between DATE('" . $request->tgl_awal . "') and DATE('" . $request->tgl_akhir . "') and transaction_log.door_id = '" . $request->no_polisi . "' and transaction_log.truck_id = '" . $request->no_truck . "' order by transaction_log.trans_date_after asc"));
            }
            else
            {
                $data = DB::select(DB::raw("select transaction_log.*, rfid_card.area  from transaction_log left join rfid_card on transaction_log.truck_id = rfid_card.truck_id where DATE(transaction_log.trans_date_after) between DATE('" . $request->tgl_awal . "') and DATE('" . $request->tgl_akhir . "') order by transaction_log.trans_date_after asc"));
            }
        }

        //return $data;
        $temp[] = array();
        foreach ($data as $key => $p)
        {
            $exp = explode(",", $p->area);
            $temp[$key]['id'] = $p->id;
            $temp[$key]['dinas'] = $exp[1];
            $temp[$key]['masuk'] = $p->trans_date;
            $temp[$key]['keluar'] = $p->trans_date_after;
            $temp[$key]['door_id'] = $p->door_id;
            $temp[$key]['truck_id'] = $p->truck_id;
            $temp[$key]['weight'] = $p->weight;
            $temp[$key]['weight_after'] = $p->weight_after;
            $temp[$key]['nett'] = $p->weight - $p->weight_after;

        }
        return $temp;
        $encode = json_encode($temp);
        //print_r($temp);
        
    }

    public function getnett(Request $request)
    {
        $data = DB::select(DB::raw("select a.*,b.avg_masuk, b.avg_keluar  from transaction_log a, rfid_card b where date(a.trans_date_after) = '" . $request->tanggal . "' and a.truck_id = b.truck_id and ( (a.weight/b.avg_masuk) not between '0.3' and '1.7' or (a.weight_after/b.avg_keluar) not between '0.9' and '1.1' ) order by a.trans_date_after asc"));

        return $data;
    }

    public function getritase(Request $request)
    {
        $datagroup = DB::select(DB::raw("SELECT " . $request->group . ", COUNT(*) as count
        FROM transaction_log
        WHERE date(trans_date_after) = '" . $request->tanggal . "'
        GROUP BY " . $request->group . "
        HAVING COUNT(*) > " . $request->jumlah . ""));
        $memori = array();
        foreach ($datagroup as $p)
        {
            if ($request->group == 'door_id') $memori[] = $p->door_id;
            else
            {
                $memori[] = $p->truck_id;
            }
        }

        $realdata = DB::table('transaction_log')->where('trans_date_after', 'like', '%' . $request->tanggal . '%')
            ->whereIn($request->group, $memori)->get();

        return $realdata;
    }

    public function truck()
    {
        $listarea = DB::table('rfid_card')->select('area')
            ->groupBy('area')
            ->get();
        return response()
            ->json($listarea, 201);
    }

    public function apidoor()
    {
        $all = array();
        $listpintu = DB::table('rfid_card')->leftJoin('ekspenditur_list', 'rfid_card.ekspenditur', '=', 'ekspenditur_list.id')
            ->select('rfid_card.door_id', 'ekspenditur_list.status')
            ->get();
        foreach ($listpintu as $p)
        {
            $all[] = $p->door_id;
        }
        echo json_encode($all);
    }

    public function apitruck()
    {
        $all = array();
        $listtruck = DB::table('rfid_card')->select('truck_id')
            ->get();
        foreach ($listtruck as $p)
        {
            $all[] = $p->truck_id;
        }

        echo json_encode($all);
    }

    public function pintu()
    {
        $listpintu = RfidCard::select('door_id', 'status')->get();
        return response()
            ->json($listpintu, 201);
    }

    public function showchatlist()
    {
        $chat = DB::table('komentar')->where('channel', '=', 'public')
            ->orderBy('tanggal', 'desc')
            ->get();
        foreach ($chat as $p)
        {
            if ($p->nama != Auth::user()
                ->username)
            {
                echo '
            <li class="clearfix">
            <div class="conversation-text">
            <div class="ctext-wrap">
                <i>' . $p->nama . '</i>
                <p>
                    ' . $p->isi_komentar . ' <br> <small>' . Carbon::parse($p->tanggal)
                    ->format('d
                        F Y H:i:s') . '</small>
                </p>
            </div>
        </div>
        </li>';
            }
            else
            {
                echo '
        <li class="clearfix odd">
        <div class="conversation-text">
        <div class="ctext-wrap chat-widgets-cn">
            <i>' . $p->nama . '</i>
            <p>
            ' . $p->isi_komentar . ' <br> <small>' . Carbon::parse($p->tanggal)
                    ->format('d
                    F Y H:i:s') . '</small>
            </p>
        </div>
    </div>
    </li>';
            }
        }
    }

    public function showchatlistmk()
    {
        $chat = DB::table('komentar')->where('channel', '=', 'operatormk')
            ->orderBy('tanggal', 'desc')
            ->get();
        foreach ($chat as $p)
        {
            if ($p->nama != Auth::user()
                ->username)
            {
                echo '
            <li class="clearfix">
            <div class="conversation-text">
            <div class="ctext-wrap">
                <i>' . $p->nama . '</i>
                <p>
                    ' . $p->isi_komentar . ' <br> <small>' . Carbon::parse($p->tanggal)
                    ->format('d
                        F Y H:i:s') . '</small>
                </p>
            </div>
        </div>
        </li>';
            }
            else
            {
                echo '
        <li class="clearfix odd">
        <div class="conversation-text">
        <div class="ctext-wrap chat-widgets-cn">
            <i>' . $p->nama . '</i>
            <p>
            ' . $p->isi_komentar . ' <br> <small>' . Carbon::parse($p->tanggal)
                    ->format('d
                    F Y H:i:s') . '</small>
            </p>
        </div>
    </div>
    </li>';
            }
        }
    }

    public function showchatlistspj()
    {
        $chat = DB::table('komentar')->where('channel', '=', 'adminspj')
            ->orderBy('tanggal', 'desc')
            ->get();
        foreach ($chat as $p)
        {
            if ($p->nama != Auth::user()
                ->username)
            {
                echo '
            <li class="clearfix">
            <div class="conversation-text">
            <div class="ctext-wrap">
                <i>' . $p->nama . '</i>
                <p>
                    ' . $p->isi_komentar . ' <br> <small>' . Carbon::parse($p->tanggal)
                    ->format('d
                        F Y H:i:s') . '</small>
                </p>
            </div>
        </div>
        </li>';
            }
            else
            {
                echo '
        <li class="clearfix odd">
        <div class="conversation-text">
        <div class="ctext-wrap chat-widgets-cn">
            <i>' . $p->nama . '</i>
            <p>
            ' . $p->isi_komentar . ' <br> <small>' . Carbon::parse($p->tanggal)
                    ->format('d
                    F Y H:i:s') . '</small>
            </p>
        </div>
    </div>
    </li>';
            }
        }
    }

    public function ekspenditur()
    {
        $ekspenditur = Ekspenditur::get();
        return response()->json($ekspenditur, 201);
    }

    public function gettruckbydoor(Request $request)
    {
        if ($request->getdata)
        {
            $data = DB::table('rfid_card')->where('truck_id', '=', $request->getdata)
                ->first();
            $rata = DB::table("transaction_log")->select(DB::raw("AVG(weight) as beratrtmasuk") , DB::raw("AVG(weight_after) as beratrtkeluar"))
                ->where('truck_id', '=', $request->getdata)
                ->whereBetween('trans_date_after', [DB::raw('NOW() - INTERVAL 30 DAY') , DB::raw('NOW()') ])
                ->first();

            $arrdata = array();
            $arrdata[0] = $data->door_id;
            $arrdata[1] = $data->avg_masuk;
            $arrdata[2] = $data->avg_keluar;
            $arrdata[3] = round($rata->beratrtmasuk);
            $arrdata[4] = round($rata->beratrtkeluar);
            return $arrdata;
        }
        else if ($request->door)
        {
            $data = DB::table('rfid_card')->where('door_id', '=', $request->door)
                ->first();
            $rata = DB::table("transaction_log")->select(DB::raw("AVG(weight) as beratrtmasuk") , DB::raw("AVG(weight_after) as beratrtkeluar"))
                ->where('door_id', '=', $data->door_id)
                ->whereBetween('trans_date_after', [DB::raw('NOW() - INTERVAL 30 DAY') , DB::raw('NOW()') ])
                ->first();
            $arrdata = array();
            $arrdata[0] = $data->truck_id;
            $arrdata[1] = $data->avg_masuk;
            $arrdata[2] = $data->avg_keluar;
            $arrdata[3] = round($rata->beratrtmasuk);
            $arrdata[4] = round($rata->beratrtkeluar);
            return $arrdata;
        }
    }

    public function front()
    {
        $query = DB::select(DB::raw("select count(*) as total from transaction_log where stat_timbang = '0' and trans_date between date_sub(now(), INTERVAL 20 HOUR) and now()"));
        foreach ($query as $p)
        {
            $total = $p->total;
        }
        if ($total == 0)
        {
            $total = 0;
        }
        return view('bantaradmin.index', compact('total'));
    }

    public function getlastidp(Request $request)
    {
        $data = DB::table('komentar')->select('id_komentar')
            ->where('channel', '=', 'public')
            ->orderBy('tanggal', 'desc')
            ->first();
        if ($data->id_komentar == $request->id)
        {
            return response()
                ->json(['id' => $data->id_komentar, 'status' => 'Public Chat']);
        }
        else
        {
            return response()
                ->json(['id' => $data->id_komentar, 'status' => 'Public Chat <span class="badge" style="font-size:10px;background-color:#00c292;">New</span>']);
        }
    }

    public function getlastidmk(Request $request)
    {
        $data = DB::table('komentar')->select('id_komentar')
            ->where('channel', '=', 'operatormk')
            ->orderBy('tanggal', 'desc')
            ->first();
        if ($data->id_komentar == $request->id)
        {
            return response()
                ->json(['id' => $data->id_komentar, 'status' => 'Operator M/K']);
        }
        else
        {
            return response()
                ->json(['id' => $data->id_komentar, 'status' => 'Operator M/K <span class="badge" style="font-size:10px;background-color:#00c292;">New</span>']);
        }
    }

    public function getlastidspj(Request $request)
    {
        $data = DB::table('komentar')->select('id_komentar')
            ->where('channel', '=', 'adminspj')
            ->orderBy('tanggal', 'desc')
            ->first();
        if ($data->id_komentar == $request->id)
        {
            return response()
                ->json(['id' => $data->id_komentar, 'status' => 'Admin SPJ']);
        }
        else
        {
            return response()
                ->json(['id' => $data->id_komentar, 'status' => 'Admin SPJ <span class="badge" style="font-size:10px;background-color:#00c292;">New</span>']);
        }
    }

    public function daftartransaksi(Request $request)
    {
        $redis = Redis::connection();
        if ($request->sort == 'masuk')
        {
            if ($request->nopol != "")
            {
                $tambahan = " and truck_id = '" . $request->nopol . "'";
            }
            else
            {
                $tambahan = "";
            }
            if ($request->tanggal == "") $date = date('Y-m-d');
            else $date = $request->tanggal;
            $check = DB::select(DB::raw("select * from transaction_log where DATE(trans_date) between DATE('" . $date . "') and DATE('" . $date . "') and stat_timbang = '0' " . $tambahan . " order by trans_date_after desc limit 0,100"));
            $checkredis = json_decode($redis->get('transaksi_masuk'));
            if ($check == $checkredis)
            {
                $query = $checkredis;
            }
            else
            {
                $redis->set("transaksi_masuk", json_encode($check));
                $query = $check;
            }
            $all = array();
            foreach ($query as $a)
            {
                $arr_tgl = explode(' ', $a->trans_date);
                $ft = $arr_tgl[0];
                $jt = str_replace(':', '_', $arr_tgl[1]);
                $arr_tgl_out = explode(' ', $a->trans_date_after);
                $fo = $arr_tgl_out[0];
                $jo = "--";
                $nett = $a->weight - $a->weight_after;
                $door_id = RfidCard::select('door_id', 'ekspenditur')->where('truck_id', '=', $a->truck_id)
                    ->first();
                $ekspenditur = Ekspenditur::select('ekspenditur_name')->where('id', '=', $door_id->ekspenditur)
                    ->first();
                $datemasuk = date('d M Y, H:i', strtotime($a->trans_date));
                $datekeluar = "---";
                $all[] = array(
                    "image" => "<a onclick='javascript:event.target.port=81' target='_blank' href='camera/" . $ft . "/" . $jt . ".jpg'>In</a>&nbsp;<a  target='_blank' href='camera_out/" . $fo . "/" . $jo . ".jpg'>Out</a>",
                    "id" => $a->id . " / " . $a->id_struk,
                    "ekspenditur" => $ekspenditur->ekspenditur_name,
                    "trans_date" => $datemasuk,
                    "trans_date_after" => $datekeluar,
                    'door_id' => $door_id->door_id,
                    'truck_id' => $a->truck_id,
                    'weight' => $a->weight,
                    'weight_after' => $a->weight_after,
                    'nett' => $nett
                );
            }
            echo $date;
            return json_encode($all);
        }
        else
        {
            if ($request->nopol != "")
            {
                $tambahan = " and truck_id = '" . $request->nopol . "'";
            }
            else
            {
                $tambahan = "";
            }

            if ($request->tanggal == "") $date = date('Y-m-d');
            else $date = $request->tanggal;
            $checkredis = json_decode($redis->get('transaksi_keluar'));
            $check = DB::select(DB::raw("select * from transaction_log where DATE(trans_date_after) between DATE('" . $date . "') and DATE('" . $date . "') and stat_timbang = '1' " . $tambahan . " order by trans_date_after desc limit 0,100"));
            if ($check == $checkredis)
            {
                $query = $checkredis;
            }
            else
            {
                $redis->set("transaksi_keluar", json_encode($check));
                $query = $check;
            }
            $all = array();
            foreach ($query as $a)
            {
                $arr_tgl = explode(' ', $a->trans_date);
                $ft = $arr_tgl[0];
                $jt = str_replace(':', '_', $arr_tgl[1]);
                $arr_tgl_out = explode(' ', $a->trans_date_after);
                $fo = $arr_tgl_out[0];
                $jo = str_replace(':', '_', $arr_tgl_out[1]);
                $nett = $a->weight - $a->weight_after;
                $door_id = RfidCard::select('door_id', 'ekspenditur')->where('truck_id', '=', $a->truck_id)
                    ->first();
                $ekspenditur = Ekspenditur::select('ekspenditur_name')->where('id', '=', $door_id->ekspenditur)
                    ->first();
                $all[] = array(
                    "image" => "<a onclick='javascript:event.target.port=81' target='_blank' href='camera/" . $ft . "/" . $jt . ".jpg'>In</a>&nbsp;<a  target='_blank' href='camera_out/" . $fo . "/" . $jo . ".jpg'>Out</a>",
                    "id" => $a->id,
                    "ekspenditur" => $ekspenditur->ekspenditur_name,
                    "trans_date" => date('d M Y, H:i', strtotime($a->trans_date)) ,
                    "trans_date_after" => date('d M Y, H:i', strtotime($a->trans_date_after)) ,
                    'door_id' => $door_id->door_id,
                    'truck_id' => $a->truck_id,
                    'weight' => $a->weight,
                    'weight_after' => $a->weight_after,
                    'nett' => $nett
                );
            }
            return json_encode($all);
        }
    }

    public function wilayah()
    {
        $data = explode(',', "DINAS LINGKUNGAN HIDUP,KEPULAUAN SERIBU,PENGELOLAAN KAWASAN MANDIRI,UPK BADAN AIR,JAKARTA BARAT,JAKARTA PUSAT,JAKARTA SELATAN,JAKARTA TIMUR,JAKARTA UTARA");
        return $data;
    }

    public function getjumlah(Request $request)
    {
        $shift = array(
            '1' => '00:00:00 - 07:59:59',
            '2' => '08:00:00 - 15:59:59',
            '3' => '16:00:00 - 23:59:59'
        );
        // BIKIN ARRAY WILAYAH
        $wilayah = "DINAS LINGKUNGAN HIDUP,DINAS KEHUTANAN,KEPULAUAN SERIBU,PENGELOLAAN KAWASAN MANDIRI,UPK BADAN AIR,JAKARTA BARAT,JAKARTA PUSAT,JAKARTA SELATAN,JAKARTA TIMUR,JAKARTA UTARA";
        $extwilayah = explode(",", $wilayah);

        $RITASEtotal = array();
        $RITASEwilayah = array();
        // LOOPING PERTAMA ADALAH SHIFT.. KARENA QUERY NYA ADALAH PER SHIFT, BUKAN PER ZONA
        foreach ($shift as $key => $timeshift)
        {
            // bikin variable untuk input date dan time
            $timestart = explode(" - ", $timeshift) [0];
            $timefinish = explode(" - ", $timeshift) [1];
            if ($request->waktu == "") $date = date('Y-m-d');
            else $date = $request->waktu;
            //$date = '2019-06-28'; // pake date ini dulu yg ada di db, nanti pake input dari post
            // QUERY PER SHIFT
            if ($request->kata == "masuk") $query = DB::select(DB::raw("select a.*, b.area from transaction_log a, rfid_card b where a.door_id = b.door_id and a.trans_date between '" . $date . " " . $timestart . "' and '" . $date . " " . $timefinish . "' and stat_timbang = 0 "));
            else $query = DB::select(DB::raw("select a.*, b.area from transaction_log a, rfid_card b where a.door_id = b.door_id and a.trans_date_after between '" . $date . " " . $timestart . "' and '" . $date . " " . $timefinish . "' and stat_timbang = 1 "));

            $RITASEtotal[$key] = 0;

            // BIKIN VARIABLE COUNT default nya 0
            foreach ($extwilayah as $valwilayah)
            {
                $RITASEwilayah[$valwilayah][$key] = 0;
            }

            //LOOPING BARIS DB TADI.. TERUS DIPISAHIN PER WILAYAH.. SEKALIAN COUNT
            foreach ($query as $dbkey => $dbvalue)
            {
                foreach ($extwilayah as $valwilayah)
                { // pisahin per wilayah;
                    $db_area = explode(",", $dbvalue->area) [1];
                    $db_area = trim($db_area);
                    if ($valwilayah == $db_area)
                    {
                        $RITASEwilayah[$valwilayah][$key]++; //jumlah truk wilayah di shift X
                        $RITASEtotal[$key]++; // jumlah semua truk di shift X
                        
                    }
                }

            }
        }

        $totalright = array();
        foreach ($RITASEwilayah as $wilayah => $data)
        {
            $totalright[] = ($data[1] + $data[2] + $data[3]);
        }

        echo "<table class='table table-hover'>";
        echo "<tr><th>Pemberi Tugas / Wilayah</th><th>Shift 1</th><th>Shift 2</th><th>Shift 3</th><th>Jumlah</th></tr>";
        foreach ($RITASEwilayah as $wilayah => $data)
        {

            echo "<tr><th>" . $wilayah . "</th>";
            echo "<td>" . $data[1] . "</td><td>" . $data[2] . "</td><td>" . $data[3] . "</td></td><th>" . ($data[1] + $data[2] + $data[3]) . "</th>";
            echo "</tr>";
        }
        echo "<tr><th>Jumlah Kedatangan / Unit</th><th>" . $RITASEtotal[1] . "</th><th>" . $RITASEtotal[2] . "</th><th>" . $RITASEtotal[3] . "</th><th>" . ($RITASEtotal[1] + $RITASEtotal[2] + $RITASEtotal[3]) . "</th>";
        echo "</table>";
    }

    public function getritases(Request $request)
    {
        //return $request->waktu;
        $shift = array(
            '1' => '00:00:00 - 07:59:59',
            '2' => '08:00:00 - 15:59:59',
            '3' => '16:00:00 - 23:59:59'
        );
        // BIKIN ARRAY WILAYAH
        $wilayah = "DINAS LINGKUNGAN HIDUP,DINAS KEHUTANAN,KEPULAUAN SERIBU,PENGELOLAAN KAWASAN MANDIRI,UPK BADAN AIR,JAKARTA BARAT,JAKARTA PUSAT,JAKARTA SELATAN,JAKARTA TIMUR,JAKARTA UTARA";
        $extwilayah = explode(",", $wilayah);

        $RITASEtotal = array();
        $RITASEwilayah = array();
        // LOOPING PERTAMA ADALAH SHIFT.. KARENA QUERY NYA ADALAH PER SHIFT, BUKAN PER ZONA
        foreach ($shift as $key => $timeshift)
        {
            // bikin variable untuk input date dan time
            $timestart = explode(" - ", $timeshift) [0];
            $timefinish = explode(" - ", $timeshift) [1];
            if ($request->waktu == "") $date = date('Y-m-d');
            else $date = $request->waktu;
            //$date = '2019-06-28'; // pake date ini dulu yg ada di db, nanti pake input dari post
            // QUERY PER SHIFT\
            //$query=DB::select(DB::raw("select a.*, b.area from transaction_log a, rfid_card b where a.door_id = b.door_id and a.trans_date_after between '".$date." ".$timestart."' and '".$date." ".$timefinish."' "));
            //$redis->set("ritases", json_encode($query));
            //return $querys;
            // $redis = Redis::connection();
            // $checkredis = json_decode($redis->get('ritases'));
            $query = DB::select(DB::raw("select a.*, b.area from transaction_log a, rfid_card b where a.door_id = b.door_id and a.trans_date_after between '" . $date . " " . $timestart . "' and '" . $date . " " . $timefinish . "' "));
            // if($check == $checkredis){
            //     $query = $checkredis;
            //     echo "sama";
            // }else{
            //     $redis->set("ritases", json_encode($check));
            //     $query = $check;
            //     echo "tidak sama";
            // }
            $RITASEtotal[$key] = 0;

            // BIKIN VARIABLE COUNT default nya 0
            foreach ($extwilayah as $valwilayah)
            {
                $RITASEwilayah[$valwilayah][$key] = 0;
            }

            //LOOPING BARIS DB TADI.. TERUS DIPISAHIN PER WILAYAH.. SEKALIAN COUNT
            foreach ($query as $dbkey => $dbvalue)
            {
                foreach ($extwilayah as $valwilayah)
                { // pisahin per wilayah;
                    $db_area = explode(",", $dbvalue->area) [1];
                    $db_area = trim($db_area);
                    if ($valwilayah == $db_area)
                    {
                        $RITASEwilayah[$valwilayah][$key]++; //jumlah truk wilayah di shift X
                        $RITASEtotal[$key]++; // jumlah semua truk di shift X
                        
                    }
                }

            }
        }

        $totalright = array();
        foreach ($RITASEwilayah as $wilayah => $data)
        {
            $totalright[] = ($data[1] + $data[2] + $data[3]);
        }
        echo "
        <div class='row'>
        <div class='col-md-4'>
        <div style='width:400px;height:400px; margin-bottom:50px;'>
        <canvas id='piechart2' width='400' height='400'></canvas>
        </div>
        </div>
        <div class='col-md-8'>
        <div style='width:700px;height:300px; margin-bottom:50px;'>
        <canvas id='barchart2' width='600' height='300'></canvas>
        </div>
        </div>
        </div>
        <script>

        var ctx2 = document.getElementById('piechart2').getContext('2d');
        var ctz2 = document.getElementById('barchart2').getContext('2d');
            var myPieChart2 = new Chart(ctx2,{
            type: 'pie',
            data: {
            datasets: [{
                data: [" . $totalright[0] . "," . $totalright[1] . "," . $totalright[2] . "," . $totalright[3] . "," . $totalright[4] . "," . $totalright[5] . "," . $totalright[6] . "," . $totalright[7] . "," . $totalright[8] . "," . $totalright[9] . "],
                backgroundColor: [
                        'rgba(0, 0, 255, 0.2)',
                        'rgba(255, 255, 0, 0.2)',
                        'rgba(0, 191, 252, 0.2)',
                        'rgba(0, 255, 128, 0.2)',
                        'rgba(0, 191, 255, 0.2)',
                        'rgba(255, 191, 0, 0.2)',
                        'rgba(0, 255, 255, 0.2)',
                        'rgba(255, 64, 0, 0.2)',
                        'rgba(255, 0, 0, 0.2)',
                        'rgba(191, 0, 255, 0.2)',
                    ],
            borderColor: [
                        'rgba(0, 0, 255, 1)',
                        'rgba(255, 255, 0,1)',
                        'rgba(0, 191, 252, 0.2)',
                        'rgba(0, 255, 128, 1)',
                        'rgba(0, 191, 255,1)',
                        'rgba(255, 191, 0, 1)',
                        'rgba(0, 255, 255, 1)',
                        'rgba(255, 64, 0, 1)',
                        'rgba(255, 0, 0, 1)',
                        'rgba(191, 0, 255,1)',

            ]
            }],

            labels: [
                'DINAS LINGKUNGAN HIDUP',
                'DINAS KEHUTANAN',
                'KEPULAUAN SERIBU',
                'PENGELOLAAN KAWASAN MANDIRI',
                'UPK BADAN AIR',
                'JAKARTA BARAT',
                'JAKARTA PUSAT',
                'JAKARTA SELATAN',
                'JAKARTA TIMUR',
                'JAKARTA UTARA'
            ],

            },
        });


        var BarChart2 = new Chart(ctz2, {
            type: 'bar',
            data: {
                labels: [
                    'DINAS LINGKUNGAN HIDUP',
                    'DINAS KEHUTANAN',
                    'KEPULAUAN SERIBU',
                    'PENGELOLAAN KAWASAN MANDIRI',
                    'UPK BADAN AIR',
                    'JAKARTA BARAT',
                    'JAKARTA PUSAT',
                    'JAKARTA SELATAN',
                    'JAKARTA TIMUR',
                    'JAKARTA UTARA'
                ],
                datasets: [{
                    label: 'Tonase',
                    data: [" . $totalright[0] . "," . $totalright[1] . "," . $totalright[2] . "," . $totalright[3] . "," . $totalright[4] . "," . $totalright[5] . "," . $totalright[6] . "," . $totalright[7] . "," . $totalright[8] . "," . $totalright[9] . "],
                    backgroundColor: [
                        'rgba(0, 0, 255, 0.2)',
                        'rgba(255, 255, 0, 0.2)',
                        'rgba(0, 191, 252, 0.2)',
                        'rgba(0, 255, 128, 0.2)',
                        'rgba(0, 191, 255, 0.2)',
                        'rgba(255, 191, 0, 0.2)',
                        'rgba(0, 255, 255, 0.2)',
                        'rgba(255, 64, 0, 0.2)',
                        'rgba(255, 0, 0, 0.2)',
                        'rgba(191, 0, 255, 0.2)',
                    ],
            borderColor: [
                        'rgba(0, 0, 255, 1)',
                        'rgba(255, 255, 0,1)',
                        'rgba(0, 191, 252, 0.2)',
                        'rgba(0, 255, 128, 1)',
                        'rgba(0, 191, 255,1)',
                        'rgba(255, 191, 0, 1)',
                        'rgba(0, 255, 255, 1)',
                        'rgba(255, 64, 0, 1)',
                        'rgba(255, 0, 0, 1)',
                        'rgba(191, 0, 255,1)',
            ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>";
        echo "<table class='table table-hover'>";
        echo "<tr><th>Pemberi Tugas / Wilayah</th><th>Shift 1</th><th>Shift 2</th><th>Shift 3</th><th>Jumlah</th></tr>";
        foreach ($RITASEwilayah as $wilayah => $data)
        {

            echo "<tr><th>" . $wilayah . "</th>";
            echo "<td>" . $data[1] . "</td><td>" . $data[2] . "</td><td>" . $data[3] . "</td></td><th>" . ($data[1] + $data[2] + $data[3]) . "</th>";
            echo "</tr>";
        }
        echo "<tr><th>Jumlah Kedatangan / Unit</th><th>" . $RITASEtotal[1] . "</th><th>" . $RITASEtotal[2] . "</th><th>" . $RITASEtotal[3] . "</th><th>" . ($RITASEtotal[1] + $RITASEtotal[2] + $RITASEtotal[3]) . "</th>";
        echo "</table>";

    }

    public function getrittonase(Request $request)
    {
        $data = DB::select(DB::raw("select count(rfid_card.area) as ritase, format(sum((weight - weight_after) / 1000), 2) as tonase, rfid_card.area from transaction_log inner join rfid_card on transaction_log.door_id = rfid_card.door_id where date(transaction_log.trans_date_after) = '" . $request->waktu . "' and rfid_card.area like '%" . $request->penugasan . "%' group by rfid_card.area"));
        foreach ($data as $key => $datas)
        {
            $key++;
            echo "<tr><td>" . $key . "</td><td>" . $datas->area . "</td><td>" . $datas->ritase . "</td><td>" . $datas->tonase . "</td></tr>";
        }
    }

    public function gettonases(Request $request)
    {
        $shift = array(
            '1' => '00:00:00 - 07:59:59',
            '2' => '08:00:00 - 15:59:59',
            '3' => '16:00:00 - 23:59:59'
        );
        // BIKIN ARRAY WILAYAH
        $wilayah = "DINAS LINGKUNGAN HIDUP,DINAS KEHUTANAN,KEPULAUAN SERIBU,PENGELOLAAN KAWASAN MANDIRI,UPK BADAN AIR,JAKARTA BARAT,JAKARTA PUSAT,JAKARTA SELATAN,JAKARTA TIMUR,JAKARTA UTARA";
        $extwilayah = explode(",", $wilayah);

        $TONASEtotal = array();
        $TONASEwilayah = array();
        // LOOPING PERTAMA ADALAH SHIFT.. KARENA QUERY NYA ADALAH PER SHIFT, BUKAN PER ZONA
        foreach ($shift as $key => $timeshift)
        {
            // bikin variable untuk input date dan time
            $timestart = explode(" - ", $timeshift) [0];
            $timefinish = explode(" - ", $timeshift) [1];
            if ($request->waktu == "") $date = date('Y-m-d');
            else $date = $request->waktu;
            //$date = '2019-06-28'; // pake date ini dulu yg ada di db, nanti pake input dari post
            // QUERY PER SHIFT
            $query = DB::select(DB::raw("select a.*, b.area from transaction_log a, rfid_card b where a.door_id = b.door_id and a.trans_date_after between '" . $date . " " . $timestart . "' and '" . $date . " " . $timefinish . "'"));
            $TONASEtotal[$key] = 0;

            // BIKIN VARIABLE COUNT default nya 0
            foreach ($extwilayah as $valwilayah)
            {
                $TONASEwilayah[$valwilayah][$key] = 0;
            }

            //LOOPING BARIS DB TADI.. TERUS DIPISAHIN PER WILAYAH.. SEKALIAN COUNT
            foreach ($query as $dbkey => $dbvalue)
            {
                foreach ($extwilayah as $valwilayah)
                { // pisahin per wilayah;
                    $db_area = explode(",", $dbvalue->area) [1];
                    $db_area = trim($db_area);
                    if ($valwilayah == $db_area)
                    {
                        if ($dbvalue->weight_after != 0)
                        { // hanya ketika sudah timbang keluar
                            $tonase = ($dbvalue->weight - $dbvalue->weight_after) / 1000;
                            $tonase = round($tonase);
                            $TONASEwilayah[$valwilayah][$key] = $TONASEwilayah[$valwilayah][$key] + $tonase;
                            $TONASEtotal[$key] = $TONASEtotal[$key] + $tonase;
                        }
                    }
                }

            }
        }
        $totalright = array();
        foreach ($TONASEwilayah as $wilayah => $data)
        {
            $totalright[] = ($data[1] + $data[2] + $data[3]);
        }
        echo "
    <div class='row'>
    <div class='col-md-4'>
    <div style='width:400px;height:400px; margin-bottom:50px;'>
    <canvas id='piechart' width='400' height='400'></canvas>
    </div>
    </div>
    <div class='col-md-8'>
    <div style='width:700px;height:300px; margin-bottom:50px;'>
    <canvas id='barchart' width='600' height='300'></canvas>
    </div>
    </div>
    </div>
    <script>

    var ctx = document.getElementById('piechart').getContext('2d');
    var ctz = document.getElementById('barchart').getContext('2d');
        var myPieChart = new Chart(ctx,{
        type: 'pie',
        data: {
        datasets: [{
            data: [" . $totalright[0] . "," . $totalright[1] . "," . $totalright[2] . "," . $totalright[3] . "," . $totalright[4] . "," . $totalright[5] . "," . $totalright[6] . "," . $totalright[7] . "," . $totalright[8] . "," . $totalright[9] . "],
            backgroundColor: [
                    'rgba(0, 0, 255, 0.2)',
                    'rgba(255, 255, 0, 0.2)',
                    'rgba(0, 191, 252, 0.2)',
                    'rgba(0, 255, 128, 0.2)',
                    'rgba(0, 191, 255, 0.2)',
                    'rgba(255, 191, 0, 0.2)',
                    'rgba(0, 255, 255, 0.2)',
                    'rgba(255, 64, 0, 0.2)',
                    'rgba(255, 0, 0, 0.2)',
                    'rgba(191, 0, 255, 0.2)',
                ],
        borderColor: [
                    'rgba(0, 0, 255, 1)',
                    'rgba(255, 255, 0,1)',
                    'rgba(0, 191, 252, 0.2)',
                    'rgba(0, 255, 128, 1)',
                    'rgba(0, 191, 255,1)',
                    'rgba(255, 191, 0, 1)',
                    'rgba(0, 255, 255, 1)',
                    'rgba(255, 64, 0, 1)',
                    'rgba(255, 0, 0, 1)',
                    'rgba(191, 0, 255,1)',

        ]
        }],

        labels: [
            'DINAS LINGKUNGAN HIDUP',
            'DINAS KEHUTANAN',
            'KEPULAUAN SERIBU',
            'PENGELOLAAN KAWASAN MANDIRI',
            'UPK BADAN AIR',
            'JAKARTA BARAT',
            'JAKARTA PUSAT',
            'JAKARTA SELATAN',
            'JAKARTA TIMUR',
            'JAKARTA UTARA'
        ],

        },
    });


    var BarChart = new Chart(ctz, {
        type: 'bar',
        data: {
            labels: [
                'DINAS LINGKUNGAN HIDUP',
                'DINAS KETUHANAN',
                'KEPULAUAN SERIBU',
                'PENGELOLAAN KAWASAN MANDIRI',
                'UPK BADAN AIR',
                'JAKARTA BARAT',
                'JAKARTA PUSAT',
                'JAKARTA SELATAN',
                'JAKARTA TIMUR',
                'JAKARTA UTARA'
            ],
            datasets: [{
                label: 'Tonase',
                data: [" . $totalright[0] . "," . $totalright[1] . "," . $totalright[2] . "," . $totalright[3] . "," . $totalright[4] . "," . $totalright[5] . "," . $totalright[6] . "," . $totalright[7] . "," . $totalright[8] . "," . $totalright[9] . "],
                backgroundColor: [
                    'rgba(0, 0, 255, 0.2)',
                    'rgba(255, 255, 0, 0.2)',
                    'rgba(0, 191, 252, 0.2)',
                    'rgba(0, 255, 128, 0.2)',
                    'rgba(0, 191, 255, 0.2)',
                    'rgba(255, 191, 0, 0.2)',
                    'rgba(0, 255, 255, 0.2)',
                    'rgba(255, 64, 0, 0.2)',
                    'rgba(255, 0, 0, 0.2)',
                    'rgba(191, 0, 255, 0.2)',
                ],
        borderColor: [
                    'rgba(0, 0, 255, 1)',
                    'rgba(255, 255, 0,1)',
                    'rgba(0, 191, 252, 0.2)',
                    'rgba(0, 255, 128, 1)',
                    'rgba(0, 191, 255,1)',
                    'rgba(255, 191, 0, 1)',
                    'rgba(0, 255, 255, 1)',
                    'rgba(255, 64, 0, 1)',
                    'rgba(255, 0, 0, 1)',
                    'rgba(191, 0, 255,1)',
        ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
    </script>";

        echo "<table class='table table-hover'>";
        echo "<tr><th>Pemberi Tugas / Wilayah</th><th>Shift 1</th><th>Shift 2</th><th>Shift 3</th><th>Jumlah</th></tr>";
        foreach ($TONASEwilayah as $wilayah => $data)
        {
            echo "<tr><th>" . $wilayah . "</th>";
            echo "<td>" . $data[1] . "</td><td>" . $data[2] . "</td><td>" . $data[3] . "</td></td><th>" . ($data[1] + $data[2] + $data[3]) . "</th>";
            echo "</tr>";
        }
        echo "<tr><th>Total Tonase</th><th>" . $TONASEtotal[1] . "</th><th>" . $TONASEtotal[2] . "</th><th>" . $TONASEtotal[3] . "</th><th>" . ($TONASEtotal[1] + $TONASEtotal[2] + $TONASEtotal[3]) . "</th>";
        echo "</table>";
    }

    public function getreport(Request $request)
    {
        $arr_batas = array();
        $arr_batas[0][0] = 25;
        $arr_batas[0][1] = 25;
        $arr_batas[0][2] = 25;

        $arr_batas[1][0] = 25;
        $arr_batas[1][1] = 25;
        $arr_batas[1][2] = 25;

        $arr_batas[2][0] = 25;
        $arr_batas[2][1] = 25;
        $arr_batas[2][2] = 25;

        $arr_batas[3][0] = 25;
        $arr_batas[3][1] = 25;
        $arr_batas[3][2] = 25;

        $arr_batas[4][0] = 25;
        $arr_batas[4][1] = 25;
        $arr_batas[4][2] = 25;

        $arr_batas[5][0] = 70;
        $arr_batas[5][1] = 70;
        $arr_batas[5][2] = 70;

        $arr_batas[6][0] = 63;
        $arr_batas[6][1] = 63;
        $arr_batas[6][2] = 63;

        $arr_batas[7][0] = 82;
        $arr_batas[7][1] = 82;
        $arr_batas[7][2] = 82;

        $arr_batas[8][0] = 94;
        $arr_batas[8][1] = 94;
        $arr_batas[8][2] = 94;

        $arr_batas[9][0] = 66;
        $arr_batas[9][1] = 66;
        $arr_batas[9][2] = 66;

        $total_5_1 = 0;
        $total_5_2 = 0;
        $total_5_3 = 0;

        if ($request->waktu == '')
        {
            $request->waktu = date('Y-m-d');
        }

        $str_array = "DINAS LINGKUNGAN HIDUP,KEPULAUAN SERIBU,PENGELOLAAN KAWASAN MANDIRI,UPK BADAN AIR,JAKARTA BARAT,JAKARTA PUSAT,JAKARTA SELATAN,JAKARTA TIMUR,JAKARTA UTARA";

        $area = explode(",", $str_array);

        echo "<table class='table table-hover'><thead><tr><th>PEMBERI TUGAS / WILAYAH</th><th>SHIFT 1 (UNIT)</th><th>SHIFT 2 (UNIT)</th><th>SHIFT 3 (UNIT)</th></tr></thead><tbody>";

        $sum1 = 0;
        $sum2 = 0;
        $sum3 = 0;
        $totaltrans1 = 0;
        $totaltrans2 = 0;
        $totaltrans3 = 0;
        $i = 0;
        foreach ($area as $p)
        {
            $arr_s = array();
            $qa = DB::select(DB::raw("select door_id from rfid_card where area like '%" . $p . "'"));
            foreach ($qa as $a)
            {
                $arr_s[] = $a->door_id;
            }
            $area_imp = implode("','", $arr_s);

            $sql = DB::select(DB::raw("select count(*) as total from transaction_log where trans_date between '" . $request->waktu . " 00:00:00' and '" . $request->waktu . " 07:59:59' and door_id in ('" . $area_imp . "')"));
            foreach ($sql as $b)
            {
                $total1 = "<span class='label label-success'>" . $b->total . "</span>";
                if ($i <= 4) $total_5_1 += $b->total;
                $tt1 = $b->total;
                $totaltrans1 += $arr_batas[$i][0];
            }
            $sql = DB::select(DB::raw("select count(*) as total from transaction_log where trans_date between '" . $request->waktu . " 08:00:00' and '" . $request->waktu . " 15:59:59' and door_id in ('" . $area_imp . "')"));
            foreach ($sql as $c)
            {
                $total2 = "<span class='label label-success'>" . $c->total . "</span>";
                if ($i <= 4) $total_5_2 += $c->total;
                $tt2 = $c->total;
                $totaltrans2 += $arr_batas[$i][1];
            }
            $sql = DB::select(DB::raw("select count(*) as total from transaction_log where trans_date between '" . $request->waktu . " 16:00:00' and '" . $request->waktu . " 23:59:59' and door_id in ('" . $area_imp . "')"));
            foreach ($sql as $d)
            {
                $total3 = "<span class='label label-success'>" . $d->total . "</span>";
                if ($i <= 4) $total_5_3 += $d->total;
                $tt3 = $d->total;
                $totaltrans3 += $arr_batas[$i][2];
            }
            $sum1 += $tt1;
            $sum2 += $tt2;
            $sum3 += $tt3;
            echo "<tr><td>" . $p . "</td><td>" . $total1 . "</td><td>" . $total2 . "</td><td>" . $total3 . "</td></tr>";
            $i++;

        }

        $totaltrans1 -= 100;
        $totaltrans2 -= 100;
        $totaltrans3 -= 100;
        echo "<tr><td><b><i>JUMLAH KEDATANGAN (UNIT)</i></b></td><td><b><i>" . $sum1 . "</i></b></td><td><b><i>" . $sum2 . "</i></b></td><td><b><i>" . $sum3 . "</i></b></td></tr>";

        $time_avg_shift_1 = DB::select(DB::raw("select count(*) as truk, SEC_TO_TIME(AVG(dwell)) as total from transaction_log where stat_timbang = '1' and (weight - weight_after) between 200 and 30000 and trans_date between '" . $request->waktu . " 00:00:00' and '" . $request->waktu . " 07:59:59' and trans_date_after between '" . $request->waktu . " 00:00:00' and date_add('" . $request->waktu . " 07:59:59', INTERVAL 24 HOUR)"));
        foreach ($time_avg_shift_1 as $p)
        {
            $time_avg_shift_1 = $p->total;
            $truk_1 = $p->truk;
        }
        $time_avg_shift_2 = DB::select(DB::raw("select count(*) as truk, SEC_TO_TIME(AVG(dwell)) as total from transaction_log where stat_timbang = '1' and (weight - weight_after) between 200 and 30000 and trans_date between '" . $request->waktu . " 08:00:00' and '" . $request->waktu . " 15:59:59' and trans_date_after between '" . $request->waktu . " 08:00:00' and date_add('" . $request->waktu . " 15:59:59', INTERVAL 24 HOUR)"));
        foreach ($time_avg_shift_2 as $p)
        {
            $time_avg_shift_2 = $p->total;
            $truk_2 = $p->truk;
        }
        $time_avg_shift_3 = DB::select(DB::raw("select count(*) as truk, SEC_TO_TIME(AVG(dwell)) as total from transaction_log where stat_timbang = '1'  and (weight - weight_after) between 200 and 30000 and trans_date between '" . $request->waktu . " 16:00:00' and '" . $request->waktu . " 23:59:59' and trans_date_after between '" . $request->waktu . " 16:00:00' and date_add('" . $request->waktu . " 23:59:59', INTERVAL 24 HOUR)"));
        foreach ($time_avg_shift_3 as $p)
        {
            $time_avg_shift_3 = $p->total;
            $truk_3 = $p->truk;
        }
        echo "<tr style='color:#eee'><td><b><i>RATA - RATA DWELLING TIME</i></b></td><td><b><i>" . $time_avg_shift_1 . " (" . $truk_1 . " Truk)</i></b></td><td><b><i>" . $time_avg_shift_2 . " (" . $truk_2 . " Truk)</i></b></td><td><b><i>" . $time_avg_shift_3 . " (" . $truk_3 . " Truk)</i></b></td></tr>";
        echo "</tbody></table>|" . $total_5_1 . "," . $total_5_2 . "," . $total_5_3;
    }

    public function showabsen(Request $request)
    {
        $group = GroupList::orderBy('groupname', 'asc')->get();
        $datagroup = DB::table('absensi')->join('group_user', 'absensi.groupuser_id', '=', 'group_user.id')
            ->join('users', 'group_user.user_id', '=', 'users.id')
            ->select('absensi.kehadiran', 'absensi.tanggal_kehadiran', 'group_user.group_id', 'users.name', 'users.phonenumber')
            ->where('absensi.tanggal_kehadiran', '=', $request->tanggal)
            ->get();
        echo '<div class="breadcomb-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcomb-list">
                                <h2>Operator Masuk</h2>
                            <div class="row">';
        foreach ($group as $a)
        {
            if ($a->groupdivision == 1)
            {
                echo '<div class="col-md-4">
                                    <table style="width:100%;margin-top:20px;">
                                            <thead>
                                                <tr>
                                                <th style="background-color:grey;padding:5px 10px;">' . $a->groupname . '</th>
                                                <th>No.telp</th>
                                                <th>Status</th>
                                                </tr>
                                            </thead><tbody>';
                foreach ($datagroup as $b)
                {
                    if ($b->group_id == $a->id)
                    {
                        if ($b->kehadiran == "")
                        {
                            echo '
                                                    <tr>
                                                    <td>' . $b->name . '</td>
                                                    <td>' . $b->phonenumber . '</td>
                                                    <td>tidak hadir</td>
                                                    </tr>';
                        }
                        else
                        {
                            echo '
                                                    <tr>
                                                    <td>' . $b->name . '</td>
                                                    <td>' . $b->phonenumber . '</td>
                                                    <td>' . $b->kehadiran . '</td>
                                                    </tr>';
                        }
                    }
                }
                echo '</tbody>
                                        </table>
                                    </div>';
            }
        }
        echo '
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>';

        echo '<div class="breadcomb-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcomb-list">
                                <h2>Operator SPJ</h2>
                            <div class="row">';
        foreach ($group as $a)
        {
            if ($a->groupdivision == 3)
            {
                echo '<div class="col-md-4">
                                    <table style="width:100%;margin-top:20px;">
                                            <thead>
                                                <tr>
                                                <th style="background-color:grey;padding:5px 10px;">' . $a->groupname . '</th>
                                                <th>No.telp</th>
                                                <th>Status</th>
                                                </tr>
                                            </thead><tbody>';
                foreach ($datagroup as $b)
                {
                    if ($b->group_id == $a->id)
                    {
                        if ($b->kehadiran == "")
                        {
                            echo '
                                                    <tr>
                                                    <td>' . $b->name . '</td>
                                                    <td>' . $b->phonenumber . '</td>
                                                    <td>tidak hadir</td>
                                                    </tr>';
                        }
                        else
                        {
                            echo '
                                                    <tr>
                                                    <td>' . $b->name . '</td>
                                                    <td>' . $b->phonenumber . '</td>
                                                    <td>' . $b->kehadiran . '</td>
                                                    </tr>';
                        }
                    }
                }
                echo '</tbody>
                                        </table>
                                    </div>';
            }
        }
        echo '
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>';

        echo '<div class="breadcomb-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcomb-list">
                                <h2>Operator Keluar</h2>
                            <div class="row">';
        foreach ($group as $a)
        {
            if ($a->groupdivision == 2)
            {
                echo '<div class="col-md-4">
                                    <table style="width:100%;margin-top:20px;">
                                            <thead>
                                                <tr>
                                                <th style="background-color:grey;padding:5px 10px;">' . $a->groupname . '</th>
                                                <th>No.telp</th>
                                                <th>Status</th>
                                                </tr>
                                            </thead><tbody>';
                foreach ($datagroup as $b)
                {
                    if ($b->group_id == $a->id)
                    {
                        if ($b->kehadiran == "")
                        {
                            echo '
                                                    <tr>
                                                    <td>' . $b->name . '</td>
                                                    <td>' . $b->phonenumber . '</td>
                                                    <td>tidak hadir</td>
                                                    </tr>';
                        }
                        else
                        {
                            echo '
                                                    <tr>
                                                    <td>' . $b->name . '</td>
                                                    <td>' . $b->phonenumber . '</td>
                                                    <td>' . $b->kehadiran . '</td>
                                                    </tr>';
                        }
                    }
                }
                echo '</tbody>
                                        </table>
                                    </div>';
            }
        }
        echo '
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>';
    }

    public function getsama(Request $request)
    {
        $data = TransactionLog::where('trans_date', 'like', '%' . $request->tanggal . '%')
            ->where('trans_date_after', 'like', '%' . $request->tanggal . '%')
            ->get();
        if ($data)
        {
            foreach ($data as $a)
            {
                echo "<tr><td>" . $a->id . "</td><td>" . $a->trans_date . "</td><td>" . $a->trans_date_after . "<td>" . $a->weight . "</td><td>" . $a->weight_after . "</td><td>" . $a->truck_id . "</td>";
            }
        }
    }

    public function doubleritase(Request $request)
    {
        $data = DB::select(DB::raw("SELECT door_id, COUNT(*) as count
            FROM transaction_log
            WHERE date(trans_date_after) = '" . $request->tanggal . "' and stat_timbang = '1'
            GROUP BY door_id
            HAVING COUNT(*) > 2"));
        $array = array();
        foreach ($data as $dek)
        {
            $array[] = "'" . $dek->door_id . "'";
        }

        $listgroup = implode(',', $array);
        if ($listgroup != "")
        {
            $sql = DB::select(DB::raw("select * from transaction_log where date(trans_date_after) = '" . $request->tanggal . "' and door_id in (" . $listgroup . ") and stat_timbang = '1' order by door_id,trans_date_after asc"));
            $jumlah = count($sql);
        }
        else
        {
            $jumlah = 0;
        }
        if ($jumlah == 0)
        {
            echo "<tr><td colspan='7'>Data tidak ada..</td></tr>";
        }
        else
        {
            $date_keluar = "";
            $date_masuk = "";
            $curr_door_id = "";
            $jumlah_data = 0;
            foreach ($sql as $a)
            {
                $arr_tgl = explode(' ', $a->trans_date);
                $ft = $arr_tgl[0];
                $jt = str_replace(':', '_', $arr_tgl[1]);
                $arr_tgl_out = explode(' ', $a->trans_date_after);
                $fo = $arr_tgl_out[0];
                $jo = str_replace(':', '_', $arr_tgl_out[1]);

                if ($a->door_id != $curr_door_id)
                {
                    $tmpecho = "<tr><td><a  target='_blank' href='camera/" . $ft . "/" . $jt . ".jpg'>In</a>&nbsp;<a  target='_blank' href='camera_out/" . $fo . "/" . $jo . ".jpg'>Out</a></td><td>" . $a->id . "</td><td>" . $a->trans_date . "</td><td>" . $a->trans_date_after . "<td>" . $a->weight . "</td><td>" . $a->weight_after . "</td><td>" . $a->id_struk . "</td><td>" . $a->truck_id . "</td></tr>";

                    $date_keluar = $a->trans_date_after;
                    $date_masuk = $a->trans_date;
                    $curr_door_id = $a->door_id;
                }
                else
                {
                    $t1 = strtotime($a->trans_date);
                    $t2 = strtotime($date_keluar);
                    $diff = $t1 - $t2;
                    $hours = $diff / (60 * 60);
                    if ($diff <= 7200)
                    {
                        echo $tmpecho;
                        echo "<tr><td><a  target='_blank' href='camera/" . $ft . "/" . $jt . ".jpg'>In</a>&nbsp;<a  target='_blank' href='camera_out/" . $fo . "/" . $jo . ".jpg'>Out</a></td><td>" . $a->id . "</td><td>" . $a->trans_date . "</td><td>" . $a->trans_date_after . "<td>" . $a->weight . "</td><td>" . $a->weight_after . "</td><td>" . $a->id_struk . "</td><td>" . $a->truck_id . "</td></tr>";
                        $date_keluar = $a->trans_date_after;
                        $date_masuk = $a->trans_date;
                        $curr_door_id = $a->door_id;
                        $tmpecho = "";
                        $jumlah_data++;
                    }
                }
            }
        }
    }

    public function listedittransaksi(Request $request)
    {
        if ($request->shift == 1)
        {
            $data = DB::select(DB::raw('select transaction_log.id,transaction_log.weight,transaction_log.weight_after,transaction_log.trans_date,transaction_log.trans_date_after,transaction_log.door_id,transaction_log.truck_id,rfid_card.avg_masuk,rfid_card.area,rfid_card.avg_keluar from transaction_log left join rfid_card on transaction_log.door_id = rfid_card.door_id where transaction_log.trans_date_after between "' . $request->tglkeluar . ' 00:00:00" and "' . $request->tglkeluar . ' 07:59:59" and rfid_card.area like "%' . Auth::user()->wilayah . '%" order by trans_date_after desc'));
        }
        elseif ($request->shift == 2)
        {
            $data = DB::select(DB::raw('select transaction_log.id,transaction_log.weight,transaction_log.door_id,transaction_log.truck_id,transaction_log.weight_after,transaction_log.trans_date,transaction_log.trans_date_after,rfid_card.avg_masuk,rfid_card.area,rfid_card.avg_keluar from transaction_log left join rfid_card on transaction_log.door_id = rfid_card.door_id where transaction_log.trans_date_after between "' . $request->tglkeluar . ' 08:00:00" and "' . $request->tglkeluar . ' 15:59:59" and rfid_card.area like "%' . Auth::user()->wilayah . '%" order by trans_date_after desc'));
        }
        else
        {
            $data = DB::select(DB::raw('select transaction_log.id,transaction_log.weight,transaction_log.door_id,transaction_log.truck_id,transaction_log.weight_after,transaction_log.trans_date,transaction_log.trans_date_after,rfid_card.avg_masuk,rfid_card.area,rfid_card.avg_keluar from transaction_log left join rfid_card on transaction_log.door_id = rfid_card.door_id where transaction_log.trans_date_after between "' . $request->tglkeluar . ' 16:00:00" and "' . $request->tglkeluar . ' 23:59:59" and rfid_card.area like "%' . Auth::user()->wilayah . '%" order by trans_date_after desc'));
        }
        foreach ($data as $a)
        {
            return response()->json($data, 201);
        }
    }

    public function hapustransaksi(Request $request)
    {
        $data = TransactionLog::where('id', '=', $request->struk)
            ->first();
        if ($data)
        {
            $data->delete();
            return "<p style='color:green;'>Berhasil di hapus</p>";
        }
        else
        {
            return "<p style='color:red'>Id Struk tidak terdaftar</p>";
        }
    }

    public function showdisplay($type)
    {
        if ($type == "masuk")
        {
            $data = DB::table('display_transaction')->where('tipe', '=', 'masuk')
                ->first();
            // return "<h1 style='font-weight:normal;padding-top:40px;'>Berat : ".$data->berat." KG</h1><br><h1 style='font-weight:normal'>No Pintu : ".$data->nopintu."</h1><br><h1 style='font-weight:normal'> No Lambung : ".$data->nopol."</h1><br>";
            return response()
                ->json($data);
        }
        else
        {
            $data = DB::table('display_transaction')->where('tipe', '=', 'keluar')
                ->first();
            return response()
                ->json($data, 201);
        }
    }

    public function logincheck(Request $request)
    {
        $datajson = json_decode($request->getContent() , true);
        $data = DB::table('users')->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->where('username', '=', $datajson['un'])->first();
        if (is_null($data))
        {
            return response()->json(['message' => 'username, password atau peran user tidak valid', 'status' => 'Error']);
            //}else if($datajson['un'] == $data->un && password_verify($datajson['pw']) == $data->pw && $data->role_id == 20)
            
        }
        else if ($datajson['un'] == $data->username && password_verify($datajson['pw'], $data->password) && $data->role_id == 20)
        {
            $lokasi = DB::table('lokasi')->where('id', '=', $data->lokasi_id)
                ->first();
            $nama_lokasi = $lokasi->nama_lokasi;
            if ($data->taptype == "tapin")
            {
                $taptype = "Scan Masuk";
            }
            else
            {
                $taptype = "Scan Keluar";
            }
            return response()->json(['message' => 'berhasil login', 'status' => 'Success', 'taptype' => $taptype, 'lokasi' => $nama_lokasi]);
        }
        else
        {
            return response()->json(['message' => 'username, password atau peran user tidak valid', 'status' => 'Error'], JSON_PRETTY_PRINT);
        }
    }

    public function titik_buang(Request $request)
    {
        $user = DB::table('users')->where('username', '=', $request->user)
            ->first();
        $id_user = $user->id;
        $id_lokasi = $user->lokasi_id;
        $tap = $user->taptype;

        if ($tap == 'tapin')
        {
            $str_tap = "tapbuangin";
            $user_type = "userscanin";
            $user_value = $request->user;
        }
        elseif ($tap == 'tapout')
        {
            $str_tap = "tapbuangout";
            $user_type = "userscanout";
            $user_value = $request->user;
        }

        //$lokasi = DB::table('lokasi')->where('id', '=', $id_lokasi)->first();
        //$nama_lokasi = $lokasi->nama_lokasi;
        $nama_lokasi = trim(str_replace("Lokasi ", "", $request->location));

        $transaction = DB::table('transaction_log')->where('door_id', '=', $request->door_id)
            ->orderBy('id', 'desc')
            ->first();

        $date = date('Y-m-d H:i:s');
        $update = DB::table('transaction_log')->where('id', '=', $transaction->id);
        $update->update(['zona' => $nama_lokasi, $str_tap => $date, $user_type => $user_value]);

        if ($update)
        {
            return response()->json(['message' => 'Update berhasil', 'status' => 'Success']);
        }
        else
        {
            return response()
                ->json(['message' => 'Update gagal', 'status' => 'Error']);
        }
    }

    public function jenis()
    {
        $item = array(
            "items" => array(
                (object)array(
                    "jenis" => "Timbangan Masuk"
                ) ,
                (object)array(
                    "jenis" => "Timbangan Keluar"
                )
            )
        );

        return json_encode($item, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    public function location()
    {
        /*
            $item = array(
                "items" => array((object)array("loc"=>"Lokasi 1"),(object)array("loc" => "Lokasi 2"),(object)array("loc" => "Lokasi 3"),(object)array("loc" => "Lokasi 4"),(object)array("loc" => "Lokasi 5"))
            );
        
            return json_encode($item);
        */
        $all = array();
        $arr_loc = array();
        $arr_label = DB::table('lokasi')->select('nama_lokasi')
            ->get();
        foreach ($arr_label as $p)
        {
            $arr_loc[] = array(
                "loc" => "Lokasi " . $p->nama_lokasi
            );
        }
        $all['items'] = $arr_loc;
        return json_encode($all);
    }

    public function ritasezona()
    {

        $get_label = array();
        $temp_row_trans = array();
        $arr_label = DB::table('lokasi')->select('nama_lokasi')
            ->get();
        foreach ($arr_label as $p)
        {
            $get_label[] = $p->nama_lokasi;
            $temp_row_trans[$p->nama_lokasi] = 0;
        }

        $arr_transaction = DB::table('transaction_log')->where('tapbuangin', '!=', null)
            ->where('tapbuangout', '=', null)
            ->where(DB::raw("DATE(tapbuangin)") , '=', DB::raw('CURRENT_DATE()'))
            ->get();

        //print_r($arr_transaction);
        foreach ($arr_transaction as $row_trans)
        {
            foreach ($get_label as $key => $row_label)
            {
                if ($row_trans->zona == $row_label) $temp_row_trans[$row_label]++;

            }

        }
        $final_arr = array();
        foreach ($temp_row_trans as $keyr => $valr)
        {
            $single_array = array(
                "titik" => $keyr,
                "jumlah" => $valr
            );
            $final_arr[] = $single_array;
        }
        $items["items"] = $final_arr;
        //print_r($temp_row_trans);
        // $items["items"] = $temp_row_trans;
        echo json_encode($items, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    public function dwellingzona()
    {
        $get_label = array();
        $arr_label = DB::table('lokasi')->select('nama_lokasi')
            ->get();
        foreach ($arr_label as $p)
        {
            $get_label[] = $p->nama_lokasi;
        }
        //return $get_label;
        $temp_row_trans = array();
        $arr_transaction = DB::table('transaction_log')->where('tapbuangin', '!=', null)
            ->where('tapbuangout', '!=', null)
            ->where(DB::raw("DATE(tapbuangout)") , '=', DB::raw('CURRENT_DATE()'))
            ->get();
        foreach ($arr_transaction as $row_trans)
        {

            foreach ($get_label as $key => $row_label)
            {
                if ($row_trans->zona == $row_label) $temp_row_trans[$row_label][] = $row_trans;
            }
        }
        //print_r($temp_row_trans);
        

        foreach ($temp_row_trans as $key => $row_temp)
        {
            $arr = array();
            $time = array();
            foreach ($row_temp as $keys => $p)
            {
                // echo $p->tapbuangout."<br>";
                if ($p->zona == $key)
                {
                    $diff = (strtotime($p->tapbuangout) - strtotime($p->tapbuangin)) / 3600;
                    $time[$key][] = round($diff);
                    //echo $p->tapbuangout." Next <br>";
                    
                }
                else
                {
                    echo "";
                }
            }
            foreach ($time as $ind => $q)
            {
                $total = 0;
                foreach ($q as $loop)
                {
                    $total += $loop;
                }
                $fix = $total / count($q);
                $arr["dwell"]["zona"] = $key;
                $arr["dwell"]["time"] = $fix;
            }
            echo json_encode($arr, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }
    }

    public function jumlahzona(Request $request)
    {
        $get_label = array();
        $temp_row_trans = array();
        $arr_label = DB::table('lokasi')->select('nama_lokasi')
            ->get();
        foreach ($arr_label as $p)
        {
            $get_label[] = $p->nama_lokasi;
            $temp_row_trans[$p->nama_lokasi] = 0;
        }
        //return $get_label;
        if ($request->date == "") $arr_transaction = DB::table('transaction_log')->where('tapbuangin', '!=', null)
            ->where('tapbuangout', '=', null)
            ->where(DB::raw("DATE(tapbuangin)") , '=', DB::raw('CURRENT_DATE()'))
            ->get();
        else $arr_transaction = DB::table('transaction_log')->where('tapbuangin', '!=', null)
            ->where('tapbuangout', '=', null)
            ->where(DB::raw("DATE(tapbuangin)") , '=', $request->date)
            ->get();
        echo '<table class="table table-bordered">
            <thead>
                <th>Zona</th>
                <th>Jumlah</th>
            </thead>
                <tbody>';

        foreach ($arr_transaction as $keys => $row_trans)
        {
            foreach ($get_label as $key => $row_label)
            {

                if ($row_trans->zona == $row_label) $temp_row_trans[$row_label]++;
            }
        }

        foreach ($temp_row_trans as $key => $row_temp)
        {
            echo "<tr><td>" . $key . "</td><td>" . $temp_row_trans[$key] . " Kendaraan</td></tr>";
        }
        //print_r($temp_row_trans);
        echo '</tbody></table>';
    }

    public function totalzona(Request $request)
    {
        $dummyshift = array(
            '1' => '00:00:00 - 07:59:59',
            '2' => '08:00:00 - 15:59:59',
            '3' => '16:00:00 - 23:59:59'
        );
        $qzona = DB::table('lokasi')->select('nama_lokasi')
            ->get();

        $tempzona = array();
        //First Foreach to set array
        foreach ($qzona as $zone)
        {
            $tempzona[] = $zone->nama_lokasi;
        }

        $result = array();
        foreach ($dummyshift as $index => $shift)
        {
            $ts = explode(" - ", $shift) [0];
            $tf = explode(" - ", $shift) [1];

            if ($request->date != "") $date = $request->date;
            else $date = date('Y-m-d');

            $ds = $date . " " . $ts;
            $df = $date . " " . $tf;
            $qshift = DB::table('transaction_log')->whereBetween('tapbuangin', [$ds, $df])->get();

            //print_r($qshift);
            $tempshift = array();
            foreach ($qshift as $tshift)
            {
                $tempshift[] = $tshift;
            }

            $count_in = array();
            $count_out = array();
            foreach ($tempzona as $czona)
            {
                $count_in[$index][$czona] = 0;
                $count_out[$index][$czona] = 0;
            }

            // print_r($count_in);
            foreach ($tempshift as $key => $tempvalue)
            {
                foreach ($tempzona as $czona)
                {
                    //print_r($tempvalue);
                    if ($czona == $tempvalue->zona)
                    {
                        if ($tempvalue->tapbuangout == '')
                        {
                            $count_in[$index][$czona]++;
                        }
                        else
                        {
                            $count_out[$index][$czona]++;
                        }
                        $result[$index][$czona]['count_in'] = $count_in[$index][$czona];
                        $result[$index][$czona]['count_out'] = $count_out[$index][$czona];
                    }
                }

            }

        }
        //print_r($result);
        $result_final = array();
        foreach ($tempzona as $czona)
        {
            foreach ($dummyshift as $key => $timeshift)
            {
                //print_r($result[$key][$czona]['count_in']);
                if (isset($result[$key][$czona]['count_in']))
                {
                    $result_final[$czona][$key]['count_in'] = $result[$key][$czona]['count_in'];
                }
                else
                {
                    $result_final[$czona][$key]['count_in'] = 0;
                }
                if (isset($result[$key][$czona]['count_out']))
                {
                    $result_final[$czona][$key]['count_out'] = $result[$key][$czona]['count_out'];
                }
                else
                {
                    $result_final[$czona][$key]['count_out'] = 0;
                }

            }
        }

        //print_r($result_final);
        echo '<table class="table table-bordered">';
        echo "<thead><tr><th>Zona</th><th>Shift 1 - In</th><th>Shift 1 - Out</th><th>Shift 2 - In</th><th>Shift 2 - Out</th><th>Shift 3 - In</th><th>Shift 3 - Out</th></tr></thead>";

        foreach ($result_final as $key => $data)
        {
            echo "<tr><td>" . $key . "</td>";
            foreach ($data as $dshift => $total)
            {
                echo "<td>" . $total['count_in'] . "</td><td>" . $total['count_out'] . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    public function printulang()
    {
        $query = Db::table('transaction_log')->select('id')
            ->where('stat_timbang', '=', 1)
            ->orderBy('trans_date_after', 'desc')
            ->first();

        return exec("curl http://192.168.1.10/bantargebang/admin/reprint_auto.php?id=" . $query->id . "&user=auto");
    }

    public function dwellingtime(Request $request)
    {
        $dummyshift = array(
            '1' => '00:00:00 - 07:59:59',
            '2' => '08:00:00 - 15:59:59',
            '3' => '16:00:00 - 23:59:59'
        );
        $qzona = DB::table('lokasi')->select('nama_lokasi')
            ->get();

        $arr_label = DB::table('lokasi')->select('nama_lokasi')
            ->get();
        if ($request->user == "adminscan")
        {
            if ($request->date != "") $arr_transaction = DB::table('transaction_log')->where('tapbuangin', '!=', null)
                ->where('tapbuangout', '!=', null)
                ->where(DB::raw("DATE(tapbuangout)") , '=', $request->date)
                ->get();
            else $arr_transaction = DB::table('transaction_log')->where('tapbuangin', '!=', null)
                ->where('tapbuangout', '!=', null)
                ->where(DB::raw("DATE(tapbuangout)") , '=', DB::raw('CURRENT_DATE()'))
                ->get();
        }
        else
        {
            $arr_transaction = DB::table('transaction_log')->where('tapbuangin', '!=', null)
                ->where('tapbuangout', '!=', null)
                ->where(DB::raw("DATE(tapbuangout)") , '=', DB::raw('CURRENT_DATE()'))
                ->get();
        }
        $get_label = array();
        foreach ($arr_label as $p)
        {
            $get_label[$p
                ->nama_lokasi] = $p->nama_lokasi;
        }
        //First Foreach to set array
        foreach ($qzona as $zone)
        {
            $tempzona[] = $zone->nama_lokasi;
        }

        echo '<table class="table table-bordered">
            <thead>
                <th>Zona</th>
                <th>Jumlah</th>
            </thead>
                <tbody>';
        //print_r($arr_transaction);
        foreach ($get_label as $key => $stack)
        {
            $attach = array();
            if ($arr_transaction == "[]")
            {
                //echo "ada";
                $attach[$stack][] = round(0, 5);
            }
            else
            {
                foreach ($arr_transaction as $p)
                {
                    //echo "ga ada <br>";
                    //print_r($p);
                    if ($p->zona == $stack)
                    {
                        $diff = (strtotime($p->tapbuangout) - strtotime($p->tapbuangin));
                        if ($diff < 0) $attach[$stack][] = $diff;
                        else $attach[$stack][] = $diff;
                    }
                    elseif ($p->zona !== $stack)
                    {
                        $attach[$stack][] = 0;
                    }
                }
            }
            foreach ($attach as $key => $q)
            {
                $total = 0;
                foreach ($q as $loop)
                {
                    $total += $loop;
                }

                $fix = $total / count($q);
                $days = floor($fix / (24 * 60 * 60));
                $hours = floor(($fix - ($days * 24 * 60 * 60)) / (60 * 60));
                $minutes = floor(($fix - ($days * 24 * 60 * 60) - ($hours * 60 * 60)) / 60);
                //print_r($total);
                //print_r($fix."<br>");
                if ($hours == 0) echo "<tr><td>" . $key . "</td><td>" . $minutes . " Menit</td></tr>";
                else echo "<tr><td>" . $key . "</td><td>" . $hours . " Jam " . $minutes . " Menit</td></tr>";
            }
        }
        echo '</tbody></table>';
    }

    function simpanauto(Request $request)
    {
        $query = DB::table('rfid_card')->where('rfid_id', '=', $request->rfid)
            ->first();
        $cek = DB::select(DB::raw("select count(*) as total from transaction_log where door_id = '" . $query->door_id . "' and trans_date between date_sub(NOW(), INTERVAL 120 MINUTE) and NOW()"));
        $ekscek = DB::table('ekspenditur_list')->where('id', '=', $query->ekspenditur)
            ->first();
        $now = Carbon::now();
        $total = null;
        foreach ($cek as $a)
        {
            $total = $a->total;
        }
        if ($query->rfid_id == "")
        {
            return "RFID tidak terdaftar";
        }
        elseif ($query->status == "blok")
        {
            return "truk blok";
        }
        elseif ($query->status == "retri")
        {
            return "truk retri";
        }
        elseif ($query->status == "izin")
        {
            return "truk izin";
        }
        elseif ($ekscek->status == "blok")
        {
            return "ekspenditur blok";
        }
        elseif ($ekscek->status == "retri")
        {
            return "ekspenditur retri";
        }
        elseif ($ekscek->status == "izin")
        {
            return "ekspenditur izin";
        }
        elseif ($total != 0)
        {
            return "Kendaraan baru saja melewati timbangan kurang dari 2 jam";
        }
        else
        {
            $data = new TransactionLog;
            $data->trans_date = Carbon::now();
            $data->trans_scale = 'Timbangan Masuk';
            $data->truck_id = $query->truck_id;
            $data->weight = $request->berat;
            $data->stat_timbang = 0;
            $data->door_id = $query->door_id;
            $data->save();

            $rfid = RfidCard::where('rfid_id', '=', $request->rfid)
                ->first();
            if ($rfid->avg_masuk == 0) $rfid->avg_masuk = ($request->berat + $rfid->avg_masuk) / 2;
            else $rfid->avg_masuk = $request->berat;
            $rfid->save();

            return "Transaksi berhasil";
        }
    }

    function simpanauto2(Request $request)
    {
        $query = DB::table('rfid_card')->where('rfid_id', '=', $request->rfid)
            ->first();
        // $cek = DB::select(DB::raw("select count(*) as total from transaction_log where door_id = '".$query->door_id."' and trans_date_after between date_sub(NOW(), INTERVAL 120 MINUTE) and NOW()"));
        $ekscek = DB::table('ekspenditur_list')->where('id', '=', $query->ekspenditur)
            ->first();
        $now = Carbon::now()->toDateTimeString();
        $sub = Carbon::now()->subDay(1);
        // return $sub;

        $cek_range = TransactionLog::where('door_id', '=', $query->door_id)->whereBetween('trans_date', [$sub, $now])->orderBy('trans_date', 'desc')->get();
        

        $total = null;
        $getstruk = TransactionLog::select('id_struk')->where('stat_timbang', '=', 1)
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

        // foreach($cek as $a){
        //  $total = $a->total;
        // }
        if ($query->rfid_id == "")
        {
            return "RFID tidak terdaftar";
        }
        elseif ($query->status == "blok")
        {
            return "truk blok";
        }
        elseif ($query->status == "retri")
        {
            return "truk retri";
        }
        elseif ($query->status == "izin")
        {
            return "truk izin";
        }
        elseif ($ekscek->status == "blok")
        {
            return "ekspenditur blok";
        }
        elseif ($ekscek->status == "retri")
        {
            return "ekspenditur retri";
        }
        elseif ($ekscek->status == "izin")
        {
            return "ekspenditur izin";
            // }elseif($total != 0){
            //     return "Kendaraan baru saja melewati timbangan kurang dari 2 jam";
            
        }elseif ($cek_range == "[]"){
            return "Menimbang masuk ke keluar telah melebihi dari 1 hari";
        }
        else
        {
            $data = TransactionLog::where('door_id', '=', $query->door_id)
                ->orderBy('trans_date', 'desc')
                ->where('stat_timbang', '=', 0)
                ->first();
            if (empty($data)) return "Data timbang masuk tidak ada!";
            $data->trans_date_after = Carbon::now();
            $data->trans_scale = 'Timbangan Keluar';
            $data->weight_after = $request->berat;
            $data->dwell = Carbon::now()->timestamp - Carbon::parse($data->trans_date)->timestamp;
            $data->id_struk = $id_struk;
            $data->stat_timbang = 1;
            $data->save();

            $rfid = RfidCard::where('rfid_id', '=', $request->rfid)
                ->first();
            if ($rfid->avg_keluar == 0) $rfid->avg_keluar = ($request->berat + $rfid->avg_masuk) / 2;
            else $rfid->avg_keluar = $request->berat;
            $rfid->save();

            exec("curl http://192.168.1.10/bantargebang/admin/reprint_auto.php?id=" . $data->id . "&user=auto");
            return "Transaksi berhasil";
        }
    }
    //NEW 2019-07-04
    
}

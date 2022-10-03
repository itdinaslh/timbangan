<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use DB;
use Carbon\Carbon;


class Index extends Component
{
    public $countdump,$count_truk;
    public $getdwell = 8, $masuk = 0, $keluar = 0, $count = 0,  $waktu = "hari";
    public $count_truk_dwell;
    public $count_komulatif;

    public function render()
    {
        $total = DB::connection('bg_db')->table('transaction_log')->where('stat_timbang', '=', '0')->whereDate('trans_date', Carbon::today())->count();

        $this->countdump = $total;
        $query = DB::connection('bg_db')
            ->select(
                DB::raw("select count(*) as truk, SEC_TO_TIME(AVG(dwell)) as total from transaction_log where stat_timbang = '1' and dwell between 900 and 86400 and (weight - weight_after) between 200 and 30000 and trans_date_after between date_sub(now(), INTERVAL " .  $this->getdwell . " HOUR) and now()"));

        foreach ($query as $a)
        {
            $total = explode(":", $a->total);
            if ($total == [""])
            {
                $total[0] = 0;
                $total[1] = 0;
                $count_truk_d = $a->truk;
                $jam = $total[0];
                $menit = $total[0];
            }
            else
            {
                $count_truk_d = $a->truk;
                $jam = $total[0];
                $menit = $total[0];
            
            }
        }
        
       
        if ($this->waktu == "kemarin")
        {
            $Kumulatif = DB::connection('bg_db')
                ->table('transaction_log')->where('stat_timbang', '=', '1') 
                ->whereDate('trans_date_after', Carbon::yesterday())
                ->value(DB::raw("SUM((weight - weight_after)/1000)"));
            $count_truk = DB::connection('bg_db')
            ->table('transaction_log')->where('stat_timbang', '=', '1') 
            ->whereDate('trans_date_after', Carbon::yesterday())
            ->count();
        }
        elseif ($this->waktu == "hari")
        {
            $Kumulatif = DB::connection('bg_db')
                ->table('transaction_log')->where('stat_timbang', '=', '1') 
                ->whereDate('trans_date_after', Carbon::today())
                ->value(DB::raw("SUM((weight - weight_after)/1000)"));      
            $count_truk =  DB::connection('bg_db')
            ->table('transaction_log')->where('stat_timbang', '=', '1') 
            ->whereDate('trans_date_after', Carbon::today())
            ->count();  
        }
        elseif ($this->waktu == "minggu")
        {
            $Kumulatif = DB::connection('bg_db')
                ->table('transaction_log')->where('stat_timbang', '=', '1') 
                ->whereBetween('trans_date_after', [Carbon::now()->subWeek(), Carbon::now()])
                ->value(DB::raw("SUM((weight - weight_after)/1000)"));
            $count_truk = DB::connection('bg_db')
            ->table('transaction_log')->where('stat_timbang', '=', '1') 
            ->whereBetween('trans_date_after', [Carbon::now()->subWeek(), Carbon::now()])
            ->count();
        }
        elseif ($this->waktu == "bulan")
        {
            $Kumulatif = DB::connection('bg_db')
                ->table('transaction_log')
                ->where('stat_timbang', '=', '1') 
                ->whereYear('trans_date_after', '=', Carbon::now()->format('Y'))
                ->whereMonth('trans_date_after', '=', Carbon::now()->format('m'))
                ->value(DB::raw("SUM((weight - weight_after)/1000)"));
            $count_truk = DB::connection('bg_db')
            ->table('transaction_log')
            ->where('stat_timbang', '=', '1') 
            ->whereYear('trans_date_after', '=', Carbon::now()->format('Y'))
            ->whereMonth('trans_date_after', '=', Carbon::now()->format('m'))
            ->count();
        }


        $this->count_truk_dwell = $count_truk_d;
        $this->count_jam_dwell = $jam;
        $this->count_menit_dwell = $menit;
        $this->count_komulatif = $Kumulatif;
        $this->count_truk = $count_truk;
        return view('livewire.admin.index');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\TipeTruk;
use DataTables;
use DB;
use Auth;
use Carbon\Carbon;

class TruckController extends Controller
{
    public function index()
    {
        return view('admin.truck.index');
    }

    public function Add() {
        $area = Truck::select(DB::raw('SUBSTRING_INDEX(area, ",", 1) as area'))->distinct()->get();
            $penugasan = Truck::select(DB::raw('SUBSTRING_INDEX(area, ",", -1) as area'))->distinct()->get();
            $tipe = TipeTruk::select('tipe', 'initial')->get();
        return view('admin.truck.addedit', ['data' => new Truck, 'area'=>$area, 'penugasan'=>$penugasan, 'tipe'=>$tipe]);
    }

    public function Edit($id) {
        $data = DB::connection('bg_db')->table('rfid_card as a')
            ->leftJoin('ekspenditur_list', 'a.ekspenditur', '=', 'ekspenditur_list.id')
            ->leftJoin('tipe_truk', 'a.tipe', '=', 'tipe_truk.initial')
            ->select('a.*', 'tipe_truk.initial', 'ekspenditur_list.ekspenditur_name')
            ->where('a.id', '=', $id)->first();
            $area = Truck::select(DB::raw('SUBSTRING_INDEX(area, ",", 1) as area'))->distinct()->get();
            $penugasan = Truck::select(DB::raw('SUBSTRING_INDEX(area, ",", -1) as area'))->distinct()->get();
            $tipe = TipeTruk::select('tipe', 'initial')->get();
        return view('admin.truck.addedit', ['data' => $data, 'area'=>$area, 'penugasan'=>$penugasan, 'tipe'=>$tipe]);
    }

    public function store(Request $v) {
        if ($v->id == 0) {
            $data = new Truck;
        } else {
            $data = Truck::findOrFail($v->id);
        }

        $area = $v->area1 . ", " . $v->area2;
        $data->rfid_id = $v->rfid;
        $data->pd_pasar = "";
        $data->avg_masuk = 0;
        $data->avg_in = 0;
        $data->status = $v->status;
        $data->truck_id = $v->truk_id;
        $data->door_id = $v->door_id;
        $data->ekspenditur = $v->ekspenditur;
        $data->area = $area;
        $data->tipe = $v->tipe;
        $data->jumlah_roda = $v->jumlah_roda;
        $data->kir = $v->kir;
        $data->tanggal = Carbon::now();
        $data->save();
        return ['success' => true];
    }

    public function delete($id)
    {
        Truck::find($id)->delete();

        return ['success' => true];
    }
}

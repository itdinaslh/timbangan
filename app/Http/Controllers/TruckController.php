<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truck;
use DataTables;
use DB;
use Auth;

class TruckController extends Controller
{
    public function index()
    {
        return view('admin.truck.index');
    }

    public function Add() {
        return view('admin.truck.addedit', ['data' => new Truck]);
    }

    public function Edit($id) {
        return view('admin.truck.addedit', ['data' => Truck::findOrFail($id)]);
    }

    public function store(Request $v) {
        if ($v->id == 0) {
            $data = new Truck;
        } else {
            $data = Truck::findOrFail($v->id);
        }

        $data->rfid_id = $v->rfid_id;
        $data->truck_id = $v->truck_id;
        $data->ekspenditur = $v->ekspenditur;
        $data->door_id = $v->door_id;
        $data->area = $v->area;
        $data->tanggal = $v->tanggal;
        $data->tipe = $v->tipe;
        $data->jumlah_roda = $v->jumlah_roda;
        $data->pd_pasar = $v->pd_pasar;
        $data->avg_masuk = $v->avg_masuk;
        $data->avg_keluar = $v->avg_keluar;
        $data->lokasi_b2b = $v->lokasi_b2b;
        $data->alamat_b2b = $v->alamat_b2b;
        $data->kecamatan_b2b = $v->kecamatan_b2b;
        $data->kir = $v->kir;
        $data->status = $v->status;
        $data->save();
        return ['success' => true];
    }

    public function delete($id)
    {
        Truck::find($id)->delete();

        return ['success' => true];
    }
}

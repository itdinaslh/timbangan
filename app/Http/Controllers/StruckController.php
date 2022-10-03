<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Struck;
use DataTables;
use DB;
use Auth;

class StruckController extends Controller
{
    public function index()
    {
        return view('admin.struck.index');
    }
    public function Add() {
        return view('admin.struck.addedit', ['data' => new Struck]);
    }
    public function Edit($id) {
        return view('admin.struck.addedit', ['data' => Struck::findOrFail($id)]);
    }

    public function store(Request $v) {
        if ($v->id == 0) {
            $data = new Struck;
        } else {
            $data = Struck::findOrFail($v->id);
        }

        $data->trans_date = $v->trans_date;
        $data->trans_date_after = $v->trans_date_after;
        $data->door_id = $v->door_id;
        $data->truck_id = $v->truck_id;
        $data->weight = $v->weight;
        $data->weight_after = $v->weight_after;
        $data->save();
        return ['success' => true];
    }


    public function delete($id)
    {
        Struck::find($id)->delete();

        return ['success' => true];
    }
}

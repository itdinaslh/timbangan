<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekspenditur_list;
use DataTables;
use DB;
use Auth;

class EkspenditurController extends Controller
{
    public function index()
    {
        return view('admin.ekspenditur.index');
    }

    public function Add() {
        return view('admin.ekspenditur.addedit', ['data' => new Ekspenditur_list]);
    }

    public function Edit($id) {
        return view('admin.ekspenditur.addedit', ['data' => Ekspenditur_list::findOrFail($id)]);
    }

    public function store(Request $v) {
        if ($v->id == 0) {
            $data = new Ekspenditur_list;
        } else {
            $data = Ekspenditur_list::findOrFail($v->id);
        }

        $data->ekspenditur_name = $v->ekspenditur_name;
        $data->status = $v->status;
        $data->save();
        return ['success' => true];
    }

    public function Ajax(Request $request)
    {
        $data = Ekspenditur_list::select([
            'ekspenditur_name', 'id', 'status'
        ]);
        $datatables = Datatables::of($data);

        return $datatables->addIndexColumn()
        ->addColumn('action', function($row){

                $btn = '<button class="btn btn-clean font-weight-bolder showMe" data-href="/data_ekspenditur/edit/'.$row->id.'"><i class="la la-edit"></i></button>';

               $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-clean btn-sm deleteProduct"><i class="la la-trash"></i></a>';

                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);

    }

    public function delete($id)
    {
        Ekspenditur_list::find($id)->delete();

        return ['success' => true];
    }

    public function search(Request $v) {
        if (empty($v->q)) {
            $data = Ekspenditur_list::select(['id', 'ekspenditur_name'])->orderBy('ekspenditur_name', 'asc')->get();
        } else {
            $data = Ekspenditur_list::where('ekspenditur_name', 'like', '%'.$v->q.'%')->orderBy('ekspenditur_name', 'asc')->get();
        }

        return response()->json($data);
    }
}

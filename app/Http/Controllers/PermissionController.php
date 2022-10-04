<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;


class PermissionController extends Controller
{
    public function index()
    {
        return view('admin.permission.index');
    }

    public function Add() {
        return view('admin.permission.addedit', ['data' => new Permission]);
    }

    public function Edit($id) {
        return view('admin.permission.addedit', ['data' => Permission::findOrFail($id)]);
    }

    public function store(Request $v) {
        if ($v->id == 0) {
            $data = new Permission;
        } else {
            $data = Permission::findOrFail($v->id);
        }

        $data->name = $v->name;
        $data->guard_name = $v->guard_name;
        $data->save();
        return ['success' => true];
    }

    public function Ajax(Request $request)
    {
        $data = Permission::select([
            'permission_name', 'id', 'status'
        ]);
        $datatables = Datatables::of($data);

        return $datatables->addIndexColumn()
        ->addColumn('action', function($row){

                $btn = '<button class="btn btn-clean font-weight-bolder showMe" data-href="/data_permission/edit/'.$row->id.'"><i class="la la-edit"></i></button>';

               $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-clean btn-sm deleteProduct"><i class="la la-trash"></i></a>';

                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);

    }

    public function delete($id)
    {
        Permission::find($id)->delete();

        return ['success' => true];
    }

    public function search(Request $v) {
        if (empty($v->q)) {
            $data = Permission::select(['id', 'permission_name'])->orderBy('permission_name', 'asc')->get();
        } else {
            $data = Permission::where('permission_name', 'like', '%'.$v->q.'%')->orderBy('permission_name', 'asc')->get();
        }

        return response()->json($data);
    }
}

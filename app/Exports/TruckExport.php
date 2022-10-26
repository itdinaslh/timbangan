<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class TruckExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        DB::statement(DB::raw('set @rownum=0'));
        $data = DB::connection('bg_db')->table('rfid_card as a')
            ->leftJoin('ekspenditur_list', 'a.ekspenditur', '=', 'ekspenditur_list.id')
            ->leftJoin('tipe_truk', 'a.tipe', '=', 'tipe_truk.initial')
            ->select(
                DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'a.tanggal',
                'a.door_id', 
                'a.truck_id',
                'a.rfid_id', 
                'ekspenditur_list.ekspenditur_name' ,
                DB::raw('SUBSTRING_INDEX(a.area, ",", 1) as areas'),
                DB::raw('SUBSTRING_INDEX(a.area, ",", -1) as penugasan'),
                'tipe_truk.initial',
                'a.jumlah_roda',
                'a.pd_pasar', 
                'a.kir')
            ->orderBy('a.id' ,'desc')
        ->get();

        return $data;
    }
    public function headings() : array {
        return [
            'NO',
            'TANGGAL Dan WAKTU',
            'NO POLISI',
            'NO PINTU',
            'RFID',
            'EKSPENDITUR',
            'AREA KERJA',
            'PENUGASAN',
            'TIPE TRUK',
            'JUMLAH RODA',
            'PD PASAR',
            'KIR'
        ];
    }
}

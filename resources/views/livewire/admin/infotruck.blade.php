<div>
    <div class="row">
        <div class="col-sm-6">
            <div class="pull-left">
                <div class="form-inline pull-left">
                    <div class="mb-3 row">
                        <label class="col-md-6 col-form-label">Show</label>
                        <div class="col-md-6">
                            <select class="form-control" wire:model='show'>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">15</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="">
                <div class="form-inline">
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Status : </label>
                        <div class="col-sm-4">
                            <select class="form-control" wire:model='filter'>
                                <option value="">Semua Perusahaan</option>
                                <option value="retri">Retribution</option>
                                <option value="blok">Blok</option>
                                <option value="izin">Izin</option>
                            </select> 
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="SearchTable" id="SearchTable" wire:model="search" class="form-control" placeholder="Search...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover m-b-0 table-bordered table-striped text-center" wire:poll>
            <thead style="background-color: transparent;">
                <tr class="">
                    <th>No Truck</th>
                    <th>No Pintu</th>
                    <th>RFID</th>
                    <th>Ekspenditur</th>
                    <th>Area</th>
                    <th>Penugasan</th>
                    <th>Kir</th>
                    <th>Tipe</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    <tr>
                        <td>{{$row->truck_id}}</td>
                        <td>{{$row->door_id}}</td>
                        <td>{{$row->rfid_id}}</td>
                        <td>{{$row->ekspenditur_name}}</td>
                        <td>{{$row->areas}}</td>
                        <td>{{$row->penugasan}}</td>
                        <td>{{$row->kir}}</td>
                        <td>{{$row->tipe}}</td>
                        <td>{{$row->status}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-6 mt-3">
                <b>Total {{ $data->total() }} entries</b> 
            </div>
            <div class="col-md-6 mt-3">
                <div class="pull-right">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
        
    </div>
</div>

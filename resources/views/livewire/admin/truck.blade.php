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
            <div class="pull-right">
                <div class="form-inline pull-right">
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Status : </label>
                        <div class="col-sm-6">
                            <select class="form-control" wire:model='filter'>
                                <option value="">Semua Perusahaan</option>
                                <option value="blok">Di Blokir</option>
                            </select> 
                        </div>
                        <div class="col-sm-4">
                            <input type="text" name="SearchTable" id="SearchTable" wire:model="search" class="form-control" placeholder="Search...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover m-b-0 table-bordered table-striped" wire:poll>
            <thead style="background-color: transparent;">
                <tr class="text-center">
                    <th>Nomer Truck</th>
                    <th>Nomer Pintu</th>
                    <th>RFID</th>
                    <th>Ekspenditur</th>
                    <th>Status</th>
                    <th>Kir</th>
                    <th>Tipe Truk</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    <tr>
                        <td>{{$row->truck_id}}</td>
                        <td>{{$row->door_id}}</td>
                        <td>{{$row->door_id}}</td>
                        <td>{{$row->door_id}}</td>
                        <td>{{$row->door_id}}</td>
                        <td>{{$row->kir}}</td>
                        <td>{{$row->tipe}}</td>
                        <td>{{$row->status}}</td>
                        <td style="width: 10%; max-width: 15%">
                            <button class="btn btn-clean font-weight-bolder showMe" data-href="/edit_transaksi/edit/{{$row->id}}"><i class="la la-edit"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col-md-12 mt-3">
            <div class="pull-right">
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>
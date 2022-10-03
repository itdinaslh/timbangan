<div>
    <div class="row">
        <div class="col-md-6">
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
        <div class="col-md-6">
            <div class="pull-right">
                <div class="form-inline pull-right">
                    <div class="row">
                        <div class="col-sm-8">
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
                    <th>No</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
                    <th>No. Pintu</th>
                    <th>Truk ID</th>
                    <th>Berat Masuk</th>
                    <th>Berat Keluar</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    <tr>
                        <td class="text-center">{{$row->id}}</td>
                        <td>{{$row->trans_date}}</td>
                        <td>{{$row->trans_date_after}}</td>
                        <td>{{$row->door_id}}</td>
                        <td>{{$row->truck_id}}</td>
                        <td>{{$row->weight}}</td>
                        <td>{{$row->weight_after}}</td>
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

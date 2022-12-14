<div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="form-inline">
                <div class="col-mb-12 row">
                    <label class="col-md-2 col-form-label">Show</label>
                    <div class="col-md-3">
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
        <div class="col-md-6">
            <div class="pull-right">
                <div class="form-inline pull-right">
                    <div class="row">
                        <div class="col-sm-12">
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
                    <th>Masuk</th>
                    <th>No. Pintu</th>
                    <th>Truk ID</th>
                    <th>Berat Masuk</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($table as $row)
                    <tr>
                        <td>{{$row->trans_date}}</td>
                        <td>{{$row->door_id}}</td>
                        <td>{{$row->truck_id}}</td>
                        <td>{{$row->weight}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col-md-12 mt-3">
            <div class="pull-right">
                {{ $table->links() }}
            </div>
        </div>
    </div>
</div>

<form action="/edit_transaksi/store" method="post">
    <div class="modal-header bg-primary-500 bg-success-gradient">
        <h4 class="modal-title">
            @if ($data->id != 0)
            Edit Transaksi
            @else
            Tambah Transaksi Baru
            @endif</h4>
        <button type="button" class="btn-close text-red" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body ">
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Tanggal Masuk</label>
                    <input type="hidden" name="id" value="{{$data->id}}">
                    <input type="datetime-local" name="trans_date" class="form-control" required autocomplete="off"
                        value="{{$data->trans_date}}" />
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Tanggal Keluar</label>
                    <input type="datetime-local" name="trans_date_after" class="form-control" required autocomplete="off"
                        value="{{$data->trans_date_after}}" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group">
                    <label>No. Pintu</label>
                    <input type="text" name="door_id" class="form-control" required autocomplete="off"
                        value="{{$data->door_id}}" />
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Truk ID</label>
                    <input type="text" name="truck_id" class="form-control" required autocomplete="off"
                        value="{{$data->truck_id}}" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Berat Masuk</label>
                    <input type="text" name="weight" class="form-control" required autocomplete="off"
                        value="{{$data->weight}}" />
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Berat Keluar</label>
                    <input type="text" name="weight_after" class="form-control" required autocomplete="off"
                        value="{{$data->weight_after}}" />
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>

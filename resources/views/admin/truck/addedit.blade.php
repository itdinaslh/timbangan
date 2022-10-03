<form action="/data_truk/store" method="post">
    <div class="modal-header bg-primary-500 bg-success-gradient">
        <h4 class="modal-title">
            @if ($data->id != 0)
            Edit Truk
            @else
            Tambah Truk Baru
            @endif</h4>
        <button type="button" class="btn-close text-red" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body ">
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group">
                    <label>RFID</label>
                    <input type="hidden" name="id" value="{{$data->id}}">
                    <input type="text" name="rfid_id" class="form-control" autocomplete="off"
                        value="{{$data->rfid_id}}" />
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Nomer Truk</label>
                    <input type="text" name="truck_id" class="form-control" required autocomplete="off"
                        value="{{$data->truck_id}}" />
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
                    <label>Ekspenditur</label>
                    <select name="ekpenditur" id="ekpenditur" class="form-control" required autocomplete="off">
                        <option value="{{$data->ekpenditur}}">{{$data->ekspenditur}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Area</label>
                    <input type="text" name="area" class="form-control" required autocomplete="off"
                        value="{{$data->area}}" />
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="text" name="tanggal" class="form-control" required autocomplete="off"
                        value="{{$data->tanggal}}" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Tipe</label>
                    <input type="text" name="tipe" class="form-control" required autocomplete="off"
                        value="{{$data->tipe}}" />
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Jumlah Roda</label>
                    <input type="text" name="jumlah_roda" class="form-control" required autocomplete="off"
                        value="{{$data->jumlah_roda}}" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group">
                    <label>PD PASAR</label>
                    <input type="text" name="pd_pasar" class="form-control"  autocomplete="off"
                        value="{{$data->pd_pasar}}" />
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>KIR</label>
                    <input type="text" name="kir" class="form-control"  autocomplete="off"
                        value="{{$data->kir}}" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Status</label>
                    <input type="text" name="status" class="form-control" required autocomplete="off"
                        value="{{$data->status}}" />
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>

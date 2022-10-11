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
                    <input type="text" name="truk_id" class="form-control"  autocomplete="off"
                        value="{{$data->truck_id}}" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group">
                    <label>No. Pintu</label>
                    <input type="text" name="door_id" class="form-control"  autocomplete="off"
                        value="{{$data->door_id}}" />
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Ekspenditur</label>
                    <select name="ekspenditur" id="ekspenditur" class="form-control"  autocomplete="off">
                        <option value="{{$data->ekspenditur}}" selected="selected">{{$data->ekspenditur_name}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Area</label>
                    <select name="area1" id="area" class="form-control"  autocomplete="off">
                        @if($data->area == "")
                        <option value="">Pilih area</option>
                        @endif
                        @foreach($area as $a)
                            <option value="{{ $a->area }}">{{ $a->area }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Penugasan</label>
                    <select name="area2" id="penugasan" class="form-control"  autocomplete="off">
                        @if($data->area == "")
                        <option value="">Pilih Penugasan</option>
                        @endif
                        @foreach($penugasan as $a)
                            <option value="{{ $a->area }}">{{ $a->area }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Tipe</label>
                    <select name="tipe" id="tipe" class="form-control"  autocomplete="off">
                        @if($data->tipe == "")
                        <option value="">Pilih Tipe</option>
                        @else
                        <option value="{{ $data->initial }}" selected>{{ $data->tipe ." - (". $data->initial .")" }}</option>
                        @endif
                        @foreach($tipe as $b)
                            <option value="{{ $b->initial }}">{{ $b->tipe ." - (". $b->initial .")" }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Jumlah Roda</label>
                    <select name="jumlah_roda" id="jumlah_roda" class="form-control"  autocomplete="off">
                        <option value="4R"  {{ ( $data->jumlah_roda == '4R') ? 'selected' : '' }}>4R</option>
                        <option value="6R"  {{ ( $data->jumlah_roda == '6R') ? 'selected' : '' }}>6R</option>
                        <option value="8R" {{ ( $data->jumlah_roda == '8R') ? 'selected' : '' }}>8R</option>
                        <option value="10R" {{ ( $data->jumlah_roda == '10R') ? 'selected' : '' }}>10R</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group">
                    <label>KIR</label>
                    <input type="text" name="kir" class="form-control"  autocomplete="off"
                        value="{{$data->kir}}" />
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control"  autocomplete="off">
                        <option value="">Pilih status blokir</option>
                        <option value="retri" {{ ( $data->status == 'retri') ? 'selected' : '' }}>Retribution</option>
                        <option value="blok" {{ ( $data->status == 'blok') ? 'selected' : '' }}>Blok</option>
                        <option value="izin" {{ ( $data->status == 'izin') ? 'selected' : '' }}>Izin</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>

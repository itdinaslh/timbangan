<div wire:poll>
    <div class="row invoice-card-row">
        <div class="col-xl-4 col-lg-6 col-xxl-4 col-sm-6">
            <div class="card bg-warning invoice-card">
                <div class="card-body d-flex">
                    <div>
                        <span class="text-white fs-18">Jumlah Truk Dumping : </span>
                        <h2 class="text-white invoice-num">{{$countdump}} Truk</h2>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-xxl-4 col-sm-6">
            <div class="card bg-success invoice-card">
                <div class="card-body d-flex">
                    <div>
                        <span class="text-white fs-18">Rata - Rata Dwelling Time :</span>
                        <h2 class="text-white invoice-num">{{ $count_truk_dwell }} Truk<br><small>{{ $count_jam_dwell }} Jam {{ $count_menit_dwell }} Menit</small></h2>
                        
                        <select class="form-control" wire:model='getdwell'>
                            <option value="4">4 Jam</option>
                            <option value="8" >8 Jam</option>
                            <option value="12">12 Jam</option>
                            <option value="16">16 Jam</option>
                            <option value="20">20 Jam</option>
                            <option value="24">24 Jam</option>
                        </select> 
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-xxl-4 col-sm-6">
            <div class="card bg-info invoice-card">
                <div class="card-body d-flex">
                    <div>
                        <span class="text-white fs-18">Statik Kumulatif :</span>
                        <h2 class="text-white invoice-num"> {{ $count_truk }}Truk<br><small>{{ round($count_komulatif, 0) }} Tonase</small></h2>
                        
                        <select class="form-control" wire:model='waktu'>
                            <option value="kemarin">Per Kemarin</option>
                            <option value="hari" selected="">Per Hari Ini</option>
                            <option value="minggu">Per Minggu</option>
                            <option value="bulan">Per Bulan</option>
                        </select> 
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    
</div>

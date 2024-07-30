<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Aset {{ $data['kode_aset'] ?? '' }}</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row g-2">
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Nama Aset</label>
            <p>{{ $data['nama_aset'] ?? '' }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Tipe Aset</label>
            <p>{{ ucfirst($data['tipe_aset'] ?? '') }}</p>
        </div>
    </div>
    <hr class="mt-2 mb-2">
    <div class="row g-2">
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Stok Aset</label>
            <p>{{ $data['stok_sekarang'] ?? '' }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Harga Aset</label>
            <p>Rp {{ number_format($data['harga'] ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="col">
            <label class="font-weight-bold text-primary">Masa Berlaku</label>
            <p>{{ $data['masa_berlaku'] ?? '' }}</p>
        </div>
        <div class="col">
            <label class="font-weight-bold text-primary">Tanggal Penerimaan</label>
            <p>{{ $data['tanggal_penerimaan'] ?? '' }}</p>
        </div>
    </div>
    <hr class="mt-2 mb-2">
    <div class="row g-2">
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Status Aset</label>
            <p>{{ $data->dataStatus->nama_status ?? '' }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Kondisi Aset</label>
            <p>{{ $data->dataKondisi->nama_status ?? '' }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Lokasi Aset</label>
            <p>{{ $data->dataLokasi->location ?? '' }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Pemilik Aset</label>
            <p>{{ $data->dataUser->name ?? '' }}</p>
        </div>
    </div>
    <hr class="mt-2 mb-2">
    <div class="row g-2">
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Spesifikasi</label>
            <p>{!! nl2br(e($data['spesifikasi'] ?? '-')) !!}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Keterangan</label>
            <p>{!! nl2br(e($data['keterangan'] ?? '-')) !!}</p>
        </div>
        @canany(['isSuperAdmin', 'isAdmin'])
            <div class="col-lg">
                <label class="font-weight-bold text-primary">Data Kredensial | <span class="text-warning">Khusus Admin</span></label>
                <p>{!! nl2br(e($data['data_kredensial'] ?? '-')) !!}</p>
            </div>
        @endcanany
    </div>
    <hr class="mt-2 mb-2">
    <div class="accordion mt-4">
        <div class="card accordion-item">
            <h2 class="accordion-header d-flex align-items-center">
              <button
                type="button"
                class="accordion-button collapsed"
                data-bs-toggle="collapse"
                data-bs-target="#accordionWithIcon-1"
                aria-expanded="true">
                <i class="ti ti-qrcode me-2"></i>
                Tampikan QR Code
              </button>
            </h2>

            <div id="accordionWithIcon-1" class="accordion-collapse collapse">
              <div class="accordion-body">
                {!! QrCode::size(200)->backgroundColor(255, 255, 255)->color(0, 0, 0)->margin(1)->generate($qr_link) !!}
              </div>
            </div>
          </div>
    </div>
</div>
<div class="modal-footer">
    <div class="text-end mt-3">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</div>
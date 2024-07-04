<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Aset Permintaan</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row g-2">
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Nama Aset</label>
            <p>{{ $data['nama_aset'] }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Tipe Aset</label>
            <p>{{ ucfirst($data['tipe_aset']) }}</p>
        </div>
    </div>
    <hr class="mt-2 mb-2">
    <div class="row g-2">
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Stok Permintaan Aset</label>
            <p>{{ $data['stok_permintaan'] }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Harga Aset</label>
            <p>Rp {{ number_format($data['harga'], 0, ',', '.') }}</p>
        </div>
        <div class="col">
            <label class="font-weight-bold text-primary">Masa Berlaku</label>
            <p>{{ $data['masa_berlaku'] }}</p>
        </div>
    </div>
    <hr class="mt-2 mb-2">
    <div class="row g-2">
        <div class="col-lg-6">
            <label class="font-weight-bold text-primary">Spesifikasi</label>
            <p>{{ $data['spesifikasi'] }}</p>
        </div>
        <div class="col">
            <label class="font-weight-bold text-primary">Keterangan</label>
            <p>{{ $data['keterangan'] }}</p>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="text-end mt-3">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</div>
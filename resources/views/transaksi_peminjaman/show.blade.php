<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ ucfirst($data->tipe_transaksi ?? '') }} Aset oleh {{ $data->dataUser->name ?? '' }}</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row g-2">
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Nama Aset</label>
            <p>{{ $data->dataAsset['nama_aset'] ?? '' }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Tipe Aset</label>
            <p>{{ ucfirst($data->dataAsset['tipe_aset'] ?? '') }}</p>
        </div>
    </div>
    <hr class="mt-2 mb-2">
    <div class="row g-2">
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Tipe Transaksi</label>
            <p>{{ $data['tipe_transaksi'] ?? '' }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Kode Transaksi</label>
            <p>{{ $data['kode_transaksi'] ?? '' }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Jumlah {{ ucfirst($data->tipe_transaksi ?? '') }}</label>
            <p>{{ $data['stok'] ?? '' }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Pelaku Transaksi</label>
            <p>{{ $data->dataUser->name ?? '' }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Tanggal Transaksi</label>
            <p>{{ $data['tanggal_transaksi'] ?? '' }}</p>
        </div>
    </div>
    <hr class="mt-2 mb-2">
    <div class="mb-1">
        <label class="font-weight-bold text-primary">Keterangan Transaksi</label>
        <p>{{ $data['keterangan'] ?? '' }}</p>
    </div>
</div>
<div class="modal-footer">
    <div class="text-end mt-3">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</div>
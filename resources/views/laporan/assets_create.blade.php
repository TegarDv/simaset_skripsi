<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Print Data Aset</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form class="row g-3" action="{{ route('asset_print') }}" method="POST" id="createForm">
        @csrf

        <div class="row mb-2">
            <div class="col">
                <label class="font-weight-bold">Filter by Tipe Aset</label>
                <select class="form-select" name="tipe_aset" required>
                    <option>Select Tipe Aset</option>
                    <option value="all">All</option>
                    <option value="fisik">Fisik</option>
                    <option value="digital">Digital</option>
                    <option value="layanan">Layanan</option>
                </select>
            </div>
            <div class="col">
                <label class="font-weight-bold">Filter by Status</label>
                <select class="form-select" name="status_aset" required>
                    <option disabled selected>Pilih Status Aset</option>
                    <option value="all">All</option>
                    @foreach ($status as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_status }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label class="font-weight-bold">Tanggal Awal</label>
                <input type="date" class="form-control" name="tanggal_awal">
            </div>
            <div class="col">
                <label class="font-weight-bold">Tanggal Akhir</label>
                <input type="date" class="form-control" name="tanggal_akhir">
            </div>
        </div>

        <div class="modal-footer">
            <div class="text-end mt-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-md btn-primary">Create</button>
            </div>
        </div>
    </form>
</div>

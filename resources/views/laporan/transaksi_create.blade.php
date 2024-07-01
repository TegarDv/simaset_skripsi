<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Print Data Transaksi</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form class="row g-3" action="{{ route('transaksi_print') }}" method="POST" id="createForm">
        @csrf

        <div class="mb-2">
            <label class="font-weight-bold">Filter by Tipe Transaksi</label>
            <select class="form-select" name="tipe_transaksi" required>
                <option>Select Tipe Aset</option>
                <option value="all">All</option>
                <option value="peminjaman">Peminjaman</option>
                <option value="pengembalian">pengembalian</option>
            </select>
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
<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Pengembalian</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form class="row g-3" action="{{ route('transaction-kembali.store') }}" method="POST" id="createForm">
        @csrf
        
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-2">
                    <label class="font-weight-bold">Tanggal Pengembalian</label>
                    <input type="date" class="form-control" name="tanggal" required>
                </div>
                <div class="mb-2">
                    <label class="font-weight-bold">User yang mengembalikan</label>
                    <select class="form-select" name="user" required>
                        <option value="">Pilih User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="font-weight-bold">Jumlah Pengembalian</label>
                    <input type="number" class="form-control" name="jumlah" id="jumlah" required>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-2">
                    <label class="font-weight-bold">Pilih Aset</label>
                    <select class="form-select" name="asset" id="assetSelect" required>
                        <option value="">Select Asset</option>
                        @foreach ($assets as $asset)
                            <option value="{{ $asset->kode_aset }}" data-nama="{{ $asset->nama_aset }}" data-tipe="{{ $asset->tipe_aset }}" data-stok="{{ $asset->stok_sekarang }}" data-stok_awal="{{ $asset->stok_awal }}">{{ $asset->kode_aset }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row g-2">
                    <div class="col">
                        <label class="font-weight-bold">Nama</label>
                        <input type="text" class="form-control" id="nama" disabled>
                    </div>
                    <div class="col">
                        <label class="font-weight-bold">Tipe</label>
                        <input type="text" class="form-control" id="tipe" disabled>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col">
                        <label class="font-weight-bold">Stok saat ini</label>
                        <input type="text" class="form-control" id="current" disabled>
                    </div>
                    <div class="col">
                        <label class="font-weight-bold">Stok awal</label>
                        <input type="text" class="form-control" id="first" disabled>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-1">
            <label class="font-weight-bold">Keterangan Transkasi</label>
            <textarea class="form-control" rows="3" name="keterangan" required></textarea>
        </div>

        <div class="modal-footer">
            <div class="text-end mt-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="submitCreateForm()" class="btn btn-md btn-primary">Create</button>
            </div>
        </div>
    </form>
</div>

<script>
    function submitCreateForm() {
        $.ajax({
            url: $('#createForm').attr('action'),
            type: 'POST',
            data: $('#createForm').serialize(),
            success: function(response) {
                $('#createModal').modal('hide');
                showToast(response.message, 'success');
                showLoader();
                reloadDatatable();
                hideLoader();
            },
                error: function(xhr, status, error) {
                console.log(xhr.responseJSON.message);

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: xhr.responseJSON.message
                });
            }
        });
    }

    document.getElementById('assetSelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var namaAset = selectedOption.getAttribute('data-nama');
        var tipeAset = selectedOption.getAttribute('data-tipe');
        var stokAset = selectedOption.getAttribute('data-stok');
        var stokAwalAset = selectedOption.getAttribute('data-stok_awal');

        document.getElementById('nama').value = namaAset;
        document.getElementById('tipe').value = tipeAset;
        document.getElementById('current').value = stokAset;
        document.getElementById('first').value = stokAwalAset;
    });
</script>

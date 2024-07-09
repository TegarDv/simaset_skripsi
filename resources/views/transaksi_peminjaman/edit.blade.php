<!-- Button trigger modal -->
<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Data Peminjaman</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="row g-3" action="{{ route('transaksi-pinjam.update', ['transaksi_pinjam' => $data->id]) }}" method="POST" id="updateForm">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-2">
                    <label class="font-weight-bold">Tanggal Peminjaman</label>
                    <input type="date" class="form-control" name="tanggal" value="{{ $data['tanggal_transaksi'] }}" required>
                </div>
                <div class="mb-2">
                    <label class="font-weight-bold">User yang meminjam</label>
                    <select class="form-select" name="user" required>
                        <option value="">Pilih User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $data['user_id'] == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="font-weight-bold">Jumlah Peminjaman</label>
                    <input type="number" class="form-control" name="jumlah" id="jumlah" value="{{ $data['stok'] }}" required>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-2">
                    <label class="font-weight-bold">Pilih Aset</label>
                    <select class="form-select" name="asset" id="assetSelectEdit" required>
                        <option value="">Select Asset</option>
                        @foreach ($assets as $asset)
                            <option value="{{ $asset->kode_aset }}" data-nama="{{ $asset->nama_aset }}" data-tipe="{{ $asset->tipe_aset }}" data-stok="{{ $asset->stok_sekarang }}" {{ $data['asset_id'] == $asset->id ? 'selected' : '' }}>{{ $asset->kode_aset }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row g-2">
                    <div class="col">
                        <label class="font-weight-bold">Nama</label>
                        <input type="text" class="form-control" id="namaEdit" value="{{ $asset_select['nama_aset'] }}" disabled>
                    </div>
                    <div class="col">
                        <label class="font-weight-bold">Tipe</label>
                        <input type="text" class="form-control" id="tipeEdit" value="{{ $asset_select['tipe_aset'] }}" disabled>
                    </div>
                </div>
                <div class="mb-1">
                    <label class="font-weight-bold">Stok saat ini</label>
                    <input type="text" class="form-control" id="currentEdit" value="{{ $asset_select['stok_sekarang'] }}" disabled>
                </div>
            </div>
        </div>
        <div class="mb-1">
            <label class="font-weight-bold">Keterangan Transkasi</label>
            <textarea class="form-control" rows="3" name="keterangan" required>{{ $data['keterangan'] }}</textarea>
        </div>

    </div>
    <div class="modal-footer">
        <div class="text-end mt-3">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" onclick="submitForm()" class="btn btn-md btn-primary">Save</button>
            {{-- <button class="btn btn-primary" type="button" onclick="submitForm()" name="tombol" value="submit">Simpan</button> --}}
            {{-- <button type="reset" class="btn btn-md btn-warning">RESET</button> --}}
        </div>
    </div>
</form>
<script>
    function submitForm() {
        $.ajax({
            url: $('#updateForm').attr('action'),
            type: 'POST',
            data: $('#updateForm').serialize(),
            success: function(response) {
                showLoader();
                $('#editModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    customClass: {
                        confirmButton: 'swalBtnConfirm swalButton',
                    }
                });
                reloadDatatable();
                hideLoader();
            },
            error: function(error) {
                // console.log(error.responseJSON.message);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.responseJSON.message,
                    customClass: {
                        confirmButton: 'swalBtnConfirm swalButton',
                    }
                });
            }
        });
    }

    document.getElementById('assetSelectEdit').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var namaAset = selectedOption.getAttribute('data-nama');
        var tipeAset = selectedOption.getAttribute('data-tipe');
        var stokAset = selectedOption.getAttribute('data-stok');

        document.getElementById('namaEdit').value = namaAset;
        document.getElementById('tipeEdit').value = tipeAset;
        document.getElementById('currentEdit').value = stokAset;
    });
</script>
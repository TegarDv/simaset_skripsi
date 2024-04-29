<!-- Button trigger modal -->
<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Aset {{ $data['kode_aset'] }}</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form class="row g-3" action="{{ route('pengadaan.update', ['pengadaan' => $data->id]) }}" method="POST" id="updateForm">
        @csrf
        @method('PUT')
        
        <div class="row g-3">
            <div class="col">
                <label class="font-weight-bold">Nama Aset</label>
                <input type="text" class="form-control" name="nama_aset" value="{{ $data['nama_aset'] }}" readonly>
            </div>
            <div class="col">
                <label class="font-weight-bold">Tipe Aset</label>
                <select class="form-select" name="tipe_aset" required>
                    <option value="fisik" {{ $data['tipe_aset'] == 'fisik' ? 'selected' : '' }}>fisik</option>
                    <option value="digital" {{ $data['tipe_aset'] == 'digital' ? 'selected' : '' }}>digital</option>
                    <option value="layanan" {{ $data['tipe_aset'] == 'layanan' ? 'selected' : '' }}>layanan</option>
                </select>
            </div>
            <div class="col">
                <label class="font-weight-bold">Jumlah Aset</label>
                <input type="number" class="form-control" name="jumlah" value="{{ $data['jumlah'] }}" required>
            </div>
        </div>
        <div class="row g-3">
            <div class="col">
                <label class="font-weight-bold">Harga Aset</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">Rp </span>
                    <input type="number" class="form-control" name="harga" value="{{ $data['harga'] }}" required>
                </div>
            </div>
            <div class="col">
                <label class="font-weight-bold">Status aset</label>
                <select class="form-select" name="status" required>
                    <option value="1" {{ $data['status'] == '1' ? 'selected' : '' }}>1</option>
                    <option value="2" {{ $data['status'] == '2' ? 'selected' : '' }}>2</option>
                    <option value="3" {{ $data['status'] == '3' ? 'selected' : '' }}>3</option>
                </select>
            </div>
            <div class="col">
                <label class="font-weight-bold">Kondisi Aset</label>
                <select class="form-select" name="kondisi_aset" required>
                    <option value="1" {{ $data['kondisi_aset'] == '1' ? 'selected' : '' }}>1</option>
                    <option value="2" {{ $data['kondisi_aset'] == '2' ? 'selected' : '' }}>2</option>
                    <option value="3" {{ $data['kondisi_aset'] == '3' ? 'selected' : '' }}>3</option>
                </select>
            </div>
            <div class="col">
                <label class="font-weight-bold">Masa Berlaku</label>
                <input type="date" class="form-control" name="masa_berlaku" value="{{ $data['masa_berlaku'] }}" required>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-lg-6">
                <label class="font-weight-bold">Spesifikasi</label>
                <textarea class="form-control @error('spesifikasi') is-invalid @enderror" rows="3" name="spesifikasi" required>{{ $data['spesifikasi'] }}</textarea>
            </div>
            <div class="col">
                <label class="font-weight-bold">Keterangan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror" rows="3" name="keterangan" required>{{ $data['keterangan'] }}</textarea>
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
</div>
<script>
    function submitForm() {
        console.log('Submitting form data:', $('#updateForm').serialize());
        // Submit the form using AJAX
        $.ajax({
            url: $('#updateForm').attr('action'),
            type: 'POST',
            data: $('#updateForm').serialize(),
            success: function(response) {
                // Close the modal upon success
                $('#editModal').modal('hide');
                // Show a success toast
                showToast(response.message, 'success');

                // Reload Animation
                showLoader();
                hideLoader();
            },
            error: function(error) {
                // Handle errors if needed
                console.log(error.responseJSON.message);
                // Show a failure toast
                showToast(error.responseJSON.message, 'danger');
            }
        });
    }
</script>
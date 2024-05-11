<!-- Button trigger modal -->
<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Aset {{ $data['kode_aset'] }}</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="row g-3" action="{{ route('pengadaan.update', ['pengadaan' => $data->id]) }}" method="POST" id="updateForm">
    @csrf
    @method('PUT')
    <div class="modal-body">
        
        <div class="row g-3">
            <div class="col-lg">
                <label class="font-weight-bold">Nama Aset</label>
                <input type="text" class="form-control" name="nama_aset" value="{{ $data['nama_aset'] }}" readonly>
            </div>
            <div class="col-lg">
                <label class="font-weight-bold">Tipe Aset</label>
                <select class="form-select" name="tipe_aset" required>
                    <option value="fisik" {{ $data['tipe_aset'] == 'fisik' ? 'selected' : '' }}>fisik</option>
                    <option value="digital" {{ $data['tipe_aset'] == 'digital' ? 'selected' : '' }}>digital</option>
                    <option value="layanan" {{ $data['tipe_aset'] == 'layanan' ? 'selected' : '' }}>layanan</option>
                </select>
            </div>
            <div class="col-lg">
                <label class="font-weight-bold">Jumlah Aset</label>
                <input type="number" class="form-control" name="jumlah" value="{{ $data['jumlah'] }}" required>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-lg">
                <label class="font-weight-bold">Harga Aset</label>
                <div class="input-group">
                    <span class="input-group-text">Rp </span>
                    <input type="number" class="form-control" name="harga" value="{{ $data['harga'] }}" required>
                </div>
            </div>
            <div class="col-lg">
                <label class="font-weight-bold">Status aset</label>
                <select class="form-select" name="status" required>
                    @foreach ($status as $item)
                        <option value="{{ $item->id }}" {{ $data['status'] == $item->id ? 'selected' : '' }}>{{ $item->nama_status }}</option>
                    @endforeach
                </select>
            </div>            
            <div class="col-lg">
                <label class="font-weight-bold">Kondisi Aset</label>
                <select class="form-select" name="kondisi_aset" required>
                    @foreach ($status as $item)
                        <option value="{{ $item->id }}" {{ $data['kondisi_aset'] == $item->id ? 'selected' : '' }}>{{ $item->nama_status }}</option>
                    @endforeach
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
                $('#editModal').modal('hide');
                showToast(response.message, 'success');

                showLoader();
                reloadDatatable();
                hideLoader();
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: xhr.responseJSON.message
                });
            }
        });
    }
</script>
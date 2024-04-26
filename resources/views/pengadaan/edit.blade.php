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
                <input type="text" class="form-control" name="tipe_aset" value="{{ $data['tipe_aset'] }}" readonly>
            </div>
            <div class="col">
                <label class="font-weight-bold">Jumlah Aset</label>
                <input type="text" class="form-control" name="jumlah" value="{{ $data['jumlah'] }}" readonly>
            </div>
        </div>
        <div class="row g-3">
            <div class="col">
                <label class="font-weight-bold">Harga Aset</label>
                <input type="text" class="form-control" name="harga" value="{{ $data['harga'] }}" readonly>
            </div>
            <div class="col">
                <label class="font-weight-bold">Status aset</label>
                <input type="text" class="form-control" name="status" value="{{ $data['status'] }}" readonly>
            </div>
            <div class="col">
                <label class="font-weight-bold">Kondisi Aset</label>
                <input type="text" class="form-control" name="kondisi_aset" value="{{ $data['kondisi_aset'] }}" readonly>
            </div>
            <div class="col">
                <label class="font-weight-bold">Masa Berlaku</label>
                <input type="text" class="form-control" name="masa_berlaku" value="{{ $data['masa_berlaku'] }}" readonly>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-lg-6">
                <label class="font-weight-bold">Spesifikasi</label>
                <textarea id="info" class="form-control @error('info') is-invalid @enderror" rows="3" name="spesifikasi" placeholder="info">{{ $data['spesifikasi'] }}</textarea>
            </div>
            <div class="col">
                <label class="font-weight-bold">Keterangan</label>
                <textarea id="info" class="form-control @error('info') is-invalid @enderror" rows="3" name="keterangan" placeholder="info">{{ $data['keterangan'] }}</textarea>
            </div>
        </div>
    </form> 
</div>
<div class="modal-footer">
    <div class="text-end mt-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="submitForm()" class="btn btn-md btn-primary">Save</button>
        {{-- <button class="btn btn-primary" type="button" onclick="submitForm()" name="tombol" value="submit">Simpan</button> --}}
        {{-- <button type="reset" class="btn btn-md btn-warning">RESET</button> --}}
    </div>
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
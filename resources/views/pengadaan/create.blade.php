<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Create New Aset</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form class="row g-3" action="{{ route('pengadaan.store') }}" method="POST" id="createForm">
        @csrf
        
        <div class="row g-3">
            <div class="col">
                <label class="font-weight-bold">Nama Aset</label>
                <input type="text" class="form-control" name="nama_aset" required>
            </div>
            <div class="col">
                <label class="font-weight-bold">Tipe Aset</label>
                <select class="form-select" name="tipe_aset" required>
                    <option value="">Select Tipe Aset</option>
                    <option value="fisik">fisik</option>
                    <option value="digital">digital</option>
                    <option value="layanan">layanan</option>
                </select>
            </div>
            <div class="col">
                <label class="font-weight-bold">Jumlah Aset</label>
                <input type="number" class="form-control" name="jumlah" required>
            </div>
        </div>
        <div class="row g-3">
            <div class="col">
                <label class="font-weight-bold">Harga Aset</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">Rp </span>
                    <input type="number" class="form-control" name="harga" required>
                </div>
            </div>
            <div class="col">
                <label class="font-weight-bold">Status aset</label>
                <select class="form-select" name="status" required>
                    <option value="">Select Status Aset</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
            <div class="col">
                <label class="font-weight-bold">Kondisi Aset</label>
                <select class="form-select" name="kondisi_aset" required>
                    <option value="">Select Kondisi Aset</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
            <div class="col">
                <label class="font-weight-bold">Masa Berlaku</label>
                <input type="date" class="form-control" name="masa_berlaku" required>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-lg-6">
                <label class="font-weight-bold">Spesifikasi</label>
                <textarea class="form-control @error('spesifikasi') is-invalid @enderror" rows="3" name="spesifikasi" required></textarea>
            </div>
            <div class="col">
                <label class="font-weight-bold">Keterangan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror" rows="3" name="keterangan" required></textarea>
            </div>
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
        console.log('Submitting form data:', $('#createForm').serialize());
        // Submit the form using AJAX
        $.ajax({
            url: $('#createForm').attr('action'),
            type: 'POST',
            data: $('#createForm').serialize(),
            success: function(response) {
                // Close the modal upon success
                $('#createModal').modal('hide');
                // Show a success toast
                showToast(response.message, 'success');
                // Reload Animation
                showLoader();
                reloadDatatable();
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
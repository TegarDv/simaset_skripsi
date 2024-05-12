<!-- Button trigger modal -->
<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Status {{ $data['nama_status'] }}</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="row g-3" action="{{ route('status.update', ['status' => $data->id]) }}" method="POST" id="updateForm">
    @csrf
    @method('PUT')
    <div class="modal-body">
        
        <div class="mb-3">
            <label class="font-weight-bold">Nama Status</label>
            <input type="text" class="form-control" name="nama_status" value="{{ $data['nama_status'] }}" required>
        </div>
        <div class="mb-3">
            <label class="font-weight-bold">Warna Status</label>
            <select class="form-select mb-2" name="color" required>
                <option value="" disabled>Select Tipe Aset</option>
                <option value="primary" {{ $data['color'] == 'primary' ? 'selected' : '' }}>primary</option>
                <option value="secondary" {{ $data['color'] == 'secondary' ? 'selected' : '' }}>secondary</option>
                <option value="success" {{ $data['color'] == 'success' ? 'selected' : '' }}>success</option>
                <option value="danger" {{ $data['color'] == 'danger' ? 'selected' : '' }}>danger</option>
                <option value="warning" {{ $data['color'] == 'warning' ? 'selected' : '' }}>warning</option>
                <option value="info" {{ $data['color'] == 'info' ? 'selected' : '' }}>info</option>
                <option value="light" {{ $data['color'] == 'light' ? 'selected' : '' }}>light</option>
                <option value="dark" {{ $data['color'] == 'dark' ? 'selected' : '' }}>dark</option>
            </select>
            
            <span class="badge text-bg-primary border">Primary</span>
            <span class="badge text-bg-secondary border">Secondary</span>
            <span class="badge text-bg-success border">Success</span>
            <span class="badge text-bg-danger border">Danger</span>
            <span class="badge text-bg-warning border">Warning</span>
            <span class="badge text-bg-info border">Info</span>
            <span class="badge text-bg-light border">Light</span>
            <span class="badge text-bg-dark border">Dark</span>
        </div>
        <div class="mb-3">
            <label class="font-weight-bold">Status</label>
            <select class="form-select mb-2" name="status" required>
                <option value="" disabled>Select Tipe Aset</option>
                <option value="1" {{ $data['status'] == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $data['status'] == '0' ? 'selected' : '' }}>Off</option>
            </select>
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
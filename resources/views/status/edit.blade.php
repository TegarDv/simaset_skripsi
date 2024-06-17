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
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="color" id="colorPrimary" value="primary" {{ $data['color'] == 'primary' ? 'checked' : '' }} required>
                    <label class="form-check-label badge text-bg-primary border" for="colorPrimary">Primary</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="color" id="colorSecondary" value="secondary" {{ $data['color'] == 'secondary' ? 'checked' : '' }} required>
                    <label class="form-check-label badge text-bg-secondary border" for="colorSecondary">Secondary</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="color" id="colorSuccess" value="success" {{ $data['color'] == 'success' ? 'checked' : '' }} required>
                    <label class="form-check-label badge text-bg-success border" for="colorSuccess">Success</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="color" id="colorDanger" value="danger" {{ $data['color'] == 'danger' ? 'checked' : '' }} required>
                    <label class="form-check-label badge text-bg-danger border" for="colorDanger">Danger</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="color" id="colorWarning" value="warning" {{ $data['color'] == 'warning' ? 'checked' : '' }} required>
                    <label class="form-check-label badge text-bg-warning border" for="colorWarning">Warning</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="color" id="colorInfo" value="info" {{ $data['color'] == 'info' ? 'checked' : '' }} required>
                    <label class="form-check-label badge text-bg-info border" for="colorInfo">Info</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="color" id="colorLight" value="light" {{ $data['color'] == 'light' ? 'checked' : '' }} required>
                    <label class="form-check-label badge text-bg-light border" for="colorLight">Light</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="color" id="colorDark" value="dark" {{ $data['color'] == 'dark' ? 'checked' : '' }} required>
                    <label class="form-check-label badge text-bg-dark border" for="colorDark">Dark</label>
                </div>
            </div>
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
<!-- Button trigger modal -->
<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit User</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="row g-3" action="{{ route('users.update', ['user' => $data->id]) }}" method="POST" id="updateForm">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="row g-2">
            <div class="col">
                <label class="font-weight-bold">Nama Lengkap</label>
                <input type="text" class="form-control" name="name" value="{{ $data['name'] }}" required>
            </div>
            <div class="col">
                <label class="font-weight-bold">Username</label>
                <input type="text" class="form-control" name="username" value="{{ $data['username'] }}" required>
            </div>
            <div class="col">
                <label class="font-weight-bold">Email</label>
                <input type="email" class="form-control" name="email" value="{{ $data['email'] }}" required>
            </div>
        </div>

        <div class="row g-2">
            <div class="col">
                <label class="font-weight-bold">Role</label>
                <select class="form-select" name="role" required>
                    <option value="">Select Role User</option>
                    <option value="1" {{ $data['role'] == '1' ? 'selected' : '' }}>Super Admin</option>
                    <option value="2" {{ $data['role'] == '2' ? 'selected' : '' }}>Admin</option>
                    <option value="3" {{ $data['role'] == '3' ? 'selected' : '' }}>Dosen / Mahasiswa</option>
                </select>
            </div>
            <div class="col">
                <label class="font-weight-bold">New Password</label>
                <input type="password" class="form-control" name="new_password">
                <input type="hidden" class="form-control" name="password" value="password">
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
</script>
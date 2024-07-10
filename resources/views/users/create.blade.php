<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Create New User</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form class="row g-3" action="{{ route('users.store') }}" method="POST" id="createForm">
        @csrf
        
        <div class="row g-2">
            <div class="col">
                <label class="font-weight-bold">Nama Lengkap</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="col">
                <label class="font-weight-bold">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="col">
                <label class="font-weight-bold">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
        </div>

        <div class="row g-2">
            <div class="col">
                <label class="font-weight-bold">Role</label>
                <select class="form-select" name="role" required>
                    <option value="">Select Role User</option>
                    <option value="1">Super Admin</option>
                    <option value="2">Admin</option>
                    <option value="3">Dosen / Mahasiswa</option>
                </select>
            </div>
            <div class="col">
                <label class="font-weight-bold">Password</label>
                <input type="password" class="form-control" name="password" required>
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
        $.ajax({
            url: $('#createForm').attr('action'),
            type: 'POST',
            data: $('#createForm').serialize(),
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    customClass: {
                        confirmButton: 'swalBtnConfirm swalButton',
                    }
                });
                $('#createModal').modal('hide');
                reloadDatatable();
                hideLoader();
            },
                error: function(xhr, status, error) {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: xhr.responseJSON.message,
                    customClass: {
                        confirmButton: 'swalBtnConfirm swalButton',
                    }
                });
            }
        });
    }
</script>

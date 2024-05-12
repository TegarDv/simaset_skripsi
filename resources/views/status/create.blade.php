<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Buat Status Baru</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form class="row g-3" action="{{ route('status.store') }}" method="POST" id="createForm">
        @csrf
        
        <div class="mb-3">
            <label class="font-weight-bold">Nama Status</label>
            <input type="text" class="form-control" name="nama_status" required>
        </div>
        <div class="mb-3">
            <label class="font-weight-bold">Warna Status</label>
            <select class="form-select mb-2" name="color" required>
                <option value="" disabled>Select Tipe Aset</option>
                <option value="primary">primary</option>
                <option value="secondary">secondary</option>
                <option value="success">success</option>
                <option value="warning">warning</option>
                <option value="info">info</option>
                <option value="light">light</option>
                <option value="dark">dark</option>
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
</script>

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
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="color" id="colorPrimary" value="primary" required>
                    <label class="form-check-label badge text-bg-primary border" for="colorPrimary">Primary</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="color" id="colorSecondary" value="secondary" required>
                    <label class="form-check-label badge text-bg-secondary border" for="colorSecondary">Secondary</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="color" id="colorSuccess" value="success" required>
                    <label class="form-check-label badge text-bg-success border" for="colorSuccess">Success</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="color" id="colorDanger" value="danger" required>
                    <label class="form-check-label badge text-bg-danger border" for="colorDanger">Danger</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="color" id="colorWarning" value="warning" required>
                    <label class="form-check-label badge text-bg-warning border" for="colorWarning">Warning</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="color" id="colorInfo" value="info" required>
                    <label class="form-check-label badge text-bg-info border" for="colorInfo">Info</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="color" id="colorLight" value="light" required>
                    <label class="form-check-label badge text-bg-light border" for="colorLight">Light</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="color" id="colorDark" value="dark" required>
                    <label class="form-check-label badge text-bg-dark border" for="colorDark">Dark</label>
                </div>
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
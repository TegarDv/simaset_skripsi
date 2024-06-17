<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Create New Aset</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form class="row g-3" action="{{ route('location.store') }}" method="POST" id="createForm">
        @csrf
        
        <div class="mb-3">
            <label class="font-weight-bold">Nama Lokasi</label>
            <input type="text" class="form-control" name="location" required>
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

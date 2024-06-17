<!-- Button trigger modal -->
<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Lokasi</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="row g-3" action="{{ route('location.update', ['location' => $data->id]) }}" method="POST" id="updateForm">
    @csrf
    @method('PUT')
    <div class="modal-body">
        
        <div class="mb-3">
            <label class="font-weight-bold">Nama Lokasi</label>
            <input type="text" class="form-control" name="location" value="{{ $data['location'] }}" required>
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
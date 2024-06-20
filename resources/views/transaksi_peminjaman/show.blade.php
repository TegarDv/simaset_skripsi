<!-- Button trigger modal -->
<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Transaksi</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form class="row g-3" action="{{ route('pengadaan.update', ['pengadaan' => $data->id]) }}" method="POST" id="updateForm">
        @csrf
        @method('PUT')

        <div class="form-group col-md-12">
            <label class="font-weight-bold">No Transaksi / Order id <small class="text-warning">No transaksi tidak dapat diedit</small></label>
            <input type="text" class="form-control @error('id') is-invalid @enderror" name="id" value="{{ $data['id'] }}" readonly>
        
            <!-- error message untuk id -->
            @error('id')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror
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
<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Permintaan Peminjaman Aset</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row g-2">
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Nama Peminjam</label>
            <p>{{ $data->dataUser->name ?? '' }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Role</label>
            <p>{{ $data->dataUser->dataRole->name ?? '' }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">NIM</label>
            <p>{{ $data->dataUser->nim ?? '' }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">NIP</label>
            <p>{{ $data->dataUser->nip ?? '' }}</p>
        </div>
    </div>
    <hr class="mt-2 mb-2">
    <div class="row g-2">
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Kode Aset</label>
            <p>{{ $data->dataAsset->kode_aset ?? '' }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Nama Aset</label>
            <p>{{ $data->dataAsset->nama_aset ?? '' }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Tipe Aset</label>
            <p>{{ ucfirst($data->dataAsset->tipe_aset ?? '') }}</p>
        </div>
    </div>
    <hr class="mt-2 mb-2">
    <div class="row g-2">
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Jumlah Peminjaman</label>
            <p>{{ $data->jumlah ?? '' }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Tanggal Peminjaman</label>
            <p>{{ $data->tanggal_permintaan ?? '' }}</p>
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Keterangan Peminjaman</label>
            <p>{{ $data->keterangan ?? '' }}</p>
        </div>
    </div>
    <hr class="mt-2 mb-2">
    <div class="row g-2">
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Status Permintaan</label>
            @if ($data->status_permintaan == 'pending')
                <h5><span class="badge bg-warning bg-glow">Pending</span></h5>
            @elseif ($data->status_permintaan == 'disetujui')
                <h5><span class="badge bg-success bg-glow">Disetujui</span></h5>
            @elseif ($data->status_permintaan == 'ditolak')
                <h5><span class="badge bg-danger bg-glow">Ditolak</span></h5>
            @endif
        </div>
        <div class="col-lg">
            <label class="font-weight-bold text-primary">Catatan Permintaan</label>
            <p>{!! nl2br(e($data->catatan_permintaan ?? '')) !!}</p>
        </div>
    </div>
</div>
<div class="modal-footer d-flex justify-content-between">
    <div class="text-start mt-3">
        @canany(['isSuperAdmin', 'isAdmin'])
            @if ($data->status_permintaan == 'pending')
                <button type="button" class="btn btn-label-success me-2" id="terimaBtn">Setujui Permintaan</button>
                <button type="button" class="btn btn-label-danger" id="tolakBtn">Tolak Permintaan</button>
            @else
                <button type="button" class="btn btn-label-warning" disabled>Permintaan {{ $data->status_permintaan }}</button>
            @endif
        @endcanany
    </div>
    <div class="text-end mt-3">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</div>
<script>
    $('#terimaBtn').on('click', function () {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var appId = '{{ $data->id }}';

        Swal.fire({
            title: 'Terima Permintaan Peminjaman?',
            input: "textarea",
            inputAttributes: {
                required: 'required'
            },
            text: "Berikan keterangan untuk persetujuan peminjaman aset!",
            icon: 'warning',
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Terima peminjaman!',
            preConfirm: (inputValue) => {
                if (!inputValue) {
                    Swal.showValidationMessage('Keterangan harus di isi!');
                }
                return inputValue;
            },
            customClass: {
                confirmButton: 'swalBtnConfirm swalButton',
                cancelButton: 'swalBtnCancel swalButton',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'transaksi-permintaan/' + appId + '/accept',
                    type: 'POST',
                    data: {
                        keterangan: result.value
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        showLoader();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            customClass: {
                                confirmButton: 'swalBtnConfirm swalButton',
                            }
                        });
                        $('#detailModal').modal('hide');
                        reloadDatatable();
                        hideLoader();
                    },
                    error: function(error) {
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
        });
    });

    $('#tolakBtn').on('click', function () {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var appId = '{{ $data->id }}';

        Swal.fire({
            title: 'Tolak Permintaan Peminjaman?',
            input: "textarea",
            inputAttributes: {
                required: 'required'
            },
            text: "Berikan keterangan untuk penolakan peminjaman aset!",
            icon: 'warning',
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Tolak peminjaman!',
            preConfirm: (inputValue) => {
                if (!inputValue) {
                    Swal.showValidationMessage('Keterangan harus di isi!');
                }
                return inputValue;
            },
            customClass: {
                confirmButton: 'swalBtnConfirm swalButton',
                cancelButton: 'swalBtnCancel swalButton',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'transaksi-permintaan/' + appId + '/reject',
                    type: 'POST',
                    data: {
                        keterangan: result.value
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        showLoader();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            customClass: {
                                confirmButton: 'swalBtnConfirm swalButton',
                            }
                        });
                        $('#detailModal').modal('hide');
                        reloadDatatable();
                        hideLoader();
                    },
                    error: function(error) {
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
        });
    });
</script>
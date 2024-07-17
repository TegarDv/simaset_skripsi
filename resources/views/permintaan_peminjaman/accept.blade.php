<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Aset Dari Permintaan</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form class="row g-3" action="{{ route('asset-permintaan-accept.input', ['id' => $data->id]) }}" method="POST" id="createForm">
        @csrf
        
        <div class="row g-2">
            <div class="col">
                <label class="font-weight-bold">Nama Aset</label>
                <input type="text" class="form-control" name="nama_aset" value="{{ $data['nama_aset'] }}" disabled>
            </div>
            <div class="col">
                <label class="font-weight-bold">Nama Aset</label>
                <input type="text" class="form-control" name="tipe_aset" value="{{ $data['tipe_aset'] }}" disabled>
            </div>
        </div>
        <div class="row g-2">
            <div class="col">
                <label class="font-weight-bold">Stok Aset</label>
                <input type="number" class="form-control" name="stok_awal" value="{{ $data['stok_permintaan'] }}" disabled>
            </div>
            <div class="col">
                <label class="font-weight-bold">Harga Aset</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">Rp </span>
                    <input type="number" class="form-control" name="harga" value="{{ $data['harga'] }}" disabled>
                </div>
            </div>
            <div class="col">
                <label class="font-weight-bold">Masa Berlaku</label>
                <input type="date" class="form-control" name="masa_berlaku" value="{{ $data['masa_berlaku'] }}" disabled>
            </div>
            <div class="col">
                <label class="font-weight-bold">Tanggal Penerimaan</label>
                <input type="date" class="form-control" name="tanggal_penerimaan" required>
            </div>
        </div>
        <div class="row g-2">
            <div class="col">
                <label class="font-weight-bold">Status aset</label>
                <select class="form-select" name="status_aset" required>
                    <option disabled selected>Pilih Status Aset</option>
                    @foreach ($status as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label class="font-weight-bold">Kondisi Aset</label>
                <select class="form-select" name="kondisi_aset" required>
                    <option disabled selected>Pilih Kondisi Aset</option>
                    @foreach ($status as $item)
                        <option value="{{ $item->id }}"><span class="badge rounded-pill bg-{{ $item->color }}">{{ $item->nama_status }}</span></option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label class="font-weight-bold">Lokasi Aset</label>
                <select class="form-select" name="lokasi_aset" required>
                    <option disabled selected>Pilih Lokasi Aset</option>
                    @foreach ($lokasi as $item)
                        <option value="{{ $item->id }}">{{ $item->location }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label class="font-weight-bold">Pemilik Aset</label>
                <select class="form-select" name="pemilik_aset" required>
                    @foreach ($user as $item)
                        @if ($data['pemilik_aset'] == $item->id)
                            <option value="{{ $item->id }}" {{ $data['pemilik_aset'] == $item->id ? 'selected' : '' }} disabled>{{ $item->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row g-2">
            <div class="col-lg-6">
                <label class="font-weight-bold">Spesifikasi</label>
                <textarea class="form-control" rows="3" name="spesifikasi" disabled>{{ $data['spesifikasi'] }}</textarea>
            </div>
            <div class="col">
                <label class="font-weight-bold">Keterangan</label>
                <textarea class="form-control" rows="3" name="keterangan" disabled>{{ $data['keterangan'] }}</textarea>
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
                $('#acceptModal').modal('hide');
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

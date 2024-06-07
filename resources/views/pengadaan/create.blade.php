<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Create New Aset</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form class="row g-3" action="{{ route('pengadaan.store') }}" method="POST" id="createForm">
        @csrf
        
        <div class="row g-2">
            <div class="col">
                <label class="font-weight-bold">Nama Aset</label>
                <input type="text" class="form-control" name="nama_aset" required>
            </div>
            <div class="col">
                <label class="font-weight-bold">Tipe Aset</label>
                <select class="form-select" name="tipe_aset" required>
                    <option value="">Select Tipe Aset</option>
                    <option value="fisik">Fisik</option>
                    <option value="digital">Digital</option>
                    <option value="layanan">Layanan</option>
                </select>
            </div>
            <div class="col">
                <label class="font-weight-bold">Jumlah Aset</label>
                <input type="number" class="form-control" name="jumlah" required>
            </div>
        </div>
        <div class="row g-2">
            <div class="col">
                <label class="font-weight-bold">Stock Aset</label>
                <input type="number" class="form-control" name="stok_awal" required>
            </div>
            <div class="col">
                <label class="font-weight-bold">Harga Aset</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">Rp </span>
                    <input type="number" class="form-control" name="harga" required>
                </div>
            </div>
            <div class="col">
                <label class="font-weight-bold">Masa Berlaku</label>
                <input type="date" class="form-control" name="masa_berlaku" required>
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
                    <option disabled selected>Pilih Pemilik Aset</option>
                    @foreach ($user as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row g-2">
            <div class="col-lg-6">
                <label class="font-weight-bold">Spesifikasi</label>
                <textarea class="form-control @error('spesifikasi') is-invalid @enderror" rows="3" name="spesifikasi" required></textarea>
            </div>
            <div class="col">
                <label class="font-weight-bold">Keterangan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror" rows="3" name="keterangan" required></textarea>
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

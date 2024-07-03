<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Print Data Aktivitas User</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form class="row g-3" action="{{ route('activity_print') }}" method="POST" id="createForm">
        @csrf

        <div class="row">
            <div class="col">
                <label class="font-weight-bold">Tanggal Awal</label>
                <input type="date" class="form-control" name="tanggal_awal">
            </div>
            <div class="col">
                <label class="font-weight-bold">Tanggal Akhir</label>
                <input type="date" class="form-control" name="tanggal_akhir">
            </div>
        </div>

        <div class="modal-footer">
            <div class="text-end mt-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-md btn-primary">Create</button>
            </div>
        </div>
    </form>
</div>

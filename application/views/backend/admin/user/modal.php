<div class="modal fade" id="modal-hapus" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="exampleModalLabel">Hapus Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" id="form-hapus">
                <div class="modal-body">
                    <div class="form-group" hidden>
                        <label class="col-12control-label col-form-label">ID</label>
                        <div class="col-12">
                            <input class="form-control" type="text" name="id_user" id="hapus-id">
                        </div>
                    </div>
                    <div class="text-center">
                        <p>Apakah anda yakin ingin menghapus ?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    {{form_submit('button', 'Batal', 'class="btn btn-outline-danger", data-dismiss="modal"')}}
                    {{form_submit('submit', 'Hapus', 'class="btn btn-danger"')}}
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="modal-window modal fade" id="tandc" tabindex="-1" aria-labelledby="tandcModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Termeni și condiții</h5>

                        <div class="modal-close-text-container">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #a00404">X</button>
                        </div>
                    </div>

                    <div class="modal-body" id="terms_site_body">
                        <div class="loading_indicator" style="display: none;">Loading...</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let tandc = $('#tandc');
    let parent_modal_id;
    tandc.on('shown.bs.modal', function (e) {
        get_terms_site();
        var button = $(e.relatedTarget);
        parent_modal_id = button.closest('.modal').attr('id');
    });

    tandc.on('hidden.bs.modal', function () {
        $('#' + parent_modal_id).modal('show');
    });


</script>

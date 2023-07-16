<div class="row">
    <div class="col-12">
        <div class="modal fade" id="pandc" tabindex="-1" aria-labelledby="pandcModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Politica de confidențialitate</h5>

                        <div class="modal-close-text-container">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    style="color: #a00404">X
                            </button>
                        </div>
                    </div>

                    <div class="modal-body" id="privacy-policy-modal-body">
                        <div class="loading_indicator" style="display: none;">Loading...</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let pandc = $('#pandc');
    let old_modal_id;
    pandc.on('shown.bs.modal', function (e) {
        get_privacy_policy();
        var button = $(e.relatedTarget);
        old_modal_id = button.closest('.modal').attr('id');
    });

    pandc.on('hidden.bs.modal', function () {
        $('#' + old_modal_id).modal('show');
    });

</script>

<!-- Contract -->
<div class="row">
    <div class="col-12">
        <div class="modal fade" id="contract-modal" tabindex="-1" aria-labelledby="tandcModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Contract</h5>

                        <div class="modal-close-text-container">
                            <button type="button" class="close-modal-button text fs-5" style="color: #a00404"
                                    data-bs-dismiss="modal" aria-label="Close" id="close-modal-11"> X
                            </button>
                        </div>
                    </div>

                    <div class="modal-body" id="contract_modal_body">
                        <div id="loading_indicator" style="display: none;">Loading...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let contract_modal = $('#contract-modal');
    let closed_modal_id;
    contract_modal.on('shown.bs.modal', function (e) {
        get_contract();
        var button = $(e.relatedTarget);
        closed_modal_id = button.closest('.modal').attr('id');
    });

    contract_modal.on('hidden.bs.modal', function () {
        $('#' + closed_modal_id).modal('show');
    });


</script>

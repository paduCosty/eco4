<div class="row">
    <div class="col-12">
        <div class="modal-window modal fade" id="aboutUsModal" tabindex="-1" aria-labelledby="aboutUsModalLabel"
             aria-hidden="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content" id="about-us">
                    <div class="modal-header close-modal">
                        <h5 class="modal-title">Despre noi</h5>

                        <div class="col-12 col-sm-6 modal-close-text-container">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #a00404">X</button>
                        </div>
                    </div>

                    <div class="modal-body" id="about_us_modal_body">
                            <div id="loading_indicator" style="display: none;">Loading...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $('#aboutUsModal').on('shown.bs.modal', function () {
        get_app_details_from_crm();
    });


</script>

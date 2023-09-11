<div class="modal fade" id="add-details-to-event-modal" tabindex="-1" aria-labelledby="add-details-to-event-label"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-product-modal-label">Adauga detalii eveniment ecologizare</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="color: #a00404">X
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="event-details-form" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="row">
                        <div class="col-sm">
                            <div class="mb-3">
                                <label for="quantity" class="col-form-label form-modal-label">Cantitatea de deșeuri
                                    (kg):</label>
                                <input type="number" class="form-control-plaintext input-normal form-control-sm"
                                       name="waste" id="quantity"
                                       required>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="mb-3">
                                <label for="sack-number" class="col-form-label form-modal-label">Numărul de saci de
                                    deșeuri:</label>
                                <input type="number" class="form-control-plaintext input-normal form-control-sm"
                                       id="sack-number" name="bags"
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="custom-file mb-3">
                                <input type="file" class="custom-file-input" name="event_images[]" id="photos" multiple>
                                <label class="custom-file-label" for="photos"></label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="images_for_delete" id="images-for-delete">

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="event-photos">
                        <h2>Poze eveniment inainte de ecologizare</h2>
                        <div class="row mt-3" id="uploaded_images"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="form-submit" id="add-details-to-event">Salvează</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to fill the modal form with event details

    function fillEventDetailsModal(location_id) {
        // Make an AJAX request to get the event details
        $.ajax({
            url: 'events/' + location_id,
            type: 'GET',
            success: function (response) {
                response = response.data;

                $('#quantity').val(response.waste);
                $('#sack-number').val(response.bags);
                // Add the images to the image container
                image_box(response, 'uploaded_images', true);
                // Open the modal
                $('#add-details-to-event-modal').modal('show');
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }

    $(document).on('change', '#photos', function (e) {
        preview_selected_files(e, null, 'uploaded_images', false);
    });
    // Event triggered when the modal is opened
    $('#add-details-to-event-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var event_id = button.data('event_id');

        var form = $('#event-details-form');
        form.attr('action', '/events/update-unfolded-event/' + event_id);
        // Call the function to fill the modal form with event details
        var inputElement = $('#photos')[0];
        if (inputElement.files.length === 0) {
            fillEventDetailsModal(event_id);
        }

    });

    $('#add-details-to-event').click(function () {
        var form = $('#event-details-form');
        form.submit();
    });





    // $(document).on('click', '.delete-image', function () {
    //    $(this).closest('.images-box').remove();
    // });

</script>


<style>
    .custom-file-input {
        opacity: 0;
        position: absolute;
        z-index: -1;
    }

    .custom-file-label {
        cursor: pointer;
        background-color: #f5f5f5;
        border: 1px solid #ced4da;
        padding: 8px 12px;
        border-radius: 4px;
        display: inline-block;
        transition: background-color 0.3s ease;
    }

    .custom-file-label:hover {
        background-color: #e9ecef;
    }

    .custom-file-input:focus ~ .custom-file-label {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .custom-file-input:focus ~ .custom-file-label::before {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .custom-file-input:lang(en) ~ .custom-file-label::after {
        content: 'Browse files';
    }

    .uploaded-image {
        width: 100pc;
        height: 100%;
        object-fit: cover;
    }

    .square-container {
        width: 100px;
        height: 100px;
    }
</style>


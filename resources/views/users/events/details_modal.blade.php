<div class="modal fade" id="details-event-modal" tabindex="-1" aria-labelledby="details-event-modal-label"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-product-modal-label">Detalii eveniment ecologizare</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="color: #a00404">X
                </button>
            </div>

            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="institution-details">
                                <h2>Detalii instituție</h2>
                                <p><strong>Nume instituție:</strong> <span id="institution-name"></span></p>
                                <p><strong>Email instituție:</strong> <span id="institution-email"></span></p>
                                <p><strong>Telefon instituție:</strong> <span id="institution-phone"></span></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="coordinator-details">
                                <h2>Detalii coordonator</h2>
                                <p><strong>Nume coordonator:</strong> <span id="coordinator-name"></span></p>
                                <p><strong>Email coordonator:</strong> <span id="coordinator-email"></span></p>
                                <p><strong>Telefon coordonator:</strong> <span id="coordinator-phone"></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="event-details">
                        <h2>Detalii eveniment</h2>
                        <p><strong>Adresă:</strong> <span id="event-address"></span></p>
                        <p><strong>Status:</strong> <span id="event-status"></span></p>
                        <p><strong>Data acțiune:</strong> <span id="event-due-date"></span></p>
                        <p><strong>Tip teren:</strong> <span id="event-relief-type"></span></p>
                        <p><strong>Număr nevoi de voluntari:</strong> <span id="event-volunteer-size"></span></p>
                        <p><strong>Descriere:</strong> <span id="event-description"></span></p>

                        <p><strong>Deseuri:</strong> <span id="event-waste"></span></p>
                        <p><strong>Saci:</strong> <span id="event-bags"></span></p>
                    </div>

                    <div class="event-photos">
                        <h2>Poze eveniment inainte de ecologizare</h2>
                        <div class="row mt-3" id="before_images"></div>
                    </div>

                    <div class="event-photos">
                        <h2>Poze eveniment dupa ecologizare</h2>
                        <div class="row mt-3" id="after_images"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function event_details(location_id) {
        $.ajax({
            url: 'events/' + location_id,
            type: 'GET',
            success: function (response) {
                response = response.data;
                /*institution data*/
                $('#institution-name').text(response.institution_name);
                $('#institution-email').text(response.institution_email);
                $('#institution-phone').text(response.institution_phone)

                /*coordinator data*/
                $('#coordinator-name').text(response.coordinator_name);
                $('#coordinator-email').text(response.coordinator_email);
                $('#coordinator-phone').text(response.coordinator_phone)
                /*event data*/
                $('#event-description').html(response.description);
                $('#event-address').text(response.address);
                $('#event-status').text(response.status);
                $('#event-due-date').text(response.due_date);
                $('#event-waste-type').text(response.relief_type);
                $('#event-volunteer-size').text(response.size_volunteer_id);

                $('#event-waste').text(response.waste);
                $('#event-bags').text(response.bags);

                // Clears the content of the picture div
                $('#uploaded-images-container').empty();
                $('#before_images').empty();

                image_box(response, 'before_images');
                let images = response.uploaded_images
                response.after_images = images;
                image_box(response, 'after_images');

            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
</script>

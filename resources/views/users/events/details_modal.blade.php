<div class="modal fade" id="details-event-modal" tabindex="-1" aria-labelledby="details-event-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-product-modal-label">Detalii eveniment ecologizare</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #a00404">X</button>
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
                        <h2>Poze eveniment</h2>
                        <div id="event-photos-carousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div id="uploaded-images-container"></div>

                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#event-photos-carousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#event-photos-carousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
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
                $('#event-description').text(response.description);
                $('#event-address').text(response.address);
                $('#event-status').text(response.status);
                $('#event-due-date').text(response.due_date);
                $('#event-waste-type').text(response.relief_type);
                $('#event-volunteer-size').text(response.size_volunteer_id);

                $('#event-waste').text(response.waste);
                $('#event-bags').text(response.bags);

                // Curăță conținutul div-ului cu poze
                $('#uploaded-images-container').empty();

                $.each(response.images, function(index, image) {
                    var imageElement = $('<img>').attr('src', window.location.origin + '/' + image.path);
                    $('#uploaded-images-container').append(imageElement);
                });

            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
</script>

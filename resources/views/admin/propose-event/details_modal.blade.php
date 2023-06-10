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
                    <div class="institution-details">
                        <h2>Detalii instituție</h2>
                        <p><strong>Nume instituție:</strong> <span id="institution-name"></span></p>
                        <p><strong>Email instituție:</strong> <span id="institution-email"></span></p>
                        <p><strong>Telefon instituție:</strong> <span id="institution-phone"></span></p>
                    </div>
                    <div class="event-details">
                        <h2>Detalii eveniment</h2>
                        <p><strong>Nume:</strong> <span id="event-name"></span></p>
                        <p><strong>Email:</strong> <span id="event-email"></span></p>
                        <p><strong>Adresă:</strong> <span id="event-address"></span></p>
                        <p><strong>Status:</strong> <span id="event-status"></span></p>
                        <p><strong>Data limită:</strong> <span id="event-due-date"></span></p>
                        <p><strong>Tip teren:</strong> <span id="event-relief-type"></span></p>
                        <p><strong>Număr nevoi de voluntari:</strong> <span id="event-volunteer-size"></span></p>
                        <p><strong>Descriere:</strong> <span id="event-description"></span></p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function event_details(location_id) {
        $.ajax({
            url: 'propose-locations/' + location_id,
            type: 'GET',
            success: function (response) {
                response = response.data;
                $('#event-name').text(response.name);
                $('#event-email').text(response.email);
                $('#event-description').text(response.description);
                $('#event-address').text(response.address);
                $('#event-status').text(response.status);
                $('#event-due-date').text(response.due_date);
                $('#event-relief-type').text(response.relief_type);
                $('#event-volunteer-size').text(response.size_volunteer_id);
                $('#institution-name').text(response.institution_name);
                $('#institution-email').text(response.institution_email);
                $('#institution-phone').text(response.institution_phone);
            },
            error: function (xhr, status, error) {

                console.log(error);
            }
        });
    }
</script>

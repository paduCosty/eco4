<div class="modal fade" id="add-details-to-event-modal" tabindex="-1" aria-labelledby="add-details-to-event-label"
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
                <form>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Cantitatea de deșeuri (kg):</label>
                        <input type="number" class="form-control" id="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="sack-number" class="form-label">Numărul de saci de deșeuri:</label>
                        <input type="number" class="form-control" id="sack-number" required>
                    </div>
                    <div class="mb-3">
                        <label for="photos" class="form-label">Adaugă poze:</label>
                        <input type="file" class="form-control" id="photos" multiple>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Salvează</button>
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
                $('#event-relief-type').text(response.relief_type);
                $('#event-volunteer-size').text(response.size_volunteer_id);

            },
            error: function (xhr, status, error) {

                console.log(error);
            }
        });
    }
</script>

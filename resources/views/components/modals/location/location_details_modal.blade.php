<div class="modal fade" id="locations-details-modal" tabindex="-1" aria-labelledby="locations-details-modal-label"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-product-modal-label">Detaliile Locatiei</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="color: #a00404"> X
                </button>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="mb-3 col-md-6 ">
                        <label class="fs-5 " style="color:rgb(124, 121, 121)">Judet:</label>
                        <input class="text-gray form-control fs-6 region_id" id="details_region" readonly>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="fs-5" style="color:rgb(124, 121, 121)">Localitate:</label>
                        <input class="form-control fs-6 text-gray cities_id" id="details_city" readonly>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="fs-5" style="color:rgb(124, 121, 121)">Tip teren:</label>
                        <input name="relief_type" id="details_relief_type" class="form-control select-location fs-6"
                               readonly>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="fs-5" style="color:rgb(124, 121, 121)">La fata locului:</label>
                        <input name="size_volunteer_id" class="form-control select-location fs-6 text-gray"
                               id="details_size_volunteer" readonly>
                    </div>

                    <div class="container mb-2">
                        <div id="details_map"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="fs-5 " style="color:rgb(124, 121, 121)" for="pin_address">Adresa
                            selectata:</label>
                        <input class="form-control fs-6 text-gray pin_address" readonly name="address" id="details_address">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
    #details_map {
        height: 500px;
        width: 100%;
        /* width: 700px;
        height: 500px; */
    }
</style>

<script>

        $('#locations-details-modal').on('shown.bs.modal', function (e) {
            var button = $(e.relatedTarget);
            var location_id = button.data('location_id');

            $.ajax({
                url: '/admin/locations/' + location_id,
                type: 'Get',
                success: function (response) {
                    $('#details_region').val(response.data.region_name)
                    $('#details_city').val(response.data.city_name)
                    $('#details_relief_type').val(response.data.relief_type)
                    $('#details_size_volunteer').val(response.data.size_volunteer_name)
                    $('#details_address').val(response.data.address)
                    initLocationDetailsMap(response.data.latitude, response.data.longitude);

                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });

        })

</script>

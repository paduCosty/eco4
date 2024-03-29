<div class="modal fade" id="edit-event-modal" tabindex="-1" aria-labelledby="edit-product-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-product-modal-label">Editeaza Locatia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="color: #a00404"> X</button>
            </div>
            <div class="modal-body">
                <form class="form_edit_event" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="row form-group">
                        <div class="mb-3 col-md-6 ">
                            <label class="col-form-label form-modal-label" style="color:rgb(124, 121, 121)" >Judet:</label>
                            <input class="text-gray form-control-plaintext input-normal region_id" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="col-form-label form-modal-label" style="color:rgb(124, 121, 121)">Localitate:</label>
                            <input class="form-control-plaintext input-normal text-gray cities_id" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="col-form-label form-modal-label" style="color:rgb(124, 121, 121)">Tip teren:</label>
                            <select name="relief_type" class="form-control-plaintext input-normal select-location" required>
                                <option  class=" text-gray" value="">Selecteaza</option>
                                <option value="Campie">Campie
                                </option>
                                <option value="Deal">
                                    Deal
                                </option>
                                <option value="Munte">
                                    Munte
                                </option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="col-form-label form-modal-label" style="color:rgb(124, 121, 121)">La fata locului:</label>
                            <select name="size_volunteer_id" class="form-control-plaintext input-normal select-location text-gray" id="size_volunteer_id" required>
                                <option value="">Selecteaza</option>

                            </select>
                        </div>

                        <div class="mb-3 col-md-6">
                            <input type="hidden" class="gps_latitude" name="latitude">
                            <input type="hidden" class="gps_longitude" name="longitude">
                        </div>

                        <div class="container mb-2">
                            <div id="custom_map"></div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="col-form-label form-modal-label" style="color:rgb(124, 121, 121)" for="pin_address">Adresa selectata:</label>
                            <input class="form-control-plaintext input-normal text-gray pin_address" readonly name="address">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12 text-end">
                            <button type="submit"
                                    class="form-submit">Editeaza loc
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
    #custom_map {
        height: 500px;
        width: 100%;
        /* width: 700px;
        height: 500px; */
    }
</style>

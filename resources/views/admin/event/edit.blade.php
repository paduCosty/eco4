<div class="modal fade" id="edit-event-modal" tabindex="-1" aria-labelledby="edit-product-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-product-modal-label">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="color: #a00404"> X</button>
            </div>
            {{--            @dd($id) --}}
            <div class="modal-body">
                {{--                @if ($errors->any()) --}}
                {{--                    <div class="alert alert-danger"> --}}
                {{--                        <strong>Whoops!</strong> There were some problems with your input.<br><br> --}}
                {{--                        <ul> --}}
                {{--                            @foreach ($errors->all() as $error) --}}
                {{--                                <li>{{ $error }}</li> --}}
                {{--                            @endforeach --}}
                {{--                        </ul> --}}
                {{--                    </div> --}}
                {{--                @endif --}}

                <form class="form_edit_event" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="row form-group">
                        <div class="mb-3 col-md-6 ">
                            <label class="fs-5 text-gray">Judet:</label>
                            <input class="text-gray form-control fs-6 region_id" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="fs-5 text-gray ">Localitate:</label>
                            <input class="form-control fs-6 text-gray cities_id" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="fs-5 " for="pin_address">Adresa selectata:</label>
                            <input class="form-control fs-6 text-gray pin_address" readonly name="address">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="fs-5 text-gray">Tip teren:</label>
                            <select name="relief_type" class="form-control select-location fs-6 text-gray">
                                <option value="">Selecteaza</option>
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
                            <label class="fs-5">La fata locului:</label>
                            <select name="size_volunteer_id" class="form-control select-location fs-6 text-gray">
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
                    </div>
                    <button type="submit" class="btn btn-default butts fs-5"> Send</button>
                </form>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
    #custom_map {
        width: 700px;
        height: 500px;
    }
</style>

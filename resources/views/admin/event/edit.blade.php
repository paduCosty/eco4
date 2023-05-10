
<div class="modal fade" id="edit-event-modal" tabindex="-1" aria-labelledby="edit-product-modal-label"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-product-modal-label">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
{{--            @dd($id)--}}
            <div class="modal-body">
{{--                @if ($errors->any())--}}
{{--                    <div class="alert alert-danger">--}}
{{--                        <strong>Whoops!</strong> There were some problems with your input.<br><br>--}}
{{--                        <ul>--}}
{{--                            @foreach ($errors->all() as $error)--}}
{{--                                <li>{{ $error }}</li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                @endif--}}

                <form class="form_edit_event" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="row">
                        <div class="col-12 col-sm-6 mb-4">
                            <div class="row">
                                <div class="mb-3">
                                    <label class="fs-5">Judet:</label>
                                    <input class="form-control fs-6 text-dark region_id"  readonly>
                                </div>
                            </div>
                            <div class="cmb-4">
                                <label class="fs-5">Localitate:</label>
                                <input class="form-control fs-6 text-dark cities_id"  readonly>
                            </div>
                        </div>
                    </div>
                    <div class="container mb-2">
                        <div id="custom_map"></div>
                    </div>
                    <div class="mt-4">
                        <input type="hidden" class="gps_latitude" name="latitude">
                        <input type="hidden" class="gps_longitude" name="longitude">
                    </div>
                    <div class="row form-group mb-3 address_display">
                        <div class="col-12 col-sm-6">
                            <label class="fs-5 " for="pin_address">Adresa selectata:</label>
                            <input class="form-control fs-6 text-dark pin_address"  readonly
                                   name="address">
                        </div>
                    </div>
                    <div class="row form-group mb-3">
                        <div class="col-12 col-sm-6">
                            <label class="fs-5">Tip teren:</label>
                            <select name="relief_type" class="form-control select-location fs-6 text-dark">
                                <option value="">Selecteaza</option>
                                <option value="Campie"
                                     >Campie
                                </option>
                                <option value="Deal" >
                                    Deal
                                </option>
                                <option value="Munte"
                                >
                                    Munte
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group mb-3">
                        <div class="col-12 col-sm-6">
                            <label class="fs-5">La fata locului:</label>
                            <select name="size_volunteer_id" class="form-control select-location fs-6 text-dark">
                                <option value="">Selecteaza</option>

                            </select>
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


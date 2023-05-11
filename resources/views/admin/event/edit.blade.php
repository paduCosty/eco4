
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
                        <div class=" mb-3">
                            <label class="fs-5">Judet:</label>
                            <select class="form-control fs-6 text-gray" name="region_id" >
                                <option  value="{{$region->id}}" selected>{{$region->name}}</option>
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

                    <div class="cmb-4">
                        <label class="fs-5">Localitate:</label>
                        <select class="form-control fs-6 text-gray" name="cities_id" >
                            <option  value="{{$city->id}}" selected>{{$city->name}}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="container mb-2">
                <div id="map"></div>
            </div>
            <div class="mt-4">
                <input type="hidden" id="gps_longitude" name="longitude">
                <input type="hidden" id="gps_latitude" name="latitude">
            </div>

            <div class="row form-group mb-3" id="address_display">
                <div class="col-12 col-sm-6">
                    <label class="fs-5 " for="pin_address">Adresa selectata:</label>
                    <input class="form-control fs-6 text-gray" value="{{$event_location->address}}" readonly name="address" id="pin_address">
                </div>
            </div>

            <div class="row form-group mb-3">
                <div class="col-12 col-sm-6">
                    <label class="fs-5">Tip teren:</label>
                    <select name="relief_type" class="form-control select-location fs-6 text-gray">
                        <option value="">Selecteaza</option>
                        <option value="Campie" @if($event_location->relief_type == 'Campie') selected @endif>Campie</option>
                        <option value="Deal" @if($event_location->relief_type == 'Deal') selected @endif>Deal</option>
                        <option value="Munte" @if($event_location->relief_type == 'Munte') selected @endif>Munte</option>
                    </select>
                </div>
            </div>
            <div class="row form-group mb-3">
                <div class="col-12 col-sm-6">
                    <label class="fs-5">La fata locului:</label>
                    <select name="size_volunteer_id" class="form-control select-location fs-6text-gray">
                        <option value="">Selecteaza</option>
                        @foreach($size_volunteers as $size_volunteer)
                            <option @if($size_volunteer->id == $event_location->size_volunteer_id)  selected
                                    @endif value="{{$size_volunteer->id}}">{{$size_volunteer->name}}</option>
                        @endforeach
                    </select>


                </div>
            </div>
            <button type="submit" class="btn btn-default butts fs-5"> Send </button>
        </form>


                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-default butts fs-5"> Send</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- <style type="text/css">
    #map {
        width:900px;
        height: 500px;
    }
</style> --}}
<script type="text/javascript">

    function initMap() {

        let event_location = {!! json_encode($event_location) !!};
        lat = event_location.latitude;
        lng = event_location.longitude;
        $('#gps_latitude').val(lat);
        $('#gps_longitude').val(lng);
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            center: {lat: lat, lng: lng},
        });

        const marker = new google.maps.Marker({
            position: {lat: lat, lng: lng},
            map: map,
        });

        const geocoder = new google.maps.Geocoder();

        map.addListener("click", (event) => {
            $('#gps_latitude').val(event.latLng.lat());
            $('#gps_longitude').val(event.latLng.lng());
            marker.setPosition(event.latLng);

            geocoder.geocode({location: event.latLng}, (results, status) => {
                if (status === "OK" && results[0]) {
                    console.log(results[0].formatted_address);
                    $('#address_display').show();
                    $('#pin_address').val(results[0].formatted_address);

                } else {
                    console.log("Geocoding failed: " + status);
                }
            });
        });

    }
<style type="text/css">
    #custom_map {
        width: 700px;
        height: 500px;
    }
</style>


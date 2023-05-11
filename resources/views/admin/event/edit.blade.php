@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb mb-4">
                <div class="text-center mb-2">
                    <h2>Edit Product</h2>
                </div>
                <div class="pull-right mb-3">
                    <a class="btn btn-default butts fs-5" href="{{ route('event-locations.index') }}"> Back</a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('event-locations.update', $event_location->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">

                <div class="col-12 col-sm-6 mb-4">
                    <div class="row">
                        <div class=" mb-3">
                            <label class="fs-5">Judet:</label>
                            <select class="form-control fs-6 text-gray" name="region_id" >
                                <option  value="{{$region->id}}" selected>{{$region->name}}</option>
                            </select>

                        </div>
                    </div>

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


    </div>

@endsection


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

    window.initMap = initMap;
</script>

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="text-center mb-5">
                    <h2>Adauga o noua locatie</h2>
                </div>

                <div class="pull-right mb-3">
                    <a class="btn btn-default butts fs-5" href="{{ route('event-locations.index') }}"> Back</a>
                </div>
            </div>
        </div>
        <br>

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

        <form action="{{ route('event-locations.store') }}" method="POST">
            @csrf

            <div class="row">

                <div class="col-12 col-sm-6 mb-5">
                    <div class="row mb-2 text-gray">
                        <div>
                            <label class="fs-5">Judet:</label>
                            <select id="regions" class="form-control select-location fs-6 text-gray">
                                <option>Judet</option>

                                @foreach($regions as $region)
                                    <option value="{{$region->id}}">{{$region->name}} </option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="mb-1">
                        <label class="fs-5">Localitate: </label>
                        <div class="fs-6 " id="city"></div>
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

            <div class="row form-group mb-3" style="display: none" id="address_display">
                <div class="col-12 col-sm-6">
                    <label class="fs-5 " for="pin_address">Adresa selectata:</label>
                    <input class="form-control fs-6 text-gray" readonly name="address" id="pin_address">
                </div>
            </div>
            <div class="row form-group mb-3">
                <div class="col-12 col-sm-6">
                    <label class="fs-5 ">Tip teren:</label>
                    <select name="relief_type" class="form-control fs-6 text-gray">
                        <option value="">Selecteaza</option>
                        <option value="Campie">Campie</option>
                        <option value="Deal">Deal</option>
                        <option value="Munte">Munte</option>
                    </select>
                </div>
            </div>


            <div class="row form-group mb-3">
                <div class="col-12 col-sm-6">
                    <label class="fs-5">La fata locului:</label>
                    <select name="size_volunteer_id" class="form-control select-location fs-6 text-dark">
                        <option>Selecteaza</option>
                        @foreach($size_volunteers as $size_volunteer)
                            <option value="{{$size_volunteer->id}}">{{$size_volunteer->name}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="pull-right">
                <button type="submit" class="btn btn-default butts fs-5"> Send</button>
            </div>
        </form>

        <script type="text/javascript">

            $(document).ready(function () {
                // console.log(url('/'));
                var APP_URL = {!! json_encode(url('/')) !!};
                $('#regions').change(function () {
                    $('#cities_by_region').remove();
                    var region_id = $(this).val();
                    $.ajax({
                        url: APP_URL + '/admin/get-cities',
                        type: 'Get',
                        data: {region_id: region_id},
                        success: function (response) {

                            var options = '<select name="cities_id" id="cities_by_region" class="form-control select-location">';
                            $.each(response.data, function (index, value) {
                                options += '<option lat="' + value.latitude + '" lng="' + value.longitude + '" value="' + value.id + '">' + value.name + '</option>';
                            });

                            $('#city').append(options += '</select>');

                        },
                        error: function (xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                });
                $(document).on('change', '#cities_by_region', function () {
                    var lat = $('option:selected', this).attr('lat');
                    var lng = $('option:selected', this).attr('lng');

                    initMap(parseFloat(lat), parseFloat(lng), zoom = 13)
                });
            });

            function initMap(lat, lng, zoom = 8) {
                if (!lat || !lng) {
                    //set lat and lng to Bucharest
                    lat = 44.439663;
                    lng = 26.096306;
                }

                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: zoom,
                    center: {lat: lat, lng: lng},
                });

                const marker = new google.maps.Marker({
                    // position: {lat: lat, lng: lng},
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
    </div>

@endsection

<style type="text/css">
    #map {
        width: 700px;
        height: 500px;
    }
</style>


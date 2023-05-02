@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Add New Product</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('event-locations.index') }}"> Back</a>
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

        <form action="{{ route('event-locations.store') }}" method="POST">
            @csrf

            <div class="row">

                <div class="col-12 col-sm-7">
                    <div class="row">
                        <div class="col-12 col-sm-6 mb-3">

                            <select id="regions" name="" class="form-control select-location">
                                <option value="">Judet</option>
                                @foreach($regions as $region)
                                    <option @if($region->id == $event_location->city->region_id)  selected
                                            @endif value="{{$region->id}}">{{$region->name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div id="city"></div>
                    </div>
                </div>
            </div>

            <div class="container mt-5">
                <div id="map"></div>
            </div>
            <div>
                <input type="hidden" id="gps_longitude" name="longitude">
                <input type="hidden" id="gps_latitude" name="latitude">
            </div>
            <div class="row form-group">
                <div class="col-12 col-sm-4">
                    <label for=""
                           class="col-form-label form-modal-label">Tip teren</label>
                    <select name="relief_type" class="form-control select-location">
                        <option value="">Selecteaza</option>
                        <option value="Campie">Campie</option>
                        <option value="Deal">Deal</option>
                        <option value="Munte">Munte</option>
                    </select>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-12 col-sm-4">
                    <label class="col-form-label form-modal-label">La fata locului</label>
                    <select name="size_volunteer_id" class="form-control select-location">
                        <option value="">Selecteaza</option>
                        @foreach($size_volunteers as $size_volunteer)
                            <option @if($size_volunteer->id == $event_location->size_volunteer_id)  selected
                                    @endif value="{{$size_volunteer->id}}">{{$size_volunteer->name}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <button type="submit">Send</button>
        </form>


    </div>

@endsection

<style type="text/css">
    #map {
        height: 400px;
    }
</style>
<script type="text/javascript">
    var APP_URL = {!! json_encode(url('/')) !!};
    function loadCities() {
        $('#cities_by_region').remove();
        var region_id = $('#regions').val();
        $.ajax({
            url: APP_URL + '/admin/get-cities',
            type: 'Get',
            data: {region_id: region_id},
            success: function (response) {
                console.log(response);

                var options = '<select name="cities_id" id="cities_by_region" class="form-control select-location">';
                $.each(response.data, function (index, value) {
                    options += '<option lat="' + value.latitude + '" lng="' + value.longitude + '" value="' + value.id + '">' + value.name + '</option>';
                });

                $('#city').append(options += '</select>');

                // Apelăm funcția pentru a actualiza harta
                updateMap();
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    function updateMap() {
        var lat = $('option:selected', '#cities_by_region').attr('lat');
        var lng = $('option:selected', '#cities_by_region').attr('lng');
        // console.log('Lat:', lat, 'Lng:', lng);

        initMap(parseFloat(lat), parseFloat(lng), zoom = 11)
    }

    $(document).ready(function() {
        // Apelăm funcția la încărcarea paginii
        loadCities();
    });

    $('#regions').change(function () {
        loadCities();
    });

    $(document).on('change', '#cities_by_region', function () {
        updateMap();
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
            position: {lat: lat, lng: lng},
            map: map,
        });

        map.addListener("click", (event) => {
            $('#gps_latitude').val(event.latLng.lat());
            $('#gps_longitude').val(event.latLng.lng());
            marker.setPosition(event.latLng);
        });
    }

    window.initMap = initMap;
</script>

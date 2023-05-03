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

        <form action="{{ route('event-locations.update', $event_location->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">

                <div class="col-12 col-sm-7">
                    <div class="row">
                        <div class="col-12 col-sm-6 mb-3">
                            <label>Judet:</label>
                            <select class="form-control" name="region_id" >
                                <option  value="{{$region->id}}" selected>{{$region->name}}</option>
                            </select>

                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <label>Localitate</label>
                        <select class="form-control" name="cities_id" >
                            <option  value="{{$city->id}}" selected>{{$city->name}}</option>
                        </select>
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
                        <option value="Campie" @if($event_location->relief_type == 'Campie') selected @endif>Campie</option>
                        <option value="Deal" @if($event_location->relief_type == 'Deal') selected @endif>Deal</option>
                        <option value="Munte" @if($event_location->relief_type == 'Munte') selected @endif>Munte</option>
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
        height: 70%;
        /*width: 600px;*/
    }
</style>
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

        map.addListener("click", (event) => {
            $('#gps_latitude').val(event.latLng.lat());
            $('#gps_longitude').val(event.latLng.lng());
            marker.setPosition(event.latLng);
        });
    }

    window.initMap = initMap;
</script>

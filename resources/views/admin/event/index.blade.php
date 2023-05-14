@extends('layouts.app')

@section('content')
    <script defer
            src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initializeMaps"></script>

    <div class="container" style="color:rgb(124, 121, 121)">
        <div class="text-center mb-5">
            <h1>Evenimente</h1>
        </div>
        <div class="row">
            <div class="col-lg-18 margin-tb mb-5">
                @include('admin.event.create')
                <div class="slider-link add-next-eco-action">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Adauga o noua locatie +
                    </a>
                </div>
                {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Adauga o noua locatie +
                </button> --}}
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            <script>
                $(document).ready(function () {
                    setTimeout(function () {
                        $('.alert').fadeOut();
                    }, 5000);
                });
            </script>
        @endif

        <table class="table table-hover t" style="color:rgb(124, 121, 121)">
            <tr>
                <th>Nr.</th>
                <th>Adresa</th>
                <th>Relief</th>
                <th>Voluntari</th>
                <th>Longitudine</th>
                <th>Latitudine</th>
                <th width="170px">Action</th>
            </tr>
            @php($i = 0)
            @foreach ($events as $event)

                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $event->address }}</td>
                    <td>{{ $event->relief_type }}</td>
                    <td>{{ $event->sizeVolunteer->name }}</td>
                    <td>{{ $event->longitude }}</td>
                    <td>{{ $event->latitude }}</td>
                    <td>
                        <form action="{{ route('event-locations.destroy',$event->id) }}" method="POST">
                            {{--                            <a class="btn btn-default buttons" href="{{ route('event-locations.edit',$event->id) }}">Edit</a>--}}
                            <button type="button"
                                    event="{{json_encode($event)}}"
                                    class="btn btn-primary edit_event_button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#edit-event-modal"
                            >
                                Edit
                            </button>

                            @csrf
                            @if(!$event->users_event_locations_count)
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger buttons">Delete</button>
                            @endif
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $events->withQueryString()->links('pagination::bootstrap-5') !!}

    </div>
    @include('admin.event.edit')
    <script>

        const APP_URL = {!! json_encode(url('/')) !!};

        $(document).ready(function () {
            /* get cities and make a select with them*/
            $('#regions').change(function () {
                $('#cities_by_region').remove();
                var region_id = $(this).val();
                $.ajax({
                    url: APP_URL + '/admin/get-cities',
                    type: 'Get',
                    data: {region_id: region_id},
                    success: function (response) {

                        var options = `<select name="cities_id" id="cities_by_region" class="form-control select-location" required>
                                            <option value="">Localitatea</option>`;
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
            /*when a city is select, set google maps lat and lng*/
            $(document).on('change', '#cities_by_region', function () {
                var lat = $('option:selected', this).attr('lat');
                var lng = $('option:selected', this).attr('lng');

                initCreateEventMap(parseFloat(lat), parseFloat(lng), zoom = 13)
            });
        });

        function initCreateEventMap(lat = null, lng = null, zoom = 8) {
            if (!lat || !lng) {
                //set lat and lng to Bucharest
                lat = 44.439663;
                lng = 26.096306;
            }

            const map = new google.maps.Map(document.getElementById("create_event_map"), {
                zoom: zoom,
                center: {lat: lat, lng: lng},
            });

            const marker = new google.maps.Marker({
                // remove marker
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

        /*create edit form*/
        $('.edit_event_button').click(function () {

            let event = JSON.parse($(this).attr('event'));

            let size_volunteers = {!! $size_volunteers !!};
            let html_select = '';
            for (let i = 0; i < size_volunteers.length; ++i) {
                html_select += `<option value=${size_volunteers[i].id}>${size_volunteers[i].name}</option>`
            }
            $('.form_edit_event').attr('action', APP_URL + '/admin/event-locations/update/' + event.id)
            $('.region_id').val(event.city.region.name).text(event.city.region.id);
            $('.cities_id').val(event.city.name).text(event.city.id);
            $('.gps_longitude').val(event.longitude)
            $('.gps_latitude').val(event.latitude)
            $('.pin_address').val(event.address).text(event.address);
            $('select[name="relief_type"]').val(event.relief_type);
            $('select[name="size_volunteer_id"]').append(html_select).val(event.size_volunteer_id);
            initEditEventMap(event.latitude, event.longitude);
        });

        function initEditEventMap(lat = null, lng = null) {
                if(!lat && !lng) {
                   return false;
                }

            const map = new google.maps.Map(document.getElementById("custom_map"), {
                zoom: 13,
                center: {lat: lat, lng: lng},
            });

            const marker = new google.maps.Marker({
                position: {lat: lat, lng: lng},
                map: map,
            });
            const geocoder = new google.maps.Geocoder();

            map.addListener("click", (event) => {
                $('.gps_latitude').val(event.latLng.lat());
                $('.gps_longitude').val(event.latLng.lng());
                marker.setPosition(event.latLng);

                geocoder.geocode({location: event.latLng}, (results, status) => {
                    if (status === "OK" && results[0]) {
                        console.log(results[0].formatted_address);
                        $('.address_display').show();
                        $('.pin_address').val(results[0].formatted_address);

                    } else {
                        console.log("Geocoding failed: " + status);
                    }
                });
            });

        }

        function initializeMaps() {
            initCreateEventMap();
            initEditEventMap();
        }
    </script>
@endsection

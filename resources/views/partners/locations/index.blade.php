@extends('layouts.app')

@section('content')

    <div class="container" style="color:rgb(124, 121, 121)">
        <div class="text-center mb-5">
            <h4>Locatii propuse</h4>
        </div>
        <div class="row">
            <div class="col-lg-18 margin-tb mb-5">
                @if(Auth::user()->role == 'partner')
                    <div class="slider-link add-next-eco-action">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#create-event-modal">
                            Adauga o noua locatie +
                        </a>
                    </div>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <script>
            $(document).ready(function () {
                setTimeout(function () {
                    $('.alert').fadeOut();
                }, 5000);
            });
        </script>

        <table class="table table-hover" style="color:rgb(124, 121, 121)">
            <tr>
                <th width="95px">Nr. Id.</th>
                <th>Judet</th>
                <th>Adresa</th>
                <th>Relief</th>
                <th>Voluntari</th>
                <th>Longitudine</th>
                <th>Latitudine</th>
                <th width="110px">Action</th>
            </tr>
            @php($i = 0)
            @foreach ($events as $location)
                <tr>
                    <td>{{ ++$i }}
                        <a href="#" data-location_id="{{$location->id}}" class="action-button"
                           data-bs-toggle="modal"
                           data-bs-target="#locations-details-modal">L{{$location->id}}</a>
                    </td>
                    <td>{{ $location->city->region->name }}</td>
                    <td>{{ $location->address }}</td>
                    <td>{{ $location->relief_type }}</td>
                    <td>{{ $location->sizeVolunteer->name }}</td>
                    <td>{{ $location->longitude }}</td>
                    <td>{{ $location->latitude }}</td>
                    <td>
                        <form action="{{ route('locations.destroy', $location->id) }}" class="delete-form"
                              method="POST">
                            <a class="action-button edit_event_button col mb-3" type="button"
                               event="{{ json_encode($location) }}" data-bs-toggle="modal"
                               data-bs-target="#edit-event-modal">Edit
                            </a>

                            @csrf
                            @if (!$location->users_event_locations_count)
                                @method('DELETE')
                                <a type="button" class="action-button delete-location-button">Delete</a>
                            @endif
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $events->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>

    @include('partners.locations.edit')
    @include('partners.locations.create')


    <script>
        /* get cities and make a select with them*/
        $('#regions').change(function () {
            $('#cities_by_region').remove();
            var region_id = $(this).val();
            $.ajax({
                url: APP_URL + '/get-cities',
                type: 'Get',
                data: {
                    region_id: region_id
                },
                success: function (response) {
                    var options = `<select name="cities_id" id="cities_by_region" class="form-control select-location" required>
                                            <option value="">Localitatea</option>`;
                    $.each(response.data, function (index, value) {
                        options += '<option lat="' + value.latitude + '" lng="' +
                            value.longitude + '" value="' + value.id + '">' + value
                                .name + '</option>';
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

        $('#create-event-modal').on('shown.bs.modal', function (e) {
            initCreateEventMap();
        });

        /*create edit form*/
        $('.edit_event_button').click(function () {

            let event = JSON.parse($(this).attr('event'));

            let size_volunteers = {!! $size_volunteers !!};
            let html_select = '';
            for (let i = 0; i < size_volunteers.length; ++i) {
                html_select += `<option class="size_volunteers_option" value=${size_volunteers[i].id}>${size_volunteers[i].name}</option>`
            }
            $('.form_edit_event').attr('action', APP_URL + '/admin/locations/update/' + event.id)
            $('.region_id').val(event.city.region.name).text(event.city.region.id);
            $('.cities_id').val(event.city.name).text(event.city.id);
            $('.gps_longitude').val(event.longitude)
            $('.gps_latitude').val(event.latitude)
            $('.pin_address').val(event.address).text(event.address);
            $('select[name="relief_type"]').val(event.relief_type);
            $('.size_volunteers_option').remove();
            $('#size_volunteer_id').append(html_select).val(event.size_volunteer_id);
            initEditEventMap(event.latitude, event.longitude);
        });

        $('.delete-location-button').click(function () {
            if (confirm('Esti sigur ca vrei sa stergi acest Eveniment')) {
                $(this).closest('.delete-form').submit();

            }
        });

    </script>

@endsection

@extends('layouts.app')

@section('content')
    @include('admin.propose-event.edit')
    @include('admin.propose-event.enrolled_volunteers')
    @include('admin.propose-event.details_modal')
    @include('components.modals.add_details_to_event')

    <div class="container">

        <div class="text-center  mb-5" style="color:rgb(124, 121, 121)">
            <h4>Actiuni Ecologizare</h4>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="alert-success-link"></div>
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
                <th>Nr.
                    @if(auth()->user()->role !== 'coordinator')
                        /id
                    @endif
                </th>
                <th>Adresa</th>
                <th>Data acțiune</th>
                <th>Inscrisi</th>
                <th>Status</th>
                <th>Acțiuni</th>
            </tr>
            @php($i = 1)
            @foreach ($eventLocations as $event)
                <tr>
                    <td>{{ $i }}
                        @if(auth()->user()->role !== 'coordinator')
                            <a href="#" data-location_id="{{$event->event_location_id}}" class="action-button"
                               data-bs-toggle="modal"
                               data-bs-target="#locations-details-modal">A#{{$event->id}}
                                /L#{{$event->event_location_id}}</a></td>
                    @endif
                    <td>
                        {{ $event->eventLocation->city->name }},
                        {{$event->eventLocation->city->region->name}}</td>
                    <td width="9%">{{ $event->due_date }}</td>
                    <td>
                        @if ($event->event_registrations_count > 0)
                            <a class="col open-volunteers-modal action-button" type="button"
                               data-bs-toggle="modal" data-bs-target="#volunteers-modal"
                               event_location_id="{{ $event->id }}">
                                {{ $event->event_registrations_count }} Voluntari
                            </a>
                        @endif
                    </td>
                    <td>
                        @if (($event->status != 'aprobat' && $event->status != 'in asteptare' && $event->status != 'refuzat') || auth()->user()->role === 'coordinator')
                            {{ ucfirst($event->status) }}
                        @else
                            <div class="d-inline-block buttons-switch">
                                <div class="switch-toggle switch-3 switch-candy" style="background-color: transparent">
                                    <input id="on-{{ $i }}" name="state-d-{{ $i }}" type="radio"
                                           @if ($event->status == 'acceptat') checked="checked" @endif />
                                    <label class="switch-status-on switch-checkbox" for="on-{{ $i }}"
                                           location_id={{ $event->id }}>
                                        Acceptat
                                    </label>

                                    <input id="na-{{ $i }}" name="state-d-{{ $i }}" type="radio"
                                           disabled
                                           @if ($event->status == 'in asteptare') checked="checked" @endif />
                                    <label for="na-{{ $i }}" class="disabled">Asteapta</label>

                                    <input id="off-{{ $i }}" name="state-d-{{ $i }}" type="radio"
                                           @if ($event->status == 'refuzat') checked="checked" @endif />
                                    <label class="switch-status-off switch-checkbox test" for="off-{{ $i }}"
                                           style="color:#9b0606 !important" location_id={{ $event->id }}>
                                        Refuzat
                                    </label>
                                    <a class="button-color"></a>
                                </div>
                            </div>
                        @endif
                        @if($event->status === 'desfasurat')
                            <a href="#" data-bs-toggle="modal" data-event_id="{{$event->id}}"
                               data-bs-target="#add-details-to-event-modal" class="col action-button">
                                Creaza/Editeaza
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                    <style>svg {
                                            fill: #a6ce39
                                        }</style>
                                    <path
                                        d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"/>
                                </svg>

                                <span class="button-text"></span>
                            </a>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex">
                            @if((auth()->user()->role === 'coordinator' && $event->status != 'aprobat') || $event->status != 'desfasurat')
                                <a class="col action-button open_edit_modal" type="button" data-bs-toggle="modal"
                                   data-bs-target="#edit-propose-event-modal" location="{{ json_encode($event) }}">
                                    Edit
                                </a>
                            @endif
                            <a class="col action-button open_description_modal" type="button" data-bs-toggle="modal"
                               data-bs-target="#details-event-modal" event_location_id="{{ $event->id }}">
                                Detalii
                            </a>

                            @if($event->status == 'aprobat')
                                <a type="button" class="col action-button generate-representation-link"
                                   data-event_id="{{ $event->id }}">Reprezentati</a>
                            @endif


                        </div>
                    </td>
                </tr>
                @php($i++)
            @endforeach
        </table>
        {!! $eventLocations->withQueryString()->links('pagination::bootstrap-5') !!}

    </div>

    <script>
        $(document).ready(function () {
            const APP_URL = window.location.origin;
            /*open edit modal*/
            $(".open_edit_modal").on("click", function () {
                let location = JSON.parse($(this).attr('location'));

                $('.form_edit_propose_event').attr('action', 'propose-locations/update/' +
                    location.id)

                $('.event_location_due_date').val(location.due_date);
                $('.event_location_status').val(location.status);
                $('.event_location_description').val(location.description);
            });

            /* Update status */
            $(".switch-status-on").on("click", function () {
                status_active_inactive('aprobat', $(this).attr('location_id'))
            });

            $(".switch-status-off").on("click", function () {
                status_active_inactive('refuzat', $(this).attr('location_id'))
            });

            function status_active_inactive(val, location_id) {
                $.ajax({
                    url: APP_URL + '/admin/approve-or-decline-propose-event/' + location_id,
                    type: 'Get',
                    data: {
                        val: val
                    },

                    success: function (response) {
                        let successAlert;

                        if (response.success) {
                            successAlert = $('<div class="alert alert-success">' + response.message + '</div>');

                        } else {
                            successAlert = $('<div class="alert alert-danger">' + response.message + '</div>')
                        }

                        $('.alert-success-link').append(successAlert);
                        setTimeout(function () {
                            successAlert.remove();
                        }, 3000);
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                        alert(status);
                    }
                });
            }

            // load data when volunteers modal is open
            $('.open-volunteers-modal').click(function () {
                loadVolunteers($(this).attr('event_location_id'), 1);
            });


            $('.generate-representation-link').click(function () {
                var event_id = $(this).data('event_id');
                $.ajax({
                    url: '/generate-represent-unique-url/' + event_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        var uniqueUrl = response.uniqueUrl;
                        copyToClipboard(uniqueUrl);

                        var successMessage = 'URL-ul a fost generat și copiat în clipboard!';
                        var successAlert = $('<div class="alert alert-success">' + successMessage + '</div>');
                        $('.alert-success-link').append(successAlert);
                        setTimeout(function () {
                            successAlert.remove();
                        }, 3000);
                    },
                    error: function (xhr, status, error) {
                        alert('Eroare la generarea URL-ului.');
                    }
                });
            });

            function copyToClipboard(text) {
                var $tempInput = $('<input>');
                $('body').append($tempInput);
                $tempInput.val(text).select();
                document.execCommand('copy');
                $tempInput.remove();
            }
        });
        $('.open_description_modal').on('click', function () {
            let location_id = $(this).attr('event_location_id')
            event_details(location_id);
        });

    </script>
@endsection

<style>
    th {
        text-align: left;
    }

    .switch-toggle {
        width: 17em;

    }

    .switch-candy {
        height: 100%;

    }

    .button-color {
        background-color: #A6CE39 !important;
        border: none !important;
    }

    .switch-checkbox {
        height: 100%;
    }

    .table td {
        font-size: 14px;
    }

    * {
        /*font-family: 'Inter' !important;*/
        font-family: inherit;
    }

    .switch-light.switch-candy span span, .switch-light.switch-candy input:checked ~ span span:first-child, .switch-toggle.switch-candy label {
        text-shadow: none !important;
        font-weight: normal !important;
        color: rgb(124, 121, 121) !important;

    }

    .switch-toggle.switch-candy {
        box-shadow: none !important;
    }

</style>

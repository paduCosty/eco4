@extends('layouts.app')

@section('content')
    @include('admin.propose-event.edit')
    @include('admin.propose-event.enrolled_volunteers')
    @include('admin.propose-event.details_modal')


    <div class="container">

        <div class="text-center  mb-5" style="color:rgb(124, 121, 121)">
            <h4>Evenimentele mele</h4>
        </div>

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
                <th>Nr./id</th>
                <th>Adresa</th>
                <th>Data limită</th>
                <th>Voluntari</th>
                <th>Status</th>
                <th>Acțiuni</th>
            </tr>
            @php($i = 1)
            @foreach ($eventLocations as $event)
                <tr>
                    <td>{{ $i }} <a href="#" data-location_id="{{$event->event_location_id}}" class="action-button"
                        data-bs-toggle="modal"
                        data-bs-target="#locations-details-modal">A#{{$event->id}}/L#{{$event->event_location_id}}</a> </td>
                    <td>
                        {{$event->eventLocation->city->region->name}},
                        {{ $event->eventLocation->city->name }}</td>
                    <td width="9%">{{ $event->due_date }}</td>
                    <td>
                        @if ($event->event_registrations_count > 0)
                            <a class="col open-volunteers-modal" type="button"
                               data-bs-toggle="modal" data-bs-target="#volunteers-modal"
                               event_location_id="{{ $event->id }}">
                                {{ $event->event_registrations_count }}
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
                                    <label class="switch-status-off switch-checkbox" for="off-{{ $i }}"
                                           style="color:red !important" location_id={{ $event->id }}>
                                        Refuzat
                                    </label>
                                    <a></a>
                                </div>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex">

                            @if(auth()->user()->role !== 'coordinator')
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
                console.log(location);
                $('.form_edit_propose_event').attr('action', APP_URL + '/admin/propose-locations/update/' +
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
                            successAlert = $('<div class="alert alert-danger">' + response.message  + '</div>')
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

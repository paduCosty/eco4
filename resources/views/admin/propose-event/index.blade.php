@extends('layouts.app')

@section('content')
    @include('admin.propose-event.edit')
    <div class="container">
        <div class="text-center mb-5">
            <h1>Evenimente Propuse</h1>
        </div>
        <div class="row">
            <div class="col-lg-18 margin-tb mb-5">
                <div class="pull-right mb-5">
                    <a class="btn btn-default butts fs-5" href="{{ route('home.home') }}"> Propune un eveniment</a>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <table class="table table-hover t">
            <tr>
                <th>Nr.</th>
                <th>Nume</th>
                <th>Email</th>
                <th>Adresa</th>
                <th>Data limită</th>
                <th>Voluntari</th>
                <th>Status</th>
                <th>Acțiuni</th>
            </tr>
            @php($i = 1)
            @foreach ($eventLocations as $location)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $location->name }}</td>
                    <td>{{ $location->email }}</td>
                    <td>{{ $location->eventLocation->address }}</td>
                    <td>{{ $location->due_date }}</td>
                    <td>{{ $location->event_registrations_count }}</td>
                    <td>
                        @if($location->status != 'aprobat' && $location->status != 'in asteptare' && $location->status != 'refuzat')
                            {{ ucfirst($location->status) }}
                        @else
                            <div class="d-inline-block buttons-switch">
                                <div class="switch-toggle switch-3 switch-candy"
                                     style="background-color: transparent">
                                    <input id="on-{{ $i }}" name="state-d-{{ $i }}" type="radio"
                                           @if($location->status == 'acceptat')  checked="checked" @endif/>
                                    <label class="switch-status-on switch-checkbox" for="on-{{ $i }}"
                                           location_id= {{$location->id}}>
                                        Acceptat
                                    </label>

                                    <input id="na-{{ $i }}" name="state-d-{{ $i }}" type="radio" disabled
                                           @if($location->status == 'in asteptare') checked="checked" @endif/>
                                    <label for="na-{{ $i }}" class="disabled">Asteapta</label>

                                    <input id="off-{{ $i }}" name="state-d-{{ $i }}" type="radio"
                                           @if($location->status == 'refuzat') checked="checked" @endif/>
                                    <label class="switch-status-off switch-checkbox" for="off-{{ $i }}"
                                           style="color:red" location_id= {{$location->id}}>
                                        Refuzat
                                    </label>
                                    <a></a>
                                </div>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="form-group">

                            <div class="d-inline-block">
                                <a type="button" class="btn btn-primary open_edit_modal" data-bs-toggle="modal"
                                   data-bs-target="#edit-propose-event-modal" location="{{json_encode($location)}}">
                                    Edit
                                </a>
                            </div>
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

            $(".open_edit_modal").on("click", function () {
                let location = JSON.parse($(this).attr('location'));

                $('.form_edit_propose_event').attr('action', APP_URL + '/admin/propose-locations/update/' + location.id)

                $('.event_location_name').val(location.name);
                $('.event_location_email').val(location.email);
                $('.event_location_due_date').val(location.due_date);
                $('.event_location_status').val(location.status);
            });

            $(".switch-status-on").on("click", function () {
                status_active_inactive('aprobat', $(this).attr('location_id'))
                console.log('asdf');
            });

            $(".switch-status-off").on("click", function () {
                status_active_inactive('refuzat', $(this).attr('location_id'))
            });

            function status_active_inactive(val, location_id) {
                $.ajax({
                    url: APP_URL + '/admin/approve-or-decline-propose-event/' + location_id,
                    type: 'Get',
                    data: {val: val},

                    success: function (response) {
                        // console.log(response.success);
                        // if (response.success) {
                        //     $('#status_value' + location_id).text(response.status);
                        // }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    </script>
@endsection

<style>
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

</style>

@extends('layouts.app')

@section('content')
    @include('admin.propose-event.edit')
    @include('admin.propose-event.enrolled_volunteers')


    <div class="container">
     
        <div class="text-center  mb-5" style="color:rgb(124, 121, 121)">
             <h1>Evenimente de ecologizare propuse</h1>
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

        <table class="table table-hover t " style="color:rgb(124, 121, 121)">
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
                            @if($location->event_registrations_count > 0)

                                <a type="button" class="btn btn-primary open-volunteers-modal" data-bs-toggle="modal"
                                   data-bs-target="#volunteers-modal" event_location_id="{{$location->id}}">Vezi
                                    voluntari</a>
                            @endif
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


            $('.open-volunteers-modal').click(function () {
                loadVolunteers($(this).attr('event_location_id'), 1);
            });

            function loadVolunteers(event_id, page) {
                $.ajax({
                    url: '/api/volunteers/' + event_id,
                    method: 'GET',
                    data: {
                        page: page,
                    },
                    success: function (data) {
                        var tableBody = $('#volunteers-table tbody');
                        tableBody.empty();

                        for (var i = 0; i < data.data.length; i++) {
                            var volunteer = data.data[i];

                            var row = '<tr>' +
                                '<td>' + volunteer.email + '</td>' +
                                '<td>' + volunteer.name + '</td>' +
                                '<td>' + volunteer.phone + '</td>' +
                                '</tr>';

                            tableBody.append(row);
                        }
                        // Actualizează paginarea
                        updatePagination(page, data.total_pages, event_id);
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            }

            function updatePagination(currentPage, totalPages, event_id) {

                var paginationContainer = $('#pagination-container');
                var pageInfoContainer = $('#page-info');

                paginationContainer.empty();
                pageInfoContainer.empty();

                if (totalPages <= 1) {
                    return false;
                }
                for (var i = 1; i <= totalPages; i++) {
                    var button = $('<button class="btn btn-link page-link"></button>');
                    button.text(i);
                    button.data('page', i);

                    button.click(function () {
                        var page = $(this).data('page');
                        loadVolunteers(event_id, page);
                    });

                    paginationContainer.append(button);
                }
                paginationContainer.addClass('pagination');
                pageInfoContainer.text('Pagina ' + currentPage + ' din ' + totalPages);
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

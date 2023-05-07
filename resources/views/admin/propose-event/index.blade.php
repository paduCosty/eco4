@extends('layouts.app')

@section('content')

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
                <th>Nume</th>
                <th>Email</th>
                <th>Adresa</th>
                <th>Data limită</th>
                <th>Status</th>
                <th>Acțiuni</th>
            </tr>
            @php($i = 0)
            @foreach ($eventLocations as $location)
                <tr>
                    <td>{{ $location->name }}</td>
                    <td>{{ $location->email }}</td>
                    <td>{{ $location->eventLocation->address }}</td>
                    <td>{{ $location->due_date }}</td>
                    <td>{{ ucfirst($location->status) }}</td>
                    <td>
                        <form action="{{ route('event-locations.destroy',$location->id) }}" method="POST">
                            @csrf
                            <div class="btn-group">
                                <a type="button" class="btn btn-success buttons">Aprobă</a>
                                <a type="button" class="btn btn-danger buttons">Respinge</a>
                                <a class="btn btn-default buttons" href="{{ route('event-locations.edit',$location->id) }}">Editeaza</a>

                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $eventLocations->withQueryString()->links('pagination::bootstrap-5') !!}

    </div>

@endsection

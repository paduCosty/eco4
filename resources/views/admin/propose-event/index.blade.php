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
                <th>Eveniment</th>
                <th>Data limită</th>
                <th>Termeni de site</th>
                <th>Termeni de atelier</th>
                <th>Contract de voluntariat</th>
                <th>Status</th>
                <th>Acțiuni</th>
            </tr>
            @php($i = 0)
            @foreach ($eventLocations as $location)
                <tr>
                    <td>{{ $location->name }}</td>
                    <td>{{ $location->email }}</td>
                    <td>{{ $location->eventLocation->name }}</td>
                    <td>{{ $location->due_date }}</td>
                    <td>{{ $location->terms_site ? 'Da' : 'Nu' }}</td>
                    <td>{{ $location->terms_workshop ? 'Da' : 'Nu' }}</td>
                    <td>{{ $location->volunteering_contract ? 'Da' : 'Nu' }}</td>
                    <td>{{ ucfirst($location->status) }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-success">Aprobă</button>
                            <button type="button" class="btn btn-sm btn-danger">Respinge</button>
                            <button type="button" class="btn btn-sm btn-primary">Editează</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $eventLocations->withQueryString()->links('pagination::bootstrap-5') !!}

    </div>

@endsection

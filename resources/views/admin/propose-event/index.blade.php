@extends('layouts.app')

@section('content')
{{--<h4>Aici  trebuie facut un quiue car sa verifice datele si cand se termina evenimentele sa seteze statusul cu inactiv</h4>--}}
{{--<h4>mai trebuie adaugat la status inca o conditie sa fie acceptat/refuzat/pending/efectut</h4>--}}
{{--<h4>adaugarea butoanelor care schimba statusul</h4>--}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Lista locațiilor evenimentelor</h2>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Nume</th>
                    <th>Email</th>
                    <th>Eveniment</th>
                    <th>Data limită</th>
                    <th>Termeni de site</th>
                    <th>Termeni de atelier</th>
                    <th>Contract de voluntariat</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($eventLocations as $location)
                    <tr>
                        <td>{{ $location->name }}</td>
                        <td>{{ $location->email }}</td>
                        <td>{{ $location->eventLocation->name }}</td>
                        <td>{{ $location->due_date }}</td>
                        <td>{{ $location->terms_site ? 'Da' : 'Nu' }}</td>
                        <td>{{ $location->terms_workshop ? 'Da' : 'Nu' }}</td>
                        <td>{{ $location->volunteering_contract ? 'Da' : 'Nu' }}</td>
                        <td>{{ ucfirst($location->status) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

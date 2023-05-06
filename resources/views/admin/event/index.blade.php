@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="text-center mb-5">
            <h1>Evenimente</h1>
        </div>
        <div class="row">
            <div class="col-lg-18 margin-tb mb-5">
                <div class="pull-right mb-5">
                    <a class="btn btn-default butts fs-5" href="{{ route('event-locations.create') }}"> Creaza o locatie noua</a>
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
                <th>Relief</th>
                <th>Longitudine</th>
                <th>Latitudine</th>
                <th width="170px">Action</th>
            </tr>
            @php($i = 0)
            @foreach ($events as $event)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $event->relief_type }}</td>
                    <td>{{ $event->longitude }}</td>
                    <td>{{ $event->latitude }}</td>
                    <td>
                        <form action="{{ route('event-locations.destroy',$event->id) }}" method="POST">
                            <a class="btn btn-default buttons" href="{{ route('event-locations.edit',$event->id) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger buttons">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $events->withQueryString()->links('pagination::bootstrap-5') !!}

    </div>

@endsection

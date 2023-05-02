@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Locuri pentru evenimente</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('event-locations.create') }}"> Create New Product</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Relief</th>
            <th>Long</th>
            <th>Lat</th>
            <th width="280px">Action</th>
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

{{--                        <a class="btn btn-info" href="{{ route('event-locations.show',$event->id) }}">Show</a>--}}

                        <a class="btn btn-primary" href="{{ route('event-locations.edit',$event->id) }}">Edit</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    </div>
{{--asta este pentru paginate--}}
{{--    {!! $events->links() !!}--}}
@endsection


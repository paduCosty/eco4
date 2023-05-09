@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb mb-4">
                <div class="text-center mb-2">
                    <h2>Editeaza eveniment</h2>
                </div>
                <div class="pull-right mb-3">
                    <a class="btn btn-default butts fs-5" href="{{ route('event-locations.index') }}"> Back</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('propose-locations.update', $userEventLocation->id) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label for="name" class="col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text"
                               class="form-control @error('name') is-invalid @enderror" name="name"
                               value="{{ $userEventLocation->name }}" required autocomplete="name"
                               autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email"
                           class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror" name="email"
                               value="{{ $userEventLocation->email }}" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="due_date"
                           class="col-form-label text-md-right">{{ __('Due Date') }}</label>

                    <div class="col-md-6">
                        <input id="due_date" type="date"
                               class="form-control @error('due_date') is-invalid @enderror" name="due_date"
                               value="{{ $userEventLocation->due_date }}" required>

                        @error('due_date')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status"
                           class="col-form-label text-md-right">{{ __('Status') }}</label>

                    <div class="col-md-6">
                        <select id="status" class="form-control @error('status') is-invalid @enderror"
                                name="status" required>
                            <option value="in asteptare"
                                    @if($userEventLocation->status == 'in asteptare') selected @endif>In
                                asteptare
                            </option>
                            <option value="aprobat"
                                    @if($userEventLocation->status == 'aprobat') selected @endif>Aprobat
                            </option>
                            <option value="refuzat"
                                    @if($userEventLocation->status == 'refuzat') selected @endif>Refuzat
                            </option>
                            <option value="in desfasurare"
                                    @if($userEventLocation->status == 'in desfasurare') selected @endif>
                                In desfasurare
                            </option>
                            <option value="desfasurat"
                                    @if($userEventLocation->status == 'desfasurat') selected @endif>
                                Desfasurat
                            </option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-default butts fs-5"> Send</button>

            </form>
        </div>
    </div>
@endsection

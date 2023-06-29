@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Telefon') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text"
                                           class="form-control @error('phone') is-invalid @enderror" name="phone"
                                           value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="address"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Adresa') }}</label>

                                <div class="col-md-6">
                                    <input id="address" type="text"
                                           class="form-control @error('address') is-invalid @enderror" name="address"
                                           value="{{ old('address') }}" required autocomplete="address" autofocus>

                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="data"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Data Nasterii') }}</label>

                                <div class="col-md-6">
                                    <input id="data" type="date"
                                           class="form-control @error('data') is-invalid @enderror" name="data"
                                           value="{{ old('data') }}" required autocomplete="data" autofocus>

                                    @error('data')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="country"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Tara') }}</label>

                                <div class="col-md-6">
                                    <input id="country" type="text"
                                           class="form-control @error('country') is-invalid @enderror" name="country"
                                           value="{{ old('country') }}" required autocomplete="country" autofocus>

                                    @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="city" class="col-md-4 col-form-label text-md-end">{{ __('City') }}</label>

                                <div class="col-md-6">
                                    <input id="city" type="text"
                                           class="form-control @error('city') is-invalid @enderror" name="city"
                                           value="{{ old('city') }}" required autocomplete="ity" autofocus>

                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="gender"
                                       class="col-md-4 col-form-label text-md-end">Gen:</label>
                                <div class="col-md-6">

                                    <select name="gender"
                                            class="form-control" required>
                                        <option value="">Selecteaza</option>

                                        <option value="M">Masculin</option>
                                        <option value="F">Feminin</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="form-submit">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

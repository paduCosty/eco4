@extends('layouts.app')

@section('content')
    <x-guest-layout>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Reset Password') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('password.store') }}">
                                @csrf

                                <!-- Password Reset Token -->
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <!-- Email Address -->

                                <div class="row mb-3">
                                    <x-input-label class="col-md-4 col-form-label text-md-end" for="email"
                                                   :value="__('Email')"/>
                                    <div class="col-md-6">
                                        <x-text-input id="email"
                                                      class="form-control @error('email') is-invalid @enderror"
                                                      type="email" name="email" :value="old('email', $request->email)"
                                                      required autofocus autocomplete="username"/>
                                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                                    </div>

                                </div>

                                <!-- Password -->
                                <div class="row mb-3">
                                    <x-input-label class="col-md-4 col-form-label text-md-end" for="password"
                                                   :value="__('Password')"/>

                                    <div class="col-md-6">
                                        <x-text-input id="password"
                                                      class="form-control @error('password') is-invalid @enderror"
                                                      type="password" name="password" required
                                                      autocomplete="new-password"/>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                                    </div>

                                </div>

                                <!-- Confirm Password -->
                                <div class="row mb-3">
                                    <x-input-label class="col-md-4 col-form-label text-md-end"
                                                   for="password_confirmation" :value="__('Confirm Password')"/>
                                    <div class="col-md-6">
                                        <x-text-input id="password_confirmation" class="form-control" type="password"
                                                      name="password_confirmation" required
                                                      autocomplete="new-password"/>
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                                    </div>

                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit"
                                                class="btn btn-primary">{{ __('Reset Password') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-guest-layout>

@endsection

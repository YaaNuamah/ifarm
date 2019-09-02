@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Farm') }}</div>

                <div class="card-body">
                    <form method="POST" action="/farms">
                        @csrf

                        <div class="form-group row">
                            <label for="crop" class="col-md-4 col-form-label text-md-right">{{ __('Crop') }}</label>

                            <div class="col-md-6">
                                <input id="crop" type="text" class="form-control @error('crop') is-invalid @enderror" name="crop" value="{{ old('crop') }}" required  autofocus>

                                @error('crop')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gps" class="col-md-4 col-form-label text-md-right">{{ __('Farm GhanaPOST GPS') }}</label>

                            <div class="col-md-6">
                                <input id="gps" type="text" class="form-control @error('gps') is-invalid @enderror" name="gps" value="{{ old('gps') }}" required  autofocus>

                                @error('gps')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="size" class="col-md-4 col-form-label text-md-right">{{ __('Number of Acres') }}</label>

                            <div class="col-md-6">
                                <input id="size" type="number" class="form-control @error('size') is-invalid @enderror" name="size" value="{{ old('size') }}" required  autofocus>

                                @error('size')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date_started" class="col-md-4 col-form-label text-md-right">{{ __('Date Started') }}</label>

                            <div class="col-md-6">
                                <input id="date_started" type="date" class="form-control @error('date_started') is-invalid @enderror" name="date_started" value="{{ old('date_started') }}" required>
                                <input type="hidden" name="farmer_id" value="{{ Auth::user()->id }}">

                                @error('date_started')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add Farm') }}
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

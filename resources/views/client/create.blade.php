@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- notifications --}}
            @if (Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif

            @if (Session::get('warning'))
                <div class="alert alert-warning" role="alert">
                    {{ Session::get('warning') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">{{ __('Formulaire de création de client') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('clients.store') }}" autocomplete="off">
                        @csrf

                        <div class="form-group row">
                            <label for="sigle" class="col-md-4 col-form-label text-md-right">{{ __('Raison sociale') }}</label>

                            <div class="col-md-6">
                                <input id="sigle" type="text" class="form-control @error('raison_sociale') is-invalid @enderror" name="raison_sociale" value="{{ old('raison_sociale') }}" required autocomplete="raison_sociale" placeholder="Raison sociale" autofocus>

                                @error('raison_sociale')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sigle" class="col-md-4 col-form-label text-md-right">{{ __('Sigle') }}</label>

                            <div class="col-md-6">
                                <input id="sigle" type="text" class="form-control @error('sigle') is-invalid @enderror" name="sigle" value="{{ old('sigle') }}" autocomplete="sigle" placeholder="Sigle" autofocus>

                                @error('sigle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contact" class="col-md-4 col-form-label text-md-right">{{ __('Contact') }}</label>

                            <div class="col-md-6">
                                <input id="contact" type="tel" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" required autocomplete="contact" placeholder="Contact" autofocus>

                                @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Enregistrer') }}
                                </button>
                                <a href="{{ Route('clients.index') }}" class="btn btn-danger">Retour</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

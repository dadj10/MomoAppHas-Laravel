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
                <div class="card-header">{{ __('Formulaire de création de ressource') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ressource.store') }}" autocomplete="off">
                        @csrf

                        <div class="form-group row">
                            <label for="client_id" class="col-md-3 col-form-label text-md-right">{{ __('Client') }}</label>

                            <div class="col-md-7">
                                <select class="form-control @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required autofocus>
                                    <option value="">[Clients]</option>
                                    @foreach ($clients as $item)
                                        <option value="{{ $item->id }}">{{ Str::ucfirst($item->raison_sociale) }}</option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Libellé') }}</label>

                            <div class="col-md-7">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Libellé" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-3 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-7">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" placeholder="Description" autofocus cols="30" rows="2"></textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="detail" class="col-md-3 col-form-label text-md-right">{{ __('Details') }}</label>

                            <div class="col-md-7">
                                <textarea id="detail" class="form-control @error('detail') is-invalid @enderror" name="detail" autocomplete="detail" placeholder="Details" autofocus cols="30" rows="5"></textarea>

                                @error('detail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-3">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Enregistrer') }}
                                </button>
                                <a href="{{ Route('ressource.index') }}" class="btn btn-danger">Retour</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

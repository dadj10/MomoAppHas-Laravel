@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header h5">{{ $ressource->name }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p><span class="text-bold h5">Description:</span><br> {{ $ressource->description }}</p>
                    <p><span class="text-bold h5">Détails:</span><br> {{ $ressource->detail }}</p>

                    <hr>
                    <label for="destinataires" class="col-form-label text-md-right">{{ __('Veuillez séparer les destinataires par (;)') }}</label>

                    <form method="POST" action="{{ route('ressource.store') }}" autocomplete="off">
                        @csrf

                        <input id="id" type="hidden" name="id" value="{{ $ressource->id }}" required autofocus readonly>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <textarea class="form-control @error('destinataires') is-invalid @enderror" name="destinataires" id="destinataires" cols="30" rows="2" required autocomplete="destinataires" placeholder="Destinataires" autofocus></textarea>

                                    @error('destinataires')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="button" class="btn btn-success" id="btnenvoyer">
                                        {{ __('Envoyer') }}
                                    </button>
                                    <a href="{{ Route('ressource.index') }}" class="btn btn-danger" id="btnretour">Retour</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('set_js')
<script src="{{ asset('js/jquery/jquery-3.5.1.js') }}"></script>

<script>
    $(document).ready(function() {
        /* soumission du formulaire pour traitement */
        $("#btnenvoyer").click(function(e){
            e.preventDefault();

            $("#btnenvoyer").attr("disabled", true);
            $("#destinataires").attr("disabled", true);

            var id = $("#id").val();
            var destinataires = $("#destinataires").val();

            console.log(id);
            console.log(destinataires);

            $.ajax({
                url: 'sendmail',
                type:'POST', dataType: 'json',
                data: {
                    "id": id,
                    "destinataires": destinataires
                },

                success: function(json) {
                    console.log(json);
                },
                error : function(data, status, er) {
                    console.log(data);
                    console.log(status);
                    console.log(er);
                }
            });
        });
    });
</script>
@endsection

@extends('layouts.app')

@section('set_css')
<link href="{{ asset('css/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

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
                <div class="card-header">
                    {{ __('Liste des ressources') }}
                    <a href="{{ Route('ressource.create') }}" class="btn btn-success btn-sm float-right">Créer une ressource</a></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table reponsive-table" id="mydatatable">
                        <thead class="thead-light text-nowrap">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Libellé</th>
                                <th scope="col">Description</th>
                                <th scope="col">Client</th>
                                <th scope="col">Créer par</th>
                                <th scope="col">Date modification</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ressources as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->client->raison_sociale }}</td>
                                    <td><span>@</span>{{ $item->creer_par }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <a href="{{ Route('ressource.show', $item->id) }}" class="btn btn-secondary btn-sm">Détails</a>
                                        <a href="{{ Route('ressource.edit', $item->id) }}" class="btn btn-primary btn-sm">Modifier</a>

                                        @if ($item->etat == 1)
                                            <a href="{{ Route('ressource.etat', $item->id) }}" class="btn btn-warning btn-sm">Desactiver</a>
                                        @else
                                            <a href="{{ Route('ressource.etat', $item->id) }}" class="btn btn-success btn-sm">Activer</a>
                                        @endif

                                        <form action="{{ Route('ressource.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('set_js')
{{-- <script src="{{ asset('js/jquery/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#mydatatable').DataTable();
    });
</script>
@endsection

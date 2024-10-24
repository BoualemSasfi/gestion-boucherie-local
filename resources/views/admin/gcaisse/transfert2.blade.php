@extends('layouts.admin')
@section('content')

{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row">
        <div class="col-2 d-flex align-items-center">
            <a href="{{ url('/admin/caisse') }}" class="btn btn-dark">
                <i class="fas fa-arrow-left pr-1"></i>
                <span class="btn-description">Retour</span>
            </a>
        </div>
        <div class="col-10 d-flex align-items-center">
            <h2>Choisissez une caisse</h2>
        </div>
    </div>
</div>

{{-- Formulaire d'ajout d'un vendeur --}}
<div class="container" style="margin-top: 10px;">
    <div class="row animate__animated animate__backInLeft">
        <div class="col-xs-6 col-sm-6 col-md-8 col-lg-6 mx-auto">
            <div class="card shadow m-1">
                <div class="card-body">
                    <div class="row">
                        <div class="text-center form-group col-12">
                            <h3>ID de magasin : {{$lemagasin->id}} </h3>
                            <h3>Nom du magasin : {{$lemagasin->nom}} </h3>
                            <h3>ID de la caisse : {{$lacaisse->id}} </h3>
                        </div>

                        <div class="form-group col-12">
                            <h5 for="magasin_id">Intégrer à une caisse</h5>
                            <select id="magasin" name="id_caisse" class="form-control">
                                <option value="">Sélectionnez une caisse</option>
                                @foreach ($caisses as $caisse)
                                    <option value="{{ $caisse->id }}">
                                        {{ $caisse->code_caisse }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-12">
                            <div class="form-group row justify-content-center text-center">
                                <div class="col-6">
                                    <button type="button" onclick="sauvegarder()" class="btn btn-success p-2">
                                        <i class="fas fa-check fa-lg mr-2"></i>
                                        <span class="btn-description">Suivant</span>
                                    </button>
                                </div>
                                <div class="col-6">
                                    <a class="btn btn-danger p-2" href="{{ url('/home') }}">
                                        <i class="fas fa-times fa-lg mr-2"></i>
                                        <span class="btn-description">Annuler</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script pour la sauvegarde avec SweetAlert --}}
<script>
    function sauvegarder() {
        const selectedCaisseId = document.getElementById('magasin').value; // Récupérer l'ID de la caisse sélectionnée
        const lacaisseId = {{ $lacaisse->id }}; // Récupérer l'ID de la caisse source

        if (!selectedCaisseId) {
            Swal.fire({
                icon: 'warning',
                title: 'Sélectionnez une caisse',
                text: 'Vous devez d\'abord sélectionner une caisse avant de continuer.'
            });
            return; // Sortir si aucune caisse n'est sélectionnée
        }

        Swal.fire({
            title: "Passer à l'étape suivante ?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            cancelButtonColor: "#d33",
            confirmButtonText: "Oui",
            cancelButtonText: "Non"
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirection vers la route avec les deux ID dans l'URL
                window.location.href = `/admin/caisse/letransfert/${lacaisseId}/${selectedCaisseId}`;
            }
        });
    }
</script>

@endsection
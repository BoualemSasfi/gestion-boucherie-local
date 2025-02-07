@extends('layouts.admin')
@section('content')



{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row justify-content-between align-items-center">
        <div class="col-2">
            <a href="{{ url('/admin/caisse') }}" class="btn btn-dark"><i class="fas fa-arrow-left pr-1"></i><span
                    class="btn-description">Retour</span></a>
        </div>

        <div class="col-8  text-center">
            <h2>Ajouter une nouvelle caisse</h2>
        </div>

        <div class="col-2 text-right">

        </div>
    </div>





</div>

{{-- Formulaire d'ajout d'un vendeur --}}
<div class="container" style="margin-top: 10px;">
    <div class="row animate__animated animate__backInLeft">
        <div class="col-xs-6 col-sm-6 col-md-8 col-lg-6 mx-auto">
            <div class="card shadow m-1">
                <form class="edit-form" action="{{ url('/admin/caisse/add/save') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="row">

                            <div class="text-center form-group col-12">
                                <h3>Information de la caisse</h3>
                            </div>


                            <div class="form-group col-6">
                                <h5> Titre </h5>
                                <input type="text" name="code_caisse" class="form-control" placeholder="Titre">
                            </div>

                            <div class="form-group col-6">
                                <label for="magasin_id">Intégrer à un magasin</label>
                                <select id="magasin" name="id_magasin" class="form-control">
                                    <option value="">Sélectionnez un magasin</option>
                                    @foreach ($magasins as $magasin)
                                        <option value="{{ $magasin->id }}">
                                            {{ $magasin->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12">
                                <div class="form-group row justify-content-center text-center">
                                    <div class="col-6">
                                        <button type="button" onclick="sauvegarder(this)" class="btn btn-success p-2">
                                            <i class="fas fa-check fa-lg mr-2"></i><span
                                                class="btn-description">Enregistrer</span>
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <a class="btn btn-danger p-2" href="{{ url('/home') }}">
                                            <i class="fas fa-times fa-lg mr-2"></i><span
                                                class="btn-description">Annuler</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- Script pour la sauvegarde avec SweetAlert --}}
<script>
    function sauvegarder(button) {
        const form = button.closest('.edit-form');

        if (form) {
            Swal.fire({
                title: "Voulez-vous sauvegarder?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui",
                cancelButtonText: "Non"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        } else {
            console.error("Le formulaire n'a pas été trouvé.");
        }
    }
</script>
@endsection
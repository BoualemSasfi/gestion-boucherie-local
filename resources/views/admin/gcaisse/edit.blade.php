@extends('layouts.admin')
@section('content')



{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row">
        <div class="col-2 d-flex align-items-center">
            <a href="{{ url('/admin/caisse') }}" class="btn btn-dark"><i class="fas fa-arrow-left pr-1"></i><span
                    class="btn-description">Retour</span></a>
        </div>
        <div class="col-10 d-flex align-items-center">
            <h2>Modifer  {{$caisse->code_caisse}} de magasin 
           
            @foreach ($magasins as $magasin)                             
                                                @if ($magasin->id == $caisse->id_magasin) 
                                                {{ $magasin->nom }}
                                                @endif
                                                 
                                        @endforeach        
        
        </h2>
        </div>
    </div>
</div>

{{-- Formulaire d'ajout d'un vendeur --}}
<div class="container" style="margin-top: 10px;">
    <div class="row animate__animated animate__backInLeft">
        <div class="col-xs-6 col-sm-6 col-md-8 col-lg-6 mx-auto">
            <div class="card shadow m-1">
                <form class="edit-form" action="{{ url('/admin/caisse/edit/save/' .$caisse->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">

                            <div class="text-center form-group col-12">
                                <h3>Information personnelle</h3>
                            </div>

                            <input type="hidden" name="caisse_id" value=" {{$caisse->id}} " >
                            <div class="form-group col-6">
                                <h5> Titre </h5>
                                <input type="text" value=" {{$caisse->code_caisse}} " name="code_caisse" class="form-control" placeholder="Titre">
                            </div>
                            <div class="form-group col-6">
                                <h5> Solde </h5>
                                <input  oninput="filterNumbers(this)" type="text" value=" {{$caisse->solde}} " name="solde" class="form-control" placeholder="solde" >
                                
                            </div>


                            <script>
                                function filterNumbers(input) {
                                        // Supprimer tous les caractères non numériques
                                        input.value = input.value.replace(/[^0-9]/g, '');
                                }
                            </script>
                            <div class="form-group col-6">
                                    <!-- <label for="magasin_id">Intégrer à un magasin</label> -->
                                    <h5 for="magasin_id"> Intégrer à un magasin </h5>
                                    <select id="magasin" name="id_magasin" class="form-control">
                                        <option value="">Sélectionnez un magasin</option>
                                        @foreach ($magasins as $index => $magasin)
                                            <option value="{{ $magasin->id }}" 
                                                @if ($index == 0 || $magasin->id == $caisse->id_magasin) 
                                                    selected 
                                                @endif>
                                                {{ $magasin->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-6">
    <h5 for="magasin_id">Bouton encaissement</h5>
    <select id="btn_enc" name="btn_encaissier" class="form-control" onchange="updateBackgroundColor()">
        <option value="1" <?php if ($caisse->btn_enc == 1) echo 'selected'; ?>>Afficher</option>
        <option value="0" <?php if ($caisse->btn_enc == 0) echo 'selected'; ?>>Cacher</option>
    </select>
</div>


                                <script>
                                                                        function updateBackgroundColor() {
                                        const selectElement = document.getElementById('btn_enc');

                                        // Modifier la couleur de fond en fonction de la valeur sélectionnée
                                        if (selectElement.value === "1") {
                                            selectElement.style.backgroundColor = "green";
                                        } else if (selectElement.value === "0") {
                                            selectElement.style.backgroundColor = "red";
                                        }
                                    }

                                    // Initialiser la couleur au chargement de la page
                                    document.addEventListener('DOMContentLoaded', () => {
                                        updateBackgroundColor();
                                    });

                                </script>


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
@extends('layouts.admin')
@section('content')
{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row">
        <div class="col-2 d-flex align-items-center">
            <a href="{{ url('/admin/vendeur') }}" class="btn btn-dark"><i class="fas fa-arrow-left pr-1"></i><span
                    class="btn-description">Retour</span></a>
        </div>
        <div class="col-10 d-flex align-items-center">
            <h2>Modifier les information de vendeur {{$vendeur->nom}} {{$vendeur->prenom}} </h2>
        </div>
    </div>
</div>

{{-- Formulaire d'ajout d'un vendeur --}}
<div class="container" style="margin-top: 10px;">
    <div class="row animate__animated animate__backInLeft">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-12 mx-auto">
            <div class="card shadow m-1">
                <form class="edit-form" action="{{ url('/admin/vendeur/add/save') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="text-center form-group col-12">
                                <h3>Information personnelle  </h3>
                            </div>

                            <div class="form-group col-6">
                                <h5> N° pièce identité </h5>
                                <input type="number" name="n_p" class="form-control" value="{{$vendeur->id_p}}" placeholder="numéro pièce identité">
                            </div>

                            <div class="form-group col-6">
                                <h5> N° Tel </h5>
                                <input type="number" name="tel" class="form-control" value="{{$vendeur->tel}}" placeholder="Numéro de téléphone">
                            </div>

                            <div class="form-group col-6">
                                <h5> Nom </h5>
                                <input type="text" name="nom" class="form-control" value="{{$vendeur->nom}}"  placeholder="nom">
                            </div>
                            <div class="form-group col-6">
                                <h5> Prénom </h5>
                                <input type="text" name="prenom" class="form-control" value="{{$vendeur->prenom}}"  placeholder="prénom">
                            </div>

                            <div class="form-group col-12">
                                <h5> Détails </h5>
                                <input type="text" name="details" class="form-control"  value="{{$vendeur->details}}" placeholder="Détails">
                            </div>
                        </div>
                    </div>

                    <div class="card shadow m-1 pt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="text-center form-group col-12">
                                    <h3>Information application  </h3>
                                </div>


                                <input type="hidden" name="user_id" value=" {{$user_id}} " >


                                <div class="form-group col-6">
                                    <h5> Username </h5>
                                    <input type="text" name="user_name" class="form-control"  value="{{$utilisateur->name}}"  placeholder="username">
                                </div>

                                <div class="form-group col-6">
                                    <h5> password </h5>
                                    <input type="password" name="password" class="form-control" value="{{$vendeur->password}}"  placeholder="mot de passe">
                                </div>
          

                                <div class="form-group col-6">
                                    <label for="magasin_id">Intégrer à un magasin</label>
                                    <select id="category" name="magasin_id" class="form-control">
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
                                                <i class="fas fa-check fa-lg mr-2"></i><span class="btn-description">Enregistrer</span>
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <a class="btn btn-danger p-2" href="{{ url('/home') }}">
                                                <i class="fas fa-times fa-lg mr-2"></i><span class="btn-description">Annuler</span>
                                            </a>
                                        </div>
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

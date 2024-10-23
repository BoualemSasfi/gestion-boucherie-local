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
            <h2>Modifer la caisse {{$caisse->code_caisse}} qui ce trouve don le magasin 
           
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
@extends('layouts.admin')
@section('content')
{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row justify-content-between align-items-center">
        <div class="col-2 ">
            <a href="{{ url('/admin/client') }}" class="btn btn-dark"><i class="fas fa-arrow-left pr-1"></i><span
                    class="btn-description">Retour</span></a>
        </div>
        <div class="col-8 text-center">
            <h2>Ajouter un nouveau client</h2>
        </div>
        <div class="col-2 text-right">

        </div>

    </div>
</div>

{{--
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--}}


<div class="container" style="margin-top: 10px;">
    <div class="row animate__animated animate__backInLeft">



        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mx-auto">
            <div class="card shadow m-1">
                <form class="edit-form" action="{{ url('/admin/client/add/save') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">

                        <div class="row">
                            <div class="col-6">
                                <h5 class="text-center"> Nom & Prenom </h5>
                                <input type="text" name="nom_prenom" class="form-control"
                                    placeholder="nom & prenom "></input>
                                <h5 class="text-center"> N° Tel </h5>
                                <input type="number" name="fix" class="form-control"
                                    placeholder="Numéro de telephone "></input>
                                <h5 class="text-center"> Adresse </h5>
                                <input type="text" name="adresse" class="form-control" placeholder="Adresse"></input>
                            </div>

                            <div class="col-6">
                                <h5 class="text-center"> NRC </h5>
                                <input type="text" name="n_rc" class="form-control"
                                    placeholder="Numéro de Registre de comerce"></input>
                                <h5 class="text-center"> NIF </h5>
                                <input type="number" name="NIF" class="form-control"
                                    placeholder="Numéro d'identification fiscal "></input>
                                <h5 class="text-center"> NIS</h5>
                                <input type="number" name="NIS" class="form-control"
                                    placeholder="Numéro d'identification statistique"></input>
                            </div>
                            <div class="col-12">
                                <h5 class="text-center"> Details </h5>
                                <input type="text" name="details" class="form-control" placeholder="Details "></input>
                            </div>




                        </div>
                        <br>
                        <div class="form-group col-12">
                            <div class="form-group row justify-content-center text-center">
                                <div class="col-6">
                                    <button type="button" onclick="sauvegarder(this)" class="btn btn-success p-2"><i
                                            class="fas fa-check fa-lg mr-2"></i><span
                                            class="btn-description">Enregistrer</span></button>
                                </div>
                                <div class="col-6">
                                    <a class="btn btn-danger p-2" href="{{ '/admin/client' }}"><i
                                            class="fas fa-times fa-lg mr-2"></i><span
                                            class="btn-description">Annuler</span></a>
                                </div>
                            </div>
                        </div>

                    </div>
            </div>
            </form>
        </div>

        <!-- fin -->
    </div>
</div>





{{-- script sauvegarder --}}
<script>
    function sauvegarder(button) {
        // Utilisez le bouton pour obtenir le formulaire parent
        const form = button.closest('.edit-form');

        // Vérifiez si le formulaire a été trouvé
        if (form) {

            Swal.fire({
                title: "Voulez- vous sauvegarder le client .. ? ",
                // text: name,
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui",
                cancelButtonText: "Non",
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
<!-- fin -->
@endsection
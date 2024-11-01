@extends('layouts.admin')
@section('content')
{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row">
        <div class="col-2 d-flex align-items-center">
            <a href="{{ url('/admin/client') }}" class="btn btn-dark"><i class="fas fa-arrow-left pr-1"></i><span
                    class="btn-description">Retour</span></a>
        </div>
        <div class="col-10 d-flex align-items-center">
            <h2  >modifier le client {{$client->nom_prenom}}</h2>
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
                <form class="edit-form" action="{{ url('/admin/client/edit/save/'.$client->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                 


                        <div class="form-group col-12">
                        <h5 class="text-center"> Nom & Prenom  </h5>
                            <input type="text" name="nom_prenom" class="form-control" placeholder="nom & prenom " value="{{$client->nom_prenom}}" ></input>
                        </div>

                        <div class="form-group col-12">
                        <h5 class="text-center"> N° Tel  </h5>
                            <input type="text" name="fix" class="form-control" placeholder="Numéro de telephone " value="{{$client->fix}}" ></input>
                        </div>

                        <div class="form-group col-12">
                        <h5 class="text-center"> Details </h5>
                            <input type="text" name="details" class="form-control" placeholder="Details " value=" {{$client->details}} " ></input>
                        </div>




                        <div class="form-group col-12">
                            <div class="form-group row justify-content-center text-center">
                                <div class="col-6">
                                    <button type="button" onclick="sauvegarder(this)" class="btn btn-success p-2"><i
                                            class="fas fa-check fa-lg mr-2"></i><span
                                            class="btn-description">Modifier</span></button>
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
                title: "Voulez- vous sauvegarder les modification  .. ? ",
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
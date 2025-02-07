@extends('layouts.admin')
@section('content')
{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row">
        <div class="col-2 d-flex align-items-center">
            <a href="{{ url('/admin/category/'.$categorys->id.'/edit') }}" class="btn btn-dark"><i class="fas fa-arrow-left pr-1"></i><span
                    class="btn-description">Retour</span></a>
        </div>

        
        <div class="col-10 d-flex align-items-center">
            <h2>Ajouter un nouveau produit</h2>
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
                <form class="edit-form" action="{{ url('/admin/produit/add/save') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">

                        <input type="file" name="photo_pr" id="validationLogoCouleurs" accept="image/*"
                            style="display: none;" onchange="previewImage2();">


                        <div class="form-group col-12">
                            <img class="card-img-top" src="{{ asset('img/logo_vide/add_image.PNG') }}" alt=""
                                id="preview2" onclick="triggerFileInput();" style="height: 280px;">
                        </div>


                        <div class="form-group row">
                            <div class="col-6" >

                                <label for="">Titre :</label>
                                <input type="text" name="nom_pr" class="form-control" placeholder="Nom de produit"></input>
                            </div>
                            <div class="col-6" >

                                <label for="">Ordre :</label>
                                <input type="number" name="nombre" class="form-control" placeholder="Ordre d'affichage "></input>
                            </div>
                        </div>
                        <div class="row ">

                            <div class="form-group col-6">
                                <form>
                                    <div class="form-group">
                                        <label for="">Type de Viande :</label>
                                        <select id="category" name="category_id" class="form-control">
                                            <option value="{{ $categorys->id }}">{{ $categorys->nom }}</option>

                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="form-group col-6">
                                <label for="">Unité de mesure :</label>
                                <select name="unite_mesure" class="form-control">
                                    <option value="">Sélectionnez une Unité de mesure</option>

                                    <option value="Kg">Kg</option>
                                    <option value="piece">pièce</option>

                                </select>
                            </div>
                        </div>
                        <h3 class="text-center"> Prix Acaht : </h3>
                        <div class="form-group col-12">

                            <input type="number" name="prix_achat" class="form-control" placeholder="Prix achat"
                                step="0.01" min="0">
                        </div>


                        <h3 class="text-center"> Prix de vente : </h3>

                        <div class="form-group col-12">
                            <label for="">Détail :</label>
                            <input type="number" name="prix_vente" class="form-control" placeholder="Prix détail"
                                step="0.01" min="0">
                        </div>

                        <div class="form-group col-12">
                            <label for="">Semi gros :</label>
                            <input type="number" name="semi_gros" class="form-control" placeholder="Prix Semi gros "
                                step="0.01" min="0"></input>
                        </div>

                        <div class="form-group col-12">
                            <label for="">Gros :</label>
                            <input type="number" name="gros" class="form-control" placeholder="Prix Gros" step="0.01"
                                min="0"></input>
                        </div>

                        <div class="form-group col-12">
                            <div class="form-group row justify-content-center text-center">
                                <div class="col-6">
                                    <button type="button" onclick="sauvegarder(this)" class="btn btn-success p-2"><i
                                            class="fas fa-check fa-lg mr-2"></i><span
                                            class="btn-description">Enregistrer</span></button>
                                </div>
                                <div class="col-6">
                                    <a class="btn btn-danger p-2" href="{{ '/admin/category/'.$categorys->id.'/edit' }}"><i
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



<!-- pour affiche la photo   -->
<script>
    function previewImage2() {
        var file = document.getElementById("validationLogoCouleurs").files;
        if (file.length > 0) {
            var fileReader = new FileReader();

            fileReader.onload = function (event) {
                document.getElementById("preview2").setAttribute("src", event.target.result)
            };
            fileReader.readAsDataURL(file[0]);
        }
    };

    function triggerFileInput() {
        document.getElementById("validationLogoCouleurs").click();
    };
</script>
<!-- fin  -->

{{-- script sauvegarder --}}
<script>
    function sauvegarder(button) {
        // Utilisez le bouton pour obtenir le formulaire parent
        const form = button.closest('.edit-form');

        // Vérifiez si le formulaire a été trouvé
        if (form) {

            Swal.fire({
                title: "Voulez- vous sauvegarder ce produit .. ? ",
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
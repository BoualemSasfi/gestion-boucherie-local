@extends('layouts.admin')
@section('content')
{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row justify-content-between align-items-center">
        <div class="col-2">
            <a href="{{ url('/admin/category') }}" class="btn btn-dark"><i class="fas fa-arrow-left pr-1"></i><span
                    class="btn-description">Retour</span></a>
        </div>
        <div class="col-8 text-center">
            <h2>Ajouter une nouvelle categorie de viande</h2>
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

        <div class="col-12">
            <div class="card  shadow m-1">
                <form class="edit-form" action="{{ url('/admin/category/add/save') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">

                        <div class="row">
                            <div class="col-4">
                                <label for="">Titre :</label>
                                <input type="text" name="nom" class="form-control"
                                    placeholder="Titre de catégorie"></input>

<br>
                                <div class="form-group col-12">
                                    <div class="row justify-content-center text-center">
                                        <div class="col-6">
                                            <button type="button" onclick="sauvegarder(this)"
                                                class="btn btn-success p-2">
                                                <i class="fas fa-check fa-lg mr-2"></i>
                                                <span class="btn-description">Enregistrer</span></button>
                                        </div>
                                        <div class="col-6">
                                            <a class="btn btn-danger p-2" href="{{ url('/admin/category') }}">
                                                <i class="fas fa-times fa-lg mr-2"></i>
                                                <span class="btn-description">Annuler</span></a>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-8">
                                <input type="file" name="photo" id="validationLogoCouleurs" accept="image/*"
                                    style="display: none;" onchange="previewImage2();">



                                <div class="form-group ">
                                    <img class="card-img-top" src="{{ asset('img/logo_vide/add_image.PNG') }}" alt=""
                                        id="preview2" onclick="triggerFileInput();" style="height: 500px;">
                                </div>

                            </div>



                        </div>
                    </div>
            </div>
        </div>
        </form>
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
                title: "Voulez- vous sauvegarder les modifications ? ",
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


@endsection
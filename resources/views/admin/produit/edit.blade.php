@extends('layouts.admin')
@section('content')
{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row">
        <div class="col-2 d-flex align-items-center">
            <a href="{{ url('/admin/produit') }}" class="btn btn-dark"><i class="fas fa-arrow-left pr-1"></i><span
                    class="btn-description">Retour</span></a>
        </div>
        <div class="col-10 d-flex align-items-center">
            <h2>Modifier le produit</h2>
        </div>

    </div>
</div>

{{--
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--}}
<div class="container" style="margin-top: 10px;">
    <div class="row animate__animated animate__backInLeft">



        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mx-auto">
            <div class="card shadow m-1">

                <form class="edit-form" action="{{ url('/admin/produit/' . $produit->id . '/update') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="row">

                            <input type="file" name="photo_pr" id="validationLogoCouleurs" accept="image/*"
                                style="display: none;" onchange="previewImage2();">


                            @if (!empty($produit->photo_pr) && Storage::exists('public/' . $produit->photo_pr))
                                <div class="form-group col-12">
                                    <img src="{{ asset('storage/' . $produit->photo_pr) }}" class="card-img-top" alt=""
                                        id="preview2" onclick="triggerFileInput();" style="height: 280px;">
                                </div>
                            @else
                                <div class="form-group col-12">
                                    <img src="{{ asset('img/logo_vide/add_image.PNG') }}" class="card-img-top" alt=""
                                        id="preview2" onclick="triggerFileInput();" style="height: 280px;">
                                </div>
                            @endif



                            <div class="form-group col-12">
                                <label for="">Titre :</label>
                                <input type="text" name="nom_pr" class="form-control" placeholder="nom de produit"
                                    value="{{ $produit->nom_pr }}"></input>
                            </div>



                            <div class="form-group col-12">
                                <form>
                                    <div class="form-group">
                                        <label for="">Viande :</label>
                                        <select id="category" name="category_id" class="form-control">
                                            <option value="">Sélectionnez une catégorie</option>
                                            @foreach ($categorys as $category)
                                                <!-- Ajouter une classe conditionnelle pour la première option -->
                                                <option value="{{ $category->id }}"
                                                    style="{{ $category->id == $defaultCategoryId ? 'color: red;' : '' }}"
                                                    {{ $category->id == $defaultCategoryId ? 'selected' : '' }}>
                                                    {{ $category->nom }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>




                            <div class="form-group col-12">
                                <h2 class="text-center" >  Prix de vente : </h2>
                                <label for="">détail :</label>
                                <input type="text" name="prix_vent" class="form-control" placeholder="Prix de vent"
                                    value="{{ $produit->prix_vent }}"></input>

                                    <label for="">Semi gros :</label>
                                <input type="text" name="semi_gros" class="form-control" placeholder="Prix de semi gors"
                                    value="{{ $produit->semi_gros}}"></input>

                                    <label for="">Gros :</label>
                                <input type="text" name="gros" class="form-control" placeholder="Prix de gros"
                                    value="{{ $produit->gros }}"></input>
                            </div>

                            <div class="form-group col-12">

                                <div class="row justify-content-center text-center">
                                    <div class="col-6">
                                        <button type="button" onclick="sauvegarder(this)" class="btn btn-success p-2"><i
                                                class="fas fa-check fa-lg mr-2"></i><span
                                                class="btn-description">Modifier</span></button>
                                    </div>
                                    <div class="col-6">
                                        <a class="btn btn-danger p-2" href="{{ url('/admin/produit') }}"><i
                                                class="fas fa-times fa-lg mr-2"></i><span
                                                class="btn-description">Annuler</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                <!-- fin -->
            </div>
        </div>
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
<!-- fin -->
@endsection
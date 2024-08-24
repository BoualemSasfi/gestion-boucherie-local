@extends('layouts.admin')
@section('content')
<div class="container" id="titre-page">
    <div class="row">
        <!-- <div class="col-2 d-flex align-items-center">
            <a href="{{ url('/admin/produit') }}" class="btn btn-dark"><i class="bi bi-house"></i><span
                    class="btn-description">Retoure</span></a>
        </div> -->
        <div class="col-12 text-center">
            <h2>Modifier un produit</h2>
        </div>
    </div>

    <div class="row justify-content-center mt-4">


        <form class="edit-form" action="{{ url('/admin/produit/' . $produit->id . '/update') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="col-m-3 col12 m-2">
                <div class="card" style="width: 18rem;">

                    <input type="file" name="photo_pr" id="validationLogoCouleurs" accept="image/*"
                        style="display: none;" onchange="previewImage2();">



                    @if(!empty($produit->photo_pr) && Storage::exists('public/' . $produit->photo_pr))
                        <img src="{{ asset('storage/' . $produit->photo_pr) }}" class="card-img-top" alt="" id="preview2"
                            onclick="triggerFileInput();">
                    @else
                        <img src="{{ asset('img/logo_vide/add_image.PNG') }}" class="card-img-top" alt="" id="preview2"
                            onclick="triggerFileInput();">
                    @endif 



                    <div class="card-body">
                        <input type="text" name="nom_pr" class="form-control" placeholder="nom de produit"
                            value="{{$produit->nom_pr}}"></input>
                    </div>



                    <div class="card-body">
    <form>
        <div class="form-group">
            <select id="category" name="category_id" class="form-control">
                <option value="">Sélectionnez une catégorie</option>
                @foreach ($categorys as $category)
                    <!-- Ajouter une classe conditionnelle pour la première option -->
                    <option 
                        value="{{ $category->id }}" 
                        style="{{ $category->id == $defaultCategoryId ? 'color: red;' : '' }}" 
                        {{ $category->id == $defaultCategoryId ? 'selected' : '' }}
                    >
                        {{ $category->nom }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
</div>




                    <div class="card-body">
                        <input type="text" name="prix_vent" class="form-control" placeholder="Prix de vent"
                        value="{{$produit->prix_vent}}"></input>
                    </div>

                    <div class="form-group row justify-content-center text-center">
                        <div class="col-6">
                            <button type="button" onclick="sauvegarder(this)"
                                class="btn btn-outline-success alpa shadow"><i class="bi bi-check2"></i><span
                                    class="btn-description">Modifier</span></button>
                        </div>
                        <div class="col-6">
                            <a class="btn btn-outline-danger alpa shadow" href="{{ '/admin/produit' }}"><i
                                    class="bi bi-x"></i><span class="btn-description">Annuler</span></a>
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
<!-- fin -->
@endsection
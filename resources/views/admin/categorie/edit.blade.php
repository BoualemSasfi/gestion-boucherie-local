@extends('layouts.admin')
@section('content')
<div class="container" id="titre-page">
    <div class="row">
        <!-- <div class="col-2 d-flex align-items-center">
            <a href="{{ url('/admin/category') }}" class="btn btn-dark"><i class="bi bi-house"></i><span
                    class="btn-description">Retoure</span></a>
        </div> -->
        <div class="col-12 text-center">
            <h2>Modifier une Catégorie</h2>
        </div>
    </div>

    <div class="row justify-content-center mt-4">


        <form class="edit-form" action="{{ url('/admin/category/'.$category->id.'/update') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="col-m-3 col12 m-2">
                <div class="card" style="width: 18rem;">

                    <input type="file" name="photo" id="validationLogoCouleurs" accept="image/*" style="display: none;"
                        onchange="previewImage2();">



                    @if(!empty($category->photo) && Storage::exists('public/' . $category->photo))
                        <img src="{{ asset('storage/' . $category->photo) }}" class="card-img-top" alt="" id="preview2"
                            onclick="triggerFileInput();">
                    @else
                        <img src="{{ asset('img/logo_vide/add_image.PNG') }}" class="card-img-top" alt="" id="preview2"
                            onclick="triggerFileInput();">
                    @endif 




                    <div class="card-body">
                        <input type="text" name="nom" class="form-control" placeholder="Titre de catégorie"
                            value="{{$category->nom}}"></input>
                    </div>

                    <div class="form-group row justify-content-center text-center">
                        <div class="col-6">
                            <button type="button" onclick="sauvegarder(this)"
                                class="btn btn-outline-success alpa shadow"><i class="bi bi-check2"></i><span
                                    class="btn-description">Modifier</span></button>
                        </div>
                        <div class="col-6">
                            <a class="btn btn-outline-danger alpa shadow" href="{{ '/admin/category' }}"><i
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
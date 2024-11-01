@extends('layouts.admin')
@section('content')
    {{-- retour en arrière  --}}
    <div class="container" id="titre-page">
        <div class="row justify-content-between align-items-center">
            <div class="col-2">
                <a href="{{ url('/home') }}" class="btn btn-dark"><i class="fas fa-arrow-left pr-1"></i><span
                        class="btn-description">Retour</span></a>
            </div>
            <div class="col-8 text-center">
                <h2>Liste des catégories de viande</h2>
            </div>
            <div class="col-2 text-right">
                <a href="{{ url('/admin/category/add') }}" class="btn btn-success"><i
                        class="fas fa-plus fa-xl pr-1"></i><span class="btn-description">Ajouter</span></a>

            </div>
        </div>

    </div>




    {{-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --}}

    <div class="container" style="margin-top: 10px;">
        <div class="row animate__animated animate__backInLeft">

            @foreach ($categorys as $category)
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="card shadow mb-4">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <img style="height: 250px;" class="card-img-top" src="{{ asset('storage/' . $category->photo) }}"
                                        alt="">
                                </div>
                                <div class="col-12">
                                    <h3 class="text-center">{{ $category->nom }}</h3>
                                </div>
                            </div>



                            <div class="row justify-content-center text-center">

                                <!-- button modifier -->
                                <div class="col-6">
                                    <form class="edit-form" action="" data-id="{{ $category->id }}"
                                        data-name="{{ $category->nom }}" method="put">
                                        @csrf
                                        <button type="button" onclick="edit_confirmation(this)"
                                            class="btn btn-warning p-2"><i
                                                class="fas fa-pen fa-lg mr-2"></i> <span
                                                class="btn-description">Modifier</span></button>
                                    </form>
                                </div>
                                <!-- fin -->

                                <!-- bouton supprimer  -->
                                <div class="col-6">

                                    {{-- delete button --}}
                                    <form class="delete-form" action="" data-id="{{ $category->id }}"
                                        data-name="{{ $category->titre }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="supprimer_confirmation(this)"
                                            class="btn btn-danger p-2"><i class="fas fa-times fa-lg mr-2"></i>
                                            <span class="btn-description">Supprimer</span></button>
                                    </form>

                                </div>
                                <!-- fin -->

                            </div>


                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>


{{-- ---------------------------------------------------  --}}


    {{-- script suppression  --}}
    <script>
        function supprimer_confirmation(button) {
            // Utilisez le bouton pour obtenir le formulaire parent
            const form = button.closest('.delete-form');

            // Vérifiez si le formulaire a été trouvé
            if (form) {
                // Utilisez le formulaire pour extraire l'ID
                const id = form.dataset.id;
                const name = form.dataset.name;

                Swal.fire({
                    title: "Êtes-vous sûr(e) de vouloir supprimer cette catégorie ..?",
                    text: name,
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#198754",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Oui, Supprime-le",
                    cancelButtonText: "Non, Annuler",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mettez à jour l'action du formulaire avec l'ID et soumettez-le
                        form.action = `/admin/category/${id}/delete`;
                        form.submit();

                        Swal.fire({
                            title: "Catégorie supprimée !",
                            icon: "success"
                        });
                    }
                });
            } else {
                console.error("Le formulaire n'a pas été trouvé.");
            }
        }
    </script>



    {{-- script modifier  --}}
    <script>
        function edit_confirmation(button) {
            // Utilisez le bouton pour obtenir le formulaire parent
            const form = button.closest('.edit-form');

            // Vérifiez si le formulaire a été trouvé
            if (form) {
                // Utilisez le formulaire pour extraire l'ID
                const id = form.dataset.id;
                const name = form.dataset.name;

                Swal.fire({
                    title: "Êtes-vous sûr(e) de vouloir modifier cette categorie ..?",
                    text: name,
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#198754",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Oui",
                    cancelButtonText: "Non",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mettez à jour l'action du formulaire avec l'ID et soumettez-le
                        form.action = `/admin/category/${id}/edit`;
                        form.submit();
                    }
                });
            } else {
                console.error("Le formulaire n'a pas été trouvé.");
            }
        }
    </script>



@endsection

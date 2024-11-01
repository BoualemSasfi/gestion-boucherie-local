@extends('layouts.admin')
@section('content')

{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row">
        <div class="col-2 d-flex align-items-center">
            <a href="{{ url('/home') }}" class="btn btn-dark"><i class="fas fa-arrow-left pr-1"></i><span
                    class="btn-description">Retour</span></a>
        </div>
        <div class="col-8 d-flex align-items-center">
            <h2>Liste des produits</h2>
        </div>
        <div class="col-2 d-flex align-items-center">
            <a href="{{ url('/admin/produit/add') }}" class="btn btn-success"><i
                    class="fas fa-plus fa-xl pr-1"></i><span class="btn-description">Ajouter</span></a>

        </div>
    </div>
</div>




{{--
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--}}


<div class="container" style="margin-top: 10px;">
    <div class="row animate__animated animate__backInLeft">

        @foreach ($produits as $produit)
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="card shadow mb-4">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">

                                <h2 class="text-center">{{ $produit->nom_pr }}</h2>
                            </div>
                            <div class="col-12">
                                <img class="card-img-top" src="{{ asset('storage/' . $produit->photo_pr) }}" alt="">
                            </div>
                            <div class="col-12">
                                <h2 class="text-center">les prix de vent </h2>
                                <h3>prix détail : {{ $produit->prix_vent }} DA</h3>
                                <h3>semi_gros :{{ $produit->semi_gros }} DA</h3>
                                <h3>gros : {{ $produit->gros }} DA</h3>
                            </div>
                        </div>



                        <div class="row justify-content-center text-center">

                            <!-- button modifier -->
                            <div class="col-6">
                                <form class="edit-form" action="" data-id="{{ $produit->id }}"
                                    data-name="{{ $produit->nom_pr }}" method="put">
                                    @csrf
                                    <button type="button" onclick="edit_confirmation(this)" class="btn btn-warning p-2"><i
                                            class="fas fa-pen fa-lg mr-2"></i> <span
                                            class="btn-description">Modifier</span></button>
                                </form>
                            </div>
                            <!-- fin -->

                            <!-- bouton supprimer  -->
                            <div class="col-6">

                                {{-- delete button --}}
                                <form class="delete-form" action="" data-id="{{ $produit->id }}"
                                    data-name="{{ $produit->nom_pr }}" method="POST">
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


{{-- --------------------------------------------------- --}}



{{-- script suppression --}}
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
                title: "Êtes-vous sûr(e) de vouloir supprimer ce produit..?",
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
                    form.action = `/admin/produit/${id}/delete`;
                    form.submit();

                    Swal.fire({
                        title: "produit supprimée !",
                        icon: "success"
                    });
                }
            });
        } else {
            console.error("Le formulaire n'a pas été trouvé.");
        }
    }
</script>



{{-- script modifier --}}
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
                title: "Êtes-vous sûr(e) de vouloir modifier ce produit ..?",
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
                    form.action = `/admin/produit/${id}/edit`;
                    form.submit();
                }
            });
        } else {
            console.error("Le formulaire n'a pas été trouvé.");
        }
    }
</script>


<!-- pour afficher le message dialoge apre les funciton de controller  -->
@if(session('success'))
    <script>
        Swal.fire({
            title: 'Succès',
            text: '{{ session('success') }}',
            icon: 'success',
            timer: '2000',
            showConfirmButton: false
        });
    </script>
@endif


@endsection
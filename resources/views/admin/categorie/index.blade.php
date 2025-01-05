@extends('layouts.admin')
@section('content')

{{-- Retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row justify-content-between align-items-center">
        <div class="col-12 col-md-2 mb-2 mb-md-0">
            <a href="{{ url('/admin') }}" class="btn btn-dark w-100"><i class="fas fa-arrow-left pr-1"></i><span
                    class="btn-description">Retour</span></a>
        </div>
        <div class="col-12 col-md-8 text-center">
            <h2>Liste des catégories de viande</h2>
        </div>
        <div class="col-12 col-md-2 text-md-right mb-2 mb-md-0">
            <a href="{{ url('/admin/category/add') }}" class="btn btn-success w-100"><span
                    class="btn-description">Ajouter</span><i class="fas fa-plus fa-xl pr-1"></i></a>
        </div>
    </div>
</div>

{{-- Contenu principal --}}
<div class="container mt-3">
    <div class="d-flex justify-content-center align-items-center flex-wrap">
        <div class="row w-100 animate__animated animate__backInLeft shadow-gray-500">
            <div class="table-responsive">
                <table id="produitsTable" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr class="text-center">
                            <th>Photo</th>
                            <th>Titre</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($categorys as $category)
                            <tr>
                                <!-- Colonne Photo -->
                                <td class="align-middle">
                                    <img src="{{ asset('storage/' . $category->photo) }}" class="img-fluid"
                                        style="height: 80px;" alt="Photo de la catégorie">
                                </td>

                                <!-- Colonne Titre -->
                                <td class="align-middle">{{ $category->nom }}</td>

                                <!-- Colonne Actions -->
                                <td class="align-middle">
                                    <div class="d-flex justify-content-between gap-2 flex-wrap">
                                        <!-- Bouton Modifier -->
                                        <form class="edit-form" action="/admin/category/{{ $category->id }}/edit"
                                            data-id="{{ $category->id }}" method="GET">
                                            @csrf
                                            <button type="button" class="btn btn-link p-0"
                                                onclick="edit_confirmation(this)">
                                                <i class="fa-solid fa-pen fa-xl text-primary"></i>
                                            </button>
                                        </form>

                                        <!-- Bouton Supprimer -->
                                        <form class="delete-form" action="" data-id="{{ $category->id }}"
                                            data-name="{{ $category->titre }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-link p-0"
                                                onclick="supprimer_confirmation(this)">
                                                <i class="fa-solid fa-trash-can fa-xl text-danger"></i>
                                            </button>
                                        </form>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Scripts pour les fonctionnalités --}}
<script>
    $(document).ready(function () {
        $('#produitsTable').DataTable({
            "pageLength": 10,
            "lengthMenu": [[10, 20, 50], [10, 20, 50]],
            "scrollY": "400px",
            "scrollCollapse": true,
            "searching": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
            }
        });
    });

    function supprimer_confirmation(button) {
        const form = button.closest('.delete-form');
        if (form) {
            const id = form.dataset.id;
            const name = form.dataset.name;

            Swal.fire({
                title: "Êtes-vous sûr(e) de vouloir supprimer cette catégorie ?",
                text: name,
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui, Supprime-le",
                cancelButtonText: "Non, Annuler",
            }).then((result) => {
                if (result.isConfirmed) {
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

    function edit_confirmation(button) {
        const form = button.closest('.edit-form');
        if (form) {
            const id = form.dataset.id;

            Swal.fire({
                title: "Êtes-vous sûr(e) de vouloir modifier cette catégorie ?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui",
                cancelButtonText: "Non",
            }).then((result) => {
                if (result.isConfirmed) {
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
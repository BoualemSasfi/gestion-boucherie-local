@extends('layouts.admin')
@section('content')





{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row d-flex justify-content-between align-items-center">
        <div class="col-2">
            <a href="{{ url('/admin') }}" class="btn btn-dark">
                <i class="fas fa-arrow-left pr-1"></i>
                <span class="btn-description"></span>
            </a>
        </div>
        <div class="col-8 text-center">
            <h2>Liste Des Mgasins okok test <i class="fa-solid fa-shop fa-beat fa-xl" style="color: #b42d34;"></i></h2>
        </div>
        <div class="col-2 text-right">
            <a href="{{ url('/admin/magasin/add') }}" class="btn btn-success">
                <i class="fas fa-plus fa-xl pr-1"></i>
                <span class="btn-description"></span>
            </a>
        </div>
    </div>
</div>


<div class="container" style="margin-top: 10px;">

    <div class="row animate__animated animate__backInLeft">

        <div class="card shadow col-12">


            <div class="card-body">


                <div class="card-body">
                    <table id="example" class="table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Nom de magasin</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($magasins as $magasin)
                                <tr>


                                    <td class=" align-middle" style="width:80px;">
                                        <div
                                            style="background-image:url({{ asset('storage/' . $magasin->photo) }});background-size: cover;background-position: center;background-repeat: no-repeat;  height: 80px; width: 70px; margin-left:5px; margin-right:5px;">
                                        </div>
                                    </td>
                                    @if ($magasin->nom == 'Atelier')
                                        <td class=" align-middle" style="color: red;">{{ $magasin->nom}}</td>
                                    @else
                                        <td class=" align-middle">{{ $magasin->nom}}</td>
                                    @endif



                                    <td class=" align-middle">{{ $magasin->type }}</td>




                                    <td class=" align-middle" style="width:240px;">



                                        <div>





                                            <div class="col-1">
                                                {{-- edit VOIR STOCK --}}
                                                <form class="show-form"
                                                    action="{{ url('/admin/magasin/' . $magasin->id . '/stock') }}"
                                                    method="GET">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-info alpa shadow"><i
                                                            class="bi bi-pen"></i>stock</button>
                                                </form>
                                            </div>






                                            <div class="col-1">
                                                {{-- edit button --}}
                                                <form class="edit-form" action="" data-id="{{ $magasin->id }}"
                                                    data-name="{{ $magasin->nom }}" method="GET">
                                                    @csrf
                                                    <button type="button" onclick="edit_confirmation(this)"
                                                        class="btn btn-outline-primary alpa shadow"><i
                                                            class="bi bi-pen"></i>modifier</button>
                                                </form>
                                            </div>



                                            <div class="col-1">
                                                {{-- delete button --}}
                                                <form class="delete-form" action="" data-id="{{ $magasin->id }}"
                                                    data-name="{{ $magasin->nom . ' ' . $magasin->prenom }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="supprimer_confirmation(this)"
                                                        class="btn btn-outline-danger alpa shadow"><i
                                                            class="bi bi-trash3"></i>Suprrimer</button>
                                                </form>
                                            </div>



                                        </div>



                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                        <!-- <tfoot>
                            <tr>

                                <th>id</th>
                                <th>adresse</th>
                                <th>Photo</th>


                                <th>Actions</th>
                            </tr>
                        </tfoot> -->
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

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
                title: "Êtes-vous sûr de vouloir supprimer ce magasin ?",
                text: name,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui, Supprime-le",
                cancelButtonText: "Non, Annuler",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mettez à jour l'action du formulaire avec l'ID et soumettez-le
                    form.action = `/admin/magasin/${id}/delete`;
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
                // title: "Êtes-vous sûr de vouloir modifier cet(te) stagiaire ?",
                title: "afficher les information des magasin ..?",
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
                    form.action = `/admin/magasin/${id}/edit`;
                    form.submit();
                }
            });
        } else {
            console.error("Le formulaire n'a pas été trouvé.");
        }
    }
</script>





@endsection
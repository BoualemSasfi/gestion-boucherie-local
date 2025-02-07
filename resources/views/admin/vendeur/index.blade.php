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
            <h2>liste des vendeur</h2>
        </div>
        <div class="col-2 text-right">
            <a href="{{ url('/admin/vendeur/add') }}" class="btn btn-success">
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
                                <th>ID</th>
                                <th>Nom</th>
                                <th>magasin</th>
                                <!-- <th>caisse</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($listes as $liste)
                                <tr>
                                    <td class=" align-middle">{{ $liste->id}}</td>
                                    <td class=" align-middle">{{ $liste->nom}}</td>
                                    <td class=" align-middle">{{ $liste->magasin}}</td>
                                    <!-- <td class=" align-middle">{{ $liste->caisse}}</td> -->

                                    <td class="align-middle">
                                        <div class="d-flex justify-content-between">
                                            {{-- Voir STOCK --}}
                                            <form class="show-form"
                                                action="{{ url('/admin/vendeur/' . $liste->id . '/voir') }}" method="GET">
                                                @csrf
                                                <button type="submit">
                                                    <i class="fa-solid fa-xl fa-eye" style="color: #63E6BE;"></i>
                                                </button>
                                            </form>

                                            {{-- edit button --}}
                                            <form class="edit-form" action="" data-id="{{ $liste->id }}" method="GET">
                                                @csrf
                                                <button type="button" onclick="edit_confirmation(this)">
                                                    <i class="fa-solid fa-pen fa-xl" style="color: #74C0FC;"></i>
                                                </button>
                                            </form>

                                            {{-- delete button --}}
                                            <form class="delete-form" action="" data-id="{{ $liste->id }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="supprimer_confirmation(this)">
                                                    <i class="fa-solid fa-trash-can fa-xl" style="color: #ed311d;"></i>
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
                title: "Êtes-vous sûr de vouloir supprimer ce stock ?",
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
                    form.action = '/admin/vendeur/delete/' + id;
                    form.submit();


                }
            });
        } else {
            console.error("Le formulaire n'a pas été trouvé.");
        }
    }
</script>




@if(session('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        Toast.fire({
            icon: "success",
            title: "{{ session('success') }}"
        });
    </script>
@endif


<!-- pour afficher le message dialoge apre les funciton de controller  -->
<!-- @if(session('success'))
    <script>
        Swal.fire({
            title: 'Succès',
            text: '{{ session('success') }}',
            icon: 'success',
            timer: '2000',
            showConfirmButton: false
        });
    </script>
@endif -->






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
                title: "afficher les information des stock ..?",
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
                    form.action = '/admin/vendeur/edit/' + id;
                    form.submit();
                }
            });
        } else {
            console.error("Le formulaire n'a pas été trouvé.");
        }
    }
</script>

<!-- pour afficher le message dialoge apre les funciton de controller  -->
<!-- @if(session('success'))
    <script>
        Swal.fire({
            title: 'Succès',
            text: '{{ session('success') }}',
            icon: 'success',
            timer: '3000',
            showConfirmButton: false
        });
    </script>
@endif -->



@endsection
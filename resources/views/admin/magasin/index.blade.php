@extends('layouts.admin')
@section('content')



{{-- javascript DataTables --}}
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            processing: true,
            // scroller
            scrollCollapse: true,
            scroller: true,
            scrollY: 400,
            // ----------
            // dom: '<"buttons-container"lBfrtip>', 
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ], // Specify the options
            buttons: [],
            language: {
                "lengthMenu": "Afficher _MENU_ éléments par page",
                "zeroRecords": "Aucun enregistrement trouvé",
                "info": "Page _PAGE_ sur _PAGES_",
                "infoEmpty": "Aucun enregistrement disponible",
                "infoFiltered": "(filtré de _MAX_ total des enregistrements)",
                "search": "Rechercher :",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                }
            },
            initComplete: function () {
                // Ajouter des styles personnalisés
                $('.dataTables_length select').css('width',
                    '60px'); // ajustez la largeur selon vos besoins
            },
        });
    });
</script>
<!-- ------------------------------------------- -->


{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row d-flex justify-content-between align-items-center">
        <div class="col-2">
            <a href="{{ url('/home') }}" class="btn btn-dark">
                <i class="fas fa-arrow-left pr-1"></i>
                <span class="btn-description"></span>
            </a>
        </div>
        <div class="col-8 text-center">
            <h2>Mgasins</h2>
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
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>


                                <th>Nom</th>
                                <th>type</th>
                                <th>Photo</th>


                                <th>Actions</th>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($magasins as $magasin)
                                <tr>
                                    <td class=" align-middle">{{ $magasin->nom}}</td>

                                    <td class=" align-middle">{{ $magasin->type }}</td>

                                    <td class=" align-middle" style="width:80px;">
                                        <div
                                            style="background-image:url({{ asset('storage/' . $magasin->photo) }});background-size: cover;background-position: center;background-repeat: no-repeat;  height: 80px; width: 70px; margin-left:5px; margin-right:5px;">
                                        </div>
                                    </td>



                                    <td class=" align-middle" style="width:240px;">


                                        <div class="row">


                                            <div class="col-2">
                                                {{-- edit button --}}
                                                <form class="edit-form" action="" data-id="{{ $magasin->id }}"
                                                    data-name="{{ $magasin->nom }}" method="GET">
                                                    @csrf
                                                    <button type="button" onclick="edit_confirmation(this)"
                                                        class="btn btn-outline-primary alpa shadow"><i
                                                            class="bi bi-pen"></i>modifier</button>
                                                </form>
                                            </div>



                                            <div class="col-2">
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
            timer: '4000', 
            showConfirmButton: false 
        });
    </script>
@endif



<!-- dd -->


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
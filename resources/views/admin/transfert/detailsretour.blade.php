@extends('layouts.admin')
@section('content')


{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row d-flex justify-content-between align-items-center">
        <div class="col-2">
            <a href="{{ url('/admin/retour') }}" class="btn btn-dark">
                <i class="fas fa-arrow-left pr-1"></i>
                <span class="btn-description"></span>
            </a>
        </div>
        <div class="col-8 text-center">
            <h2>Details de Retour</h2>
        </div>
        <div class="col-2 text-right">

        </div>
    </div>


    <div>

    </div>

</div>


<div class="container" style="margin-top: 10px;">

    <div class="row animate__animated animate__backInLeft">

        <div class="card shadow col-12">


            <div class="card-body">


                <div class="card-body">
                    <p>Retour de <b>{{$info->atl}}</b> ver <b>{{$info->mag}}</b> le retour fais par
                        <b>{{$info->user }}</b> a <b>{{$info->created_at}}</b>
                    </p>
                    <table id="example" class="table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Produit </th>
                                <th>Categorie</th>
                                <th>Qauntity</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($details as $detail)
                                <tr>
                                    <td class=" align-middle">{{ $detail->produit}}</td>
                                    <td class=" align-middle">{{ $detail->category}}</td>
                                    <td class=" align-middle">{{ $detail->quantity}} Kg</td>



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
                    form.action = '/admin/stock/' + id + '/delet_add';
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
                    form.action = '/admin/stock/' + id + '/update_affich';
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
            timer: '3000',
            showConfirmButton: false
        });
    </script>
@endif



@endsection
@extends('layouts.admin')
@section('content')





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
            <h2>liste des caisses</h2>
        </div>
        <div class="col-2 text-right">
            <a href="{{ url('/admin/caisse/add') }}" class="btn btn-success">
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
                                <th>Magasin</th>
                                <th>Code</th>
                                <th>Solde</th>
                                <th>Active</th>
                                <!-- <th>caisse</th> -->
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($listes as $liste)
                                <tr>
                                    <td class=" align-middle">{{ $liste->id}}</td>

                                    <td class=" align-middle">

                                        @foreach ($magasins as $magasin)                             
                                            @if ($magasin->id == $liste->id_magasin)
                                                {{ $magasin->nom }}
                                            @endif

                                        @endforeach



                                    </td>
                                    <td class=" align-middle">{{ $liste->code_caisse}}</td>
                                    <td class=" align-middle">{{$liste->solde}} DA</td>
                                    <!-- <td class=" align-middle">{{$liste->active}}</td> -->
                                    <!-- <td class=" align-middle">{{ $liste->caisse}}</td> -->

                                    <td class="align-middle">
                                        <div class="d-flex justify-content-between">
                                            {{-- tranfert STOCK --}}



                                            <!-- Bouton qui déclenche SweetAlert -->
                                            <button type="button" onclick="showMagasins({{ $liste->id }})">
                                                <!-- <i class="fa-solid fa-xl fa-eye" style="color: #63E6BE;"></i> -->
                                                <!-- <i class="fa-solid fa-money-bill-transfer fa-lg" style="color: #63E6BE;"></i> -->
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24" width="30"
                                                    viewBox="0 0 640 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                    <path fill="#63E6BE"
                                                        d="M535 41c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l64 64c4.5 4.5 7 10.6 7 17s-2.5 12.5-7 17l-64 64c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l23-23L384 112c-13.3 0-24-10.7-24-24s10.7-24 24-24l174.1 0L535 41zM105 377l-23 23L256 400c13.3 0 24 10.7 24 24s-10.7 24-24 24L81.9 448l23 23c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L7 441c-4.5-4.5-7-10.6-7-17s2.5-12.5 7-17l64-64c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9zM96 64l241.9 0c-3.7 7.2-5.9 15.3-5.9 24c0 28.7 23.3 52 52 52l117.4 0c-4 17 .6 35.5 13.8 48.8c20.3 20.3 53.2 20.3 73.5 0L608 169.5 608 384c0 35.3-28.7 64-64 64l-241.9 0c3.7-7.2 5.9-15.3 5.9-24c0-28.7-23.3-52-52-52l-117.4 0c4-17-.6-35.5-13.8-48.8c-20.3-20.3-53.2-20.3-73.5 0L32 342.5 32 128c0-35.3 28.7-64 64-64zm64 64l-64 0 0 64c35.3 0 64-28.7 64-64zM544 320c-35.3 0-64 28.7-64 64l64 0 0-64zM320 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z" />
                                                </svg>
                                            </button>


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
<!-- Script SweetAlert -->
    <script>
        function showMagasins(idListe) {
            // Liste des magasins (remplacez par votre propre logique pour récupérer les magasins)
            let magasins = [
                @foreach($magasins as $magasin)
                    { id: {{ $magasin->id }}, nom: '{{ $magasin->nom }}' },
                @endforeach
            ];

            // Créer une liste des magasins sous forme de HTML pour l'afficher dans SweetAlert
            let magasinOptions = '';
            magasins.forEach(magasin => {
                magasinOptions += `<option value="${magasin.id}">${magasin.nom}</option>`;
            });

            // Afficher SweetAlert avec un select pour choisir le magasin
            Swal.fire({
                title: 'Sélectionnez un magasin  ',
                html: `
                <select id="magasinSelect" class="swal2-input">
                    <option value="">Sélectionnez un magasin</option>
                    ${magasinOptions}
                </select>
            `,
                showCancelButton: true,
                confirmButtonText: 'Transférer',
                preConfirm: () => {
                    const magasinId = Swal.getPopup().querySelector('#magasinSelect').value;
                    if (!magasinId) {
                        Swal.showValidationMessage('Vous devez sélectionner un magasin');
                    }
                    return magasinId;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirection vers une route avec idListe et idMagasin dans l'URL
                    const magasinId = result.value;
                    window.location.href = `/admin/caisse/lemagasin/${idListe}/${magasinId}`;
                }
            });
        }
    </script>






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
                        form.action = '/admin/caisse/delete/' + id;
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
                        form.action = '/admin/caisse/edit/' + id;
                        form.submit();
                    }
                });
            } else {
                console.error("Le formulaire n'a pas été trouvé.");
            }
        }
    </script>





    @endsection
@extends('layouts.admin')
@section('content')
    {{-- retour en arrière --}}
    <div class="container" id="titre-page">
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-2">
                <a href="{{ url('/admin/stock') }}" class="btn btn-dark">
                    <i class="fas fa-arrow-left pr-1"></i>
                    <span class="btn-description"></span>
                </a>
            </div>






            <div class="col-8 text-center">
                <h2>Ajouter un nouveau stock {{ $id }} </h2>
            </div>
            <div class="col-2 text-right">

            </div>
        </div>

    </div>


    <div class="container" style="margin-top: 10px;">

        <div class="row animate__animated animate__backInLeft">

            <div class="card shadow col-12">
                <form class="edit-form" action="{{ url('/admin/stock/' . $id . '/update') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-6">
                                <form>
                                    <div class="form-group">
                                        <label for="">magasin : </label>
                                        <select id="magasin" name="magasin_id" class="form-control">
                                            <option value="">Sélectionnez un magasin </option>
                                            @foreach ($magasins as $magasin)
                                                <option value="{{ $magasin->id }}">{{ $magasin->nom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>

                            <div class="form-group col-6">

                                <div class="form-group">
                                    <label for="">type de stock </label>
                                    <select id="" name="type" class="form-control">
                                        <option value="">Sélectionnez le type de stockage </option>
                                        <option value="Frais">Frais</option>
                                        <option value="Congele">Congele</option>


                                    </select>
                                </div>


                            </div>





                        </div>




                        <div class="row">

                            <div class="col-6 mx-auto">
                                <form class="add_cat_form" data-id="{{ $id }}">
                                    <div class="row">
                                        <div class="form-group col-9">

                                            <select id="category" name="category_id" class="form-control ">
                                                <option value="">sélectionné catégorie </option>
                                                @foreach ($categorys as $category)
                                                    <option value="{{ $category->id }}">{{ $category->nom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <button type="button" class=" btn btn-outline-success " type="button"
                                                onclick="AddCat(this)">
                                                Add
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>


                            <div class="col-8 mx-auto ">
                                <table id="example" class="table-striped table-bordered" style="width:100%">
                                    <thead class="text-center">
                                        <tr>
                                            <th>titre </th>
                                            <th>photo</th>

                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody id="category_liste" class="text-center">



                                        <!-- liste  des categorys -->

                                    </tbody>

                                </table>
                            </div>
                        </div>


                        <!-- boutton de sauvegarder  -->
                        <div class="form-group row justify-content-center text-center m-3">
                            <div class="col-6">
                                <button type="button" onclick="sauvegarder(this)" class="btn btn-success p-2">
                                    <i class="fas fa-check fa-lg mr-2"></i><span
                                        class="btn-description">Enregistrer</span></button>
                            </div>



                            <div class="col-6">
                                {{-- delete button --}}
                                <form class="delete-form" action="" data-id="{{ $id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="annuler_confirmation(this)"
                                        class="btn btn-danger alpa shadow"><i class="bi bi-trash3"></i>Annuler</button>
                                </form>
                            </div>
                        </div>





                        <!-- fin -->
                    </div>

                </form>

            </div>



            <!-- pour affiche la liste des category pour ce magasin  -->

            <script>
                $(document).ready(function() {
                    // Appeler la fonction au chargement de la page
                    afficher_category({{ $id }});
                    // afficher_la_categorie({{ $id }});
                });
            </script>

            <script>
                function afficher_category(id) {
                    $.ajax({
                        url: '/admin/stock/category/' + id,
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // Assurez-vous que cette balise meta est incluse dans votre HTML
                        },
                        success: function(response) {
                            $('#category_liste').empty();
                            $.each(response.category_liste, function(key, value) {
                                $('#category_liste').append(
                                    '<tr>' +
                                    '<td class="align-middle">' + value.nom + '</td>' +
                                    '<td class="align-middle" style="width:80px;">' +
                                    '<div style="background-image:url(' + value.photo + ');' +
                                    'background-size: cover;' +
                                    'background-position: center;' +
                                    'background-repeat: no-repeat;' +
                                    'height: 80px; width: 70px;' +
                                    'margin-left:5px; margin-right:5px;">' +
                                    '</div>' +
                                    '</td>' +
                                    '<td class="align-middle" style="width:240px;">' +
                                    '<div>' +
                                    '<div class="col-1">' +
                                    '<form class="delete-form" action="" method="POST" data-id="' + value
                                    .id + '">' +
                                    '@csrf' +
                                    '@method('DELETE')' +
                                    '<button type="button" class="btn btn-outline-danger shadow" onclick="supprimer(this)">' +
                                    'Supprimer' +
                                    '</button>' +
                                    '</form>' +
                                    '</div>' +
                                    '</div>' +
                                    '</td>' +
                                    '</tr>'
                                );
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            </script>


            <!-- ajoute une catégorie -->
            <script>
                function AddCat(button) {
                    // Trouver le formulaire parent le plus proche du bouton cliqué
                    const form = button.closest('.add_cat_form');
                    if (form) {
                        // Récupérer l'ID du stock et la catégorie sélectionnée
                        const id_stock = form.getAttribute('data-id');
                        // const category = $('#category').val();
                        const category = form.querySelector('#category').value;

                        console.log('stock_id = ' + id_stock);
                        console.log('category_id = ' + category);

                        // Vérifier si l'ID du stock et la catégorie sont définis
                        if (id_stock && category) {
                            console.log('ajax');
                            $.ajax({
                                url: '/admin/stock/categorie/add/' + id_stock + '/' +
                                category, // Construire l'URL de la requête
                                type: 'post', // Type de la requête (POST)
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content') // Ajouter le token CSRF pour la sécurité
                                },

                                success: function() {
                                    Swal.fire({
                                        title: "Catégorie ajoutée !", // Message de succès
                                        icon: "success",
                                        timer: 1000, // Durée d'affichage (1 seconde)
                                        showConfirmButton: false // Ne pas montrer le bouton de confirmation
                                    });

                                    // Afficher les catégories après l'ajout réussi
                                    afficher_category(id_stock);
                                },
                                error: function(xhr, status, error) {
                                    console.error(error); // Afficher l'erreur dans la console
                                    Swal.fire({
                                        title: "Ajout refusé, la catégorie existe déjà  !", // Message d'erreur
                                        icon: "warning",
                                        timer: 1000, // Durée d'affichage (1 seconde)
                                        showConfirmButton: false // Ne pas montrer le bouton de confirmation
                                    });
                                }
                            });
                        } else {
                            console.error(
                            'La valeur de la catégorie est indéfinie.'); // Message d'erreur si la catégorie n'est pas définie
                        }
                    } else {
                        console.error('Formulaire parent non trouvé.'); // Message d'erreur si le formulaire parent n'est pas trouvé
                    }
                }
            </script>



            {{-- script suppression --}}
            <script>
                function annuler_confirmation(button) {
                    // Utilisez le bouton pour obtenir le formulaire parent
                    const form = button.closest('.delete-form');

                    // Vérifiez si le formulaire a été trouvé
                    if (form) {
                        // Utilisez le formulaire pour extraire l'ID
                        const id = form.dataset.id;


                        Swal.fire({
                            title: "Êtes-vous sûr de vouloir annuler .. ?",
                            text: name,
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#198754",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Oui",
                            cancelButtonText: "Non",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Mettez à jour l'action du formulaire avec l'ID et soumettez-le
                                form.action = `/admin/stock/${id}/delet_add`;
                                form.submit();


                            }
                        });
                    } else {
                        console.error("Le formulaire n'a pas été trouvé.");
                    }
                }
            </script>



            {{-- script sauvegarder --}}
            <script>
                function sauvegarder(button) {
                    // Utilisez le bouton pour obtenir le formulaire parent
                    const form = button.closest('.edit-form');

                    // Vérifiez si le formulaire a été trouvé
                    if (form) {

                        Swal.fire({
                            title: "Voulez- vous sauvegarder ce stock ... ? ",
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


          
        </div>
    </div>


@endsection

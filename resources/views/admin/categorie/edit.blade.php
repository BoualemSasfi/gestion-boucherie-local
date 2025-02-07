@extends('layouts.admin')
@section('content')
{{-- retour en arrière --}}
<div class="container" id="titre-page">

    <div class="row justify-content-between align-items-center">
        <div class="col-2 align-items-center">
            <a href="{{ url('/admin/category') }}" class="btn btn-dark"><i class="fas fa-arrow-left pr-1"></i><span
                    class="btn-description">Retour</span></a>
        </div>
        <div class="col-8 text-center">
            <h2>Modifier la viande {{$category->id}} </h2>
        </div>
        <div class="col-2 text-md-right">
 
        </div>

    </div>
</div>

{{--
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--}}


<div class="container" style="margin-top: 10px;">
    <div class="row animate__animated animate__backInLeft">



        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mx-auto">
            <div class="card shadow m-1">
                <form class="edit-form" action="{{ url('/admin/category/' . $category->id . '/update') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="row">
                            <input type="file" name="photo" id="validationLogoCouleurs" accept="image/*"
                                style="display: none;" onchange="previewImage2();">



                            @if (!empty($category->photo) && Storage::exists('public/' . $category->photo))
                                <div class="form-group col-12">
                                    <img src="{{ asset('storage/' . $category->photo) }}" class="card-img-top" alt=""
                                        id="preview2" onclick="triggerFileInput();" style="height: 280px;">
                                </div>
                            @else
                                <div class="form-group col-12">
                                    <img src="{{ asset('img/logo_vide/add_image.PNG') }}" class="card-img-top" alt=""
                                        id="preview2" onclick="triggerFileInput();" style="height: 280px;">
                                </div>
                            @endif




                            <div class="form-group col-12">
                                <label for="">Titre :</label>
                                <input type="text" name="nom" class="form-control" placeholder="Titre de catégorie"
                                    value="{{ $category->nom }}"></input>
                                <label for="">Ordre :</label>
                                <input type="number" name="nombre" class="form-control" placeholder="Ordre d'affichage "
                                    value="{{ $category->nombre }}"></input>
                            </div>

                            <div class="form-group col-12">
                                <div class="row justify-content-center text-center m-3">
                                    <div class="col-6">
                                        <button type="button" onclick="sauvegarder(this)" class="btn btn-success p-2"><i
                                                class="fas fa-check fa-lg mr-2"></i><span
                                                class="btn-description">Enregistrer</span></button>
                                    </div>
                                    <div class="col-6">
                                        <a class="btn btn-danger p-2" href="{{ url('/admin/category') }}"><i
                                                class="fas fa-times fa-lg mr-2"></i><span
                                                class="btn-description">Annuler</span></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>
        </div>
        </form>
        <!-- fin -->
    </div>
</div>


<dvi class="col-12">

    <div class="row d-flex justify-content-between align-items-center">
        <div class="col-2">
            <!-- <a href="{{ url('/home') }}" class="btn btn-dark">
                        <i class="fas fa-arrow-left pr-1"></i>
                        <span class="btn-description"></span>
                    </a> -->
        </div>

        <div class="col-8 text-center">
            <h2 class="text-center">Liste des produits </h2>
        </div>

        <div class="col-2 text-right">
            <!-- <button class="btn btn-success" onclick="ajtsousproduit()">
                <i class="fas fa-plus fa-xl pr-1"></i>
            </button> -->

            <div class="col-2 text-right">
                <a href="{{ url('/admin/produit/add/' . $category->id) }}" class="btn btn-success">
                    <i class="fas fa-plus fa-xl pr-1"></i><span class="btn-description"></span>
                </a>
            </div>

        </div>



    </div>

    <div class="card-body">


        <div class="card-body shadow ">
            <table id="produitsTable" class="table-striped table-bordered" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th>Ordre</th>
                        <th>Photo</th>
                        <th>Produit</th>
                        <th>Prix Detail</th>
                        <th>Prix Semi Gros</th>
                        <th>Prix Gros</th>
                        <th>Active</th>
                    </tr>
                </thead>

                <tbody class="text-center">
                    @foreach ($produits as $produit)
                        <tr>
                            <td class="align-middle">{{ $produit->nombre }}</td>
                            <td class="align-middle">
                                <img src="{{ asset('storage/' . $produit->photo_pr) }}" style="height: 80px;" alt="">
                            </td>
                            <td class="align-middle">{{ $produit->nom_pr }}</td>
                            <td class="align-middle">{{ $produit->prix_vente }} DA</td>
                            <td class="align-middle">{{ $produit->semi_gros }} DA</td>
                            <td class="align-middle">{{ $produit->gros }} DA</td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-between">

                                    <!-- Edit button -->
                                    <form class="edit-form" action="/admin/produit/{{ $produit->id }}/{{$category->id}}/mdf"
                                        data-id="{{ $produit->id }}" method="GET">
                                        @csrf
                                        <button type="button" onclick="edit_confirmation(this)">
                                            <i class="fa-solid fa-pen fa-xl" style="color: #74C0FC;"></i>
                                        </button>
                                    </form>

                                    <!-- Delete button -->
                                    <form class="delete-form" action="/admin/produit/{{ $produit->id }}/delete"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="supprimer_confirmation({{ $produit->id }})">
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


</dvi>





<!--  ajouter produit ajax  -->
<script>
    async function ajtsousproduit() {
        // Demander à l'utilisateur de sélectionner une image
        const { value: file } = await Swal.fire({
            title: "Sélectionnez une image",
            input: "file",
            inputAttributes: {
                "accept": "image/*",
                "aria-label": "Téléchargez votre image"
            }
        });

        if (file) {
            const reader = new FileReader();
            const categorie_id = {{$category->id}};
            reader.onload = (e) => {
                // Afficher l'image téléchargée
                Swal.fire({
                    title: "Votre image téléchargée",
                    imageUrl: e.target.result,
                    imageAlt: "L'image téléchargée",
                    html: `
                    <input id="ProductName" class="swal2-input" placeholder="Nom de produit" required>
                    <input id="priceAchat" class="swal2-input" placeholder="Prix achat" onkeypress="return isNumberKey(event)" required>
                    <input id="priceDetail" class="swal2-input" placeholder="Prix détail" onkeypress="return isNumberKey(event)" required>
                    <input id="priceSemiGros" class="swal2-input" placeholder="Prix semi-gros" onkeypress="return isNumberKey(event)" required>
                    <input id="priceGros" class="swal2-input" placeholder="Prix gros" onkeypress="return isNumberKey(event)" required>
                     
                    <select id="unite_mesure" name="unite_mesure" class="swal4">
                                    <option value="Kg">Kg</option>
                                    <option value="piece" >pièce</option>
                                </select>
                `,
                    showCancelButton: true,
                    confirmButtonText: 'Enregistrer',
                    cancelButtonText: 'Annuler',
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        // Collecter les informations
                        const ProductName = document.getElementById('ProductName').value;
                        const priceDetail = document.getElementById('priceDetail').value;
                        const priceSemiGros = document.getElementById('priceSemiGros').value;
                        const priceGros = document.getElementById('priceGros').value;
                        const unite_mesure = document.getElementById('unite_mesure').value;
                        const priceAchat = document.getElementById('priceAchat').value;

                        // Vérification des champs
                        if (!ProductName || !priceAchat || !priceDetail || !priceSemiGros || !priceGros) {
                            Swal.showValidationMessage('Veuillez remplir tous les champs requis, y compris le prix d\'achat.');
                            return;
                        }


                        // Créer un FormData pour l'envoi des données
                        const formData = new FormData();
                        formData.append('ProductName', ProductName);
                        formData.append('photo', file); // Retourne le fichier de l'image
                        formData.append('priceAchat', priceAchat);
                        formData.append('priceDetail', priceDetail);
                        formData.append('priceSemiGros', priceSemiGros);
                        formData.append('priceGros', priceGros);
                        formData.append('unite_mesure', unite_mesure);
                        formData.append('categorie_id', categorie_id); // Ajouter l'ID du categorie
                        formData.append('_token', '{{ csrf_token() }}'); // Ajouter le token CSRF

                        // Envoyer les données à votre contrôleur
                        try {
                            const response = await fetch('/admin/produit/add_produit', {
                                method: 'POST',
                                body: formData,
                            });

                            if (response) {
                                Swal.fire('Enregistré!', 'Le Produit a été ajouté.', 'success');
                                location.reload();
                            } else {
                                Swal.fire('Erreur!', 'Une erreur est survenue lors de l\'enregistrement.', 'error');
                            }
                        } catch (error) {
                            console.error('Erreur lors de l\'envoi:', error);
                            Swal.fire('Erreur!', 'Une erreur est survenue lors de l\'envoi.', 'error');
                        }
                    }
                });
            };
            reader.readAsDataURL(file);
        }
    }

    // Fonction pour n'accepter que les chiffres
    function isNumberKey(evt) {
        const charCode = (evt.which) ? evt.which : evt.keyCode;

        // Autoriser uniquement les chiffres, la suppression (backspace), et le point (pour les décimales)
        if ((charCode < 48 || charCode > 57) && charCode !== 8 && charCode !== 46) {
            return false;
        }

        return true;
    }

    // Exemple de bouton pour appeler la fonction
    document.addEventListener('DOMContentLoaded', function () {
        const button = document.createElement('button');
        button.textContent = 'Ajouter un sous-produit';
        button.onclick = ajtsousproduit;
        document.body.appendChild(button);
    });
</script>





<script>
    function edit_confirmation(button) {
        // Récupérer l'élément du formulaire parent
        const form = button.closest('form');
        const produitId = form.dataset.id; // Récupérer l'ID du produit

        // Afficher SweetAlert
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: `Vous êtes sur le point d'éditer le produit ID: ${produitId}.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui, Modifier',
            cancelButtonText: 'Annuler',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Soumettre le formulaire si confirmé
            }
        });
    }
</script>




<!-- supprimer un sous produit  -->

<script>
    async function supprimer_confirmation(id) {
        // Afficher l'alerte de confirmation
        const result = await Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: 'Cette action supprimera le produit définitivement.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        });

        // Si confirmé, soumettre le formulaire
        if (result.isConfirmed) {
            // Soumettre le formulaire de suppression avec l'ID
            try {
                const response = await fetch(`/admin/produit/${id}/delete`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (response) {
                    // Swal.fire('Supprimé!', 'Le produit a été supprimé.', 'success').then(() => {
                    //     location.reload(); // Rafraîchir la page après suppression
                    // });
                    location.reload();
                } else {
                    Swal.fire('Erreur', 'La suppression a échoué.', 'error');
                }
            } catch (error) {
                console.error('Erreur lors de la suppression:', error);
                Swal.fire('Erreur', 'Une erreur est survenue lors de la suppression.', 'error');
            }
        }
    }
</script>

<!-- datatable -->
<script>
    $(document).ready(function () {
        $('#produitsTable').DataTable({
            "pageLength": 10, // Nombre d'entrées affichées par défaut
            "lengthMenu": [[10, 20, 50], [10, 20, 50]], // Options pour le nombre d'entrées
            "scrollY": "400px", // Hauteur de défilement vertical
            "scrollCollapse": true, // Active le défilement vertical
            "searching": true, // Barre de recherche

        });
    });
</script>


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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
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
        @endif

        @if(session('error'))
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: "{{ session('error') }}"
            });
        @endif
    });
</script>

<style>
    @media (max-width: 768px) {
        h2 {
            font-size: 18px;
            /* Réduit la taille du titre */
        }

        .btn-description {
            display: none;
            /* Cache le texte des boutons */
        }

        .btn {
            font-size: 12px;
            /* Réduit la taille des boutons */
        }

    }

    @media (max-width: 576px) {
        .h2 {
            font-size: 16px;
            /* Réduit davantage la taille du titre */
        }

        .btn {
            font-size: 10px;
            padding: 6px 8px;
            /* Réduit l'espace autour des icônes */
        }


    }
</style>
@endsection
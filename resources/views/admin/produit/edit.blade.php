@extends('layouts.admin')
@section('content')
{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row justify-content-between align-items-center">

        <div class="col-2">
            <a href="{{ url('/admin/produit') }}" class="btn btn-dark"><i class="fas fa-arrow-left pr-1"></i><span
                    class="btn-description">Retour</span></a>
        </div>
        <div class="col-8 text-center">
            <h2>Modifier Le Produit </h2>
        </div>
        <div class="col-2 text-right">

        </div>

    </div>







</div>

{{--
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--}}
<div class="container" style="margin-top: 10px;">
    <div class="row animate__animated animate__backInLeft">



        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mx-auto">
            <div class="card shadow m-1">

                <form class="edit-form" action="{{ url('/admin/produit/' . $produit->id . '/update') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="row">


                            <div class="form-group col-4">
                                <h2 class="text-center"> information : </h2>
                                <label for="">Titre :</label>
                                <input type="text" name="nom_pr" class="form-control" placeholder="nom de produit"
                                    value="{{ $produit->nom_pr }}"></input>

                                <form>
                                    <div class="form-group">
                                        <label for="">categorie de viande:</label>
                                        <select id="category" name="category_id" class="form-control">
                                            <option value="">Sélectionnez une catégorie</option>
                                            @foreach ($categorys as $category)
                                                <!-- Ajouter une classe conditionnelle pour la première option -->
                                                <option value="{{ $category->id }}"
                                                    style="{{ $category->id == $defaultCategoryId ? 'color: red;' : '' }}"
                                                    {{ $category->id == $defaultCategoryId ? 'selected' : '' }}>
                                                    {{ $category->nom }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>



                                <label for="">Unité de mesure :</label>
                                <select name="unite_mesure" class="form-control">
                                    <!-- Options supplémentaires -->
                                    <option value="Kg" {{ $produit->unite_mesure == 'Kg' ? 'selected' : '' }}>Kg</option>
                                    <option value="piece" {{ $produit->unite_mesure == 'piece' ? 'selected' : '' }}>pièce
                                    </option>
                                </select>

                            </div>

                            <div class="col-4">

                                <h2 class="text-center"> Prix d'achat : </h2>

                                <input type="text" name="prix_achat" class="form-control" placeholder="Prix d'achat"
                                    value="{{ $produit->prix_achat }}"></input>

                                <input type="file" name="photo_pr" id="validationLogoCouleurs" accept="image/*"
                                    style="display: none;" onchange="previewImage2();">


                                @if (!empty($produit->photo_pr) && Storage::exists('public/' . $produit->photo_pr))
                                    <div class="form-group col-12">
                                        <img src="{{ asset('storage/' . $produit->photo_pr) }}" class="card-img-top" alt=""
                                            id="preview2" onclick="triggerFileInput();" style="height: 280px;">
                                    </div>
                                @else
                                    <div class="form-group col-12">
                                        <img src="{{ asset('img/logo_vide/add_image.PNG') }}" class="card-img-top" alt=""
                                            id="preview2" onclick="triggerFileInput();" style="height: 280px;">
                                    </div>
                                @endif

                            </div>

                            <div class="form-group col-4">
                                <h2 class="text-center"> Prix de vente : </h2>
                                <label for="">détail :</label>
                                <input type="text" name="prix_vente" class="form-control" placeholder="Prix de vent"
                                    value="{{ $produit->prix_vente }}"></input>

                                <label for="">Semi gros :</label>
                                <input type="text" name="semi_gros" class="form-control" placeholder="Prix de semi gors"
                                    value="{{ $produit->semi_gros}}"></input>

                                <label for="">Gros :</label>
                                <input type="text" name="gros" class="form-control" placeholder="Prix de gros"
                                    value="{{ $produit->gros }}"></input>
                            </div>

                            <div class="form-group col-12">

                                <div class="row justify-content-center text-center">
                                    <div class="col-6">
                                        <button id="mdf" type="button" onclick="sauvegarder(this)"
                                            class="btn btn-success p-2">
                                            <i class="fas fa-check fa-lg mr-2"></i><span
                                                class="btn-description">Modifier</span>
                                        </button>

                                    </div>
                                    <div class="col-6">
                                        <a class="btn btn-danger p-2" href="{{ url('/admin/produit') }}"><i
                                                class="fas fa-times fa-lg mr-2"></i><span
                                                class="btn-description">Annuler</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                <!-- fin -->

                <dvi class="col-12">

                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-2">
                            <!-- <a href="{{ url('/home') }}" class="btn btn-dark">
                                            <i class="fas fa-arrow-left pr-1"></i>
                                            <span class="btn-description"></span>
                                        </a> -->
                        </div>

                        <div class="col-8 text-center">
                            <h2 class="text-center">liste des sous produit </h2>
                        </div>

                        <div class="col-2 text-right">
                            <button class="btn btn-success" onclick="ajtsousproduit()">
                                <i class="fas fa-plus fa-xl pr-1"></i>
                            </button>
                        </div>



                    </div>

                    <div class="card-body">


                        <div class="card-body">
                            <table id="example" class="table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th>ID</th>
                                        <th>photo</th>
                                        <th>Sous Produit</th>
                                        <th>Prix Detail</th>
                                        <th>Prix Semi Gros</th>
                                        <th>Prix Gros</th>
                                        <th>Active</th>
                                        <!-- <th>caisse</th> -->
                                        <!-- <th>Action</th> -->
                                    </tr>
                                </thead>

                                <tbody class="text-center">
                                    @foreach ($sproduits as $sproduit)
                                        <tr>
                                            <td class=" align-middle">{{ $sproduit->id}}</td>
                                            <td class=" align-middle">
                                                <img src="{{ asset('storage/' . $sproduit->photo_s_pr) }}"
                                                    style="height: 80px;" alt="">

                                            </td>
                                            <td class=" align-middle">{{ $sproduit->nom_s_pr}}</td>
                                            <td class=" align-middle">{{ $sproduit->prix_vente}} DA</td>
                                            <td class=" align-middle">{{ $sproduit->prix_semi_gros}} DA</td>
                                            <td class=" align-middle">{{ $sproduit->prix_gros}} DA</td>

                                            <td class="align-middle">
                                                <div class="d-flex justify-content-between">

                                                    {{-- edit button --}}
                                                    <form class="edit-form" action="" data-id="{{ $sproduit->id }}"
                                                        method="GET">
                                                        @csrf
                                                        <button type="button" onclick="edit_confirmation(this)">
                                                            <i class="fa-solid fa-pen fa-xl" style="color: #74C0FC;"></i>
                                                        </button>
                                                    </form>

                                                    {{-- delete button --}}
                                                    <form class="delete-form"
                                                        action="/admin/produit/{{ $sproduit->id }}/delete_sous_produit"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="supprimer_confirmation({{ $sproduit->id }})">
                                                            <i class="fa-solid fa-trash-can fa-xl"
                                                                style="color: #ed311d;"></i>
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
            </div>
        </div>
    </div>
</div>





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
    async function sauvegarder(button) {
        // Affiche une alerte de confirmation avant la sauvegarde
        const result = await Swal.fire({
            title: 'Confirmer la sauvegarde',
            text: 'Êtes-vous sûr de vouloir enregistrer les modifications ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, enregistrer',
            cancelButtonText: 'Annuler'
        });

        // Si l'utilisateur confirme, soumettre le formulaire
        if (result.isConfirmed) {
            // Récupère et soumet le formulaire parent du bouton
            button.closest('.edit-form').submit();
            // Affiche une alerte de succès après la soumission
            Swal.fire(
                'Enregistré!',
                'Les modifications ont été enregistrées avec succès.',
                'success'
            );
        }
    }
</script>

{{-- fin sauvegarder --}}






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
            reader.onload = (e) => {
                // Afficher l'image téléchargée
                Swal.fire({
                    title: "Votre image téléchargée",
                    imageUrl: e.target.result,
                    imageAlt: "L'image téléchargée",
                    html: `
                    <input id="subProductName" class="swal2-input" placeholder="Nom du sous-produit" required>
                    <input id="priceDetail" class="swal2-input" placeholder="Prix détail" onkeypress="return isNumberKey(event)" required>
                    <input id="priceSemiGros" class="swal2-input" placeholder="Prix semi-gros" onkeypress="return isNumberKey(event)" required>
                    <input id="priceGros" class="swal2-input" placeholder="Prix gros" onkeypress="return isNumberKey(event)" required>
                `,
                    showCancelButton: true,
                    confirmButtonText: 'Enregistrer',
                    cancelButtonText: 'Annuler',
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        // Collecter les informations
                        const subProductName = document.getElementById('subProductName').value;
                        const priceDetail = document.getElementById('priceDetail').value;
                        const priceSemiGros = document.getElementById('priceSemiGros').value;
                        const priceGros = document.getElementById('priceGros').value;

                        // Vérification des champs
                        if (!subProductName || !priceDetail || !priceSemiGros || !priceGros) {
                            Swal.showValidationMessage('Veuillez remplir tous les champs requis.');
                            return;
                        }

                        // Créer un FormData pour l'envoi des données
                        const formData = new FormData();
                        formData.append('subProductName', subProductName);
                        formData.append('photo', file); // Retourne le fichier de l'image
                        formData.append('priceDetail', priceDetail);
                        formData.append('priceSemiGros', priceSemiGros);
                        formData.append('priceGros', priceGros);
                        formData.append('productId', '{{ $produit->id }}'); // Ajouter l'ID du produit
                        formData.append('_token', '{{ csrf_token() }}'); // Ajouter le token CSRF

                        // Envoyer les données à votre contrôleur
                        try {
                            const response = await fetch('/admin/produit/add_sous_produit', {
                                method: 'POST',
                                body: formData,
                            });

                            if (response) {
                                Swal.fire('Enregistré!', 'Le sous-produit a été ajouté.', 'success');
                                window.location.href = '/admin/produit/{{ $produit->id }}/edit'; // Redirige vers la page de modification du produit
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


<!-- supprimer un sous produit  -->

<script>
    async function supprimer_confirmation(id) {
        // Afficher l'alerte de confirmation
        const result = await Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: 'Cette action supprimera le sous-produit définitivement.',
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
                const response = await fetch(`/admin/produit/${id}/delete_sous_produit`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (response) {
                    Swal.fire('Supprimé!', 'Le sous-produit a été supprimé.', 'success').then(() => {
                        location.reload(); // Rafraîchir la page après suppression
                    });
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



@endsection
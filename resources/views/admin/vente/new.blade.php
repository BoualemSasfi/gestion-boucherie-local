@extends('layouts.admin')
@section('content')
{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row justify-content-between align-items-center">
        <div class="col-2 ">
            <a href="{{ url('/admin/client') }}" class="btn btn-dark"><i class="fas fa-arrow-left pr-1"></i><span
                    class="btn-description">Retour</span></a>
        </div>
        <div class="col-8 text-center">
            <h2>Nouvelle vente Facture N° {{$facture->id}} </h2>
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


        <!-- information atelier -->
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mx-auto">
            <div class="card shadow m-1">

                <form class="edit-form" action="{{ url('/admin/client/add/save') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <H4 class="text-center">Information D'Atelier <i class="fa-solid fa-warehouse fa-lg"></i></H4>
                        <div class="row">
                            <div class="col-4">
                                <h5 class="text-center">Atelier</h5>
                                <select name="atelier" id="atelier-select" class="form-control">
                                    <option value="" disabled selected>Les Ateliers</option>
                                    @foreach ($ateliers as $atelier)
                                        <option value="{{ $atelier->id }}">{{ $atelier->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-4">
                                <h5 class="text-center">Type de stock</h5>
                                <select name="type_s" id="type-s-select" class="form-control">
                                    <option value="" disabled selected>Types</option>

                                </select>
                            </div>
                            <div class="col-4">
                                <h5 class="text-center">Caisse</h5>
                                <select name="caisse" id="caisse-select" class="form-control">
                                    <option value="" disabled selected>Caisses</option>
                                </select>
                            </div>

                        </div>


                    </div>
            </div>

        </div>

        <!-- Fin information atelier -->

        <!-- information Client -->
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mx-auto">
            <div class="card shadow m-1">

                <div class="card-body">
                    <H4 class="text-center">Information Client <i class="fa-solid fa-user-tie fa-lg"></i></H4>
                    <div class="row">
                        <div class="col-6">
                            <h5 class="text-center"> Client</h5>
                            <select name="client" id="client-select" class="form-control">
                                <option value="" disabled selected>Choisissez un Client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->nom_prenom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6">
                            <h5 class="text-center"> Crédit </h5>
                            <h4 class="text-center  digital " style="color:gray;" id="credet-select">

                                ----.-- DA</h4>
                        </div>
                    </div>


                </div>
            </div>

        </div>





        <!-- information Client -->
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mx-auto">
            <div class="card shadow m-1">

                <div class="card-body">

                    <div class="row">
                        <div class="col-6">
                            <h5 class="text-center">Type de vente </h5>
                            <select name="type" id="type-select" class="form-control" disabled>
                                <option value="" disabled selected>Choisissez un Type</option>
                                <option value="Details">Détails</option>
                                <option value="Semi-gros">Semi-gros</option>
                                <option value="Gros">Gros</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <h5 class="text-center">livraison <i class="fa-solid fa-truck  fa-lg"
                                    style="color: #a6546c;">
                                </i> </h5>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <label class="switch">
                                        <input type="checkbox" id="livraison-toggle">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="col">
                                    <input type="text" name="montant" id="montant-input" class="form-control digital"
                                        style="font-size: 25px; text-align: center; color:black;" placeholder="0.00 DA"
                                        disabled>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>

        </div>
        <!-- total -->
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mx-auto">
            <div class="card shadow m-1" style="background-color: #000000;">


                <div class="card-body  text-center">

                    <div class="row">
                        <div class="col-2">
                            <h2 class="digital3">TOTAL</h2>

                        </div>
                        <div class="col-10">
                            <h2 class="digital2" id="total_fact">0.00 <span class="digital3">DA</span> </h2>
                        </div>


                    </div>


                </div>
            </div>

        </div>


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mx-auto">
            <div class="card shadow m-1">

                <div class="card-body">

                    <!-- categorie et produit  -->
                    <div class="row">
                        <div class="col-3">
                            <h6 class="text-center"> Categories</h6>
                            <select name="categorie" id="categorie-select" class="form-control" disabled>
                                <option value="" disabled selected>Choisissez une catégorie</option>
                                <!-- Les options seront remplies par AJAX -->
                            </select>
                        </div>


                        <div class="col-3">
                            <h6 class="text-center"> Produits </h6>
                            <select name="produit" id="produit-select" class="form-control" disabled>
                                <option value="" disabled selected>Choisissez un produit</option>
                                <!-- Les options des produits seront chargées dynamiquement -->
                            </select>
                        </div>
                        <!-- <div class="col-2">
                            <h6 class="text-center"> Prix / Kg</h6>
                            <input type="text" name="prix" id="prix-input" class="form-control digital1 text-center"
                                placeholder="0000.00" readonly ></input>
                        </div> -->
                        <!-- LABEL -->

                        <div class="col-2">
                            <h6 class="text-center">Prix / Kg</h6>
                            <h6 style="color:black;" class="text-center digital" name="prix" id="prix-input" disabled>
                                0.00 DA
                            </h6>
                        </div>


                        <div class="col-1">
                            <h6 class="text-center "> Qantité</h6>
                            <input type="text" name="qantite" id="qantite" class="form-control digital1 text-center"
                                placeholder="00" disabled></input>
                        </div>

                        <div class="col-2">
                            <h6 class="text-center "> Total </h6>
                            <h6 class="text-center digital " id="total"> 0.00 DA </h6>

                        </div>

                        <div class="col-1">
                            <h6 class="text-center">Action</h6>
                            <!-- <input type="text" name="ajouter" class="form-control" placeholder=" "></input> -->


                            <button type="button" onclick="ajouter(this)" class="btn btn-success"
                                class="btn-description" disabled id="ajt">
                                <i class="fa-solid fa-plus  fa-lg"></i>
                            </button>
                        </div>


                    </div>
                    <!-- fin  -->
                    <br>

                    <div class="row">
                        <div class="col-12">
                            <div class="container mt-4">
                                <!-- Table of products -->
                                <table class="table-striped table-bordered col-12">

                                    <thead class="text-center">
                                        <tr>
                                            <th>Categorie </th>
                                            <th>Produit</th>
                                            <th>PU </th>
                                            <th>Q </th>
                                            <th>total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <!-- @foreach ($listes as $liste)
                                            <tr class="text-center">
                                                <td>{{$liste->categorie}}</td>
                                                <td>{{$liste->produit}}</td>
                                                <td>{{$liste->PU}} DA</td>
                                                <td>{{$liste->Q}}</td>
                                                <td>{{$liste->total}} DA</td>
                                                <td>
                                                    <button onclick="afficherSweetAlert({{ $liste->id }})"
                                                        style="background: none; border: none;">
                                                        <i class="fa-solid fa-circle-xmark fa-lg"
                                                            style="color: #f7224c;"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
            </form>
        </div>

        <!-- fin -->
    </div>
</div>


<!-- fucntion pour total de la facture -->






<!-- // Fonction pour charger les données des ventes a l'affichage -->
<script>
    function loadVentes(id_facture) {
        // Afficher un message de chargement
        const tbody = document.querySelector('table tbody');
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">Chargement...</td></tr>';

        // Effectuer une requête AJAX pour obtenir les données avec CSRF token
        fetch(`/list_ventes/${id_facture}`, {
            method: 'GET', // ou 'POST', selon votre type de requête
            headers: {
                'Content-Type': 'application/json', // Type de contenu JSON
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Token CSRF
            }
        })
            .then(response => response.json())
            .then(data => {
                // Vider le message de chargement
                tbody.innerHTML = '';

                // Si des données sont trouvées
                if (data.length > 0) {
                    // Remplir le tableau avec les nouvelles données
                    data.forEach(item => {
                        // Créer une nouvelle ligne (tr)
                        const row = document.createElement('tr');
                        row.classList.add('text-center');

                        // Ajouter les données dans les cellules (td)
                        row.innerHTML = `
                    <td>${item.categorie}</td>
                    <td>${item.produit}</td>
                    <td>${item.PU} DA</td>
                    <td>${item.Q}</td>
                    <td>${item.total} DA</td>
                    <td>
                        <button onclick="delet_(${item.id})" style="background: none; border: none;">
                            <i class="fa-solid fa-circle-xmark fa-lg" style="color: #f7224c;"></i>
                        </button>
                    </td>
                `;

                        // Ajouter la ligne au tableau
                        tbody.appendChild(row);
                    });
                } else {
                    // Si aucune donnée, afficher un message
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center">Aucune vente trouvée</td></tr>';
                }
            })
            .catch(error => {
                console.error('Erreur AJAX:', error);
                tbody.innerHTML = '<tr><td colspan="6" class="text-center text-danger">Erreur lors du chargement des données.</td></tr>';
                alert('Erreur lors du chargement des données.');
            });
    }




    // Appeler la fonction avec l'ID de la facture pour charger les données
    window.onload = function () {
        const id_facture = {{$facture->id}}; // Remplacer par l'ID de la facture actuel
        loadVentes(id_facture);
    };

</script>


<!-- total facture funciton  -->
<script>
    function updateTotalFact(id_facture) {
        fetch(`/facture/${id_facture}/total`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Vérifiez si les données contiennent une clé 'total'
                if (data.hasOwnProperty('total')) {
                    const totalElement = document.getElementById('total_fact');
                    totalElement.innerHTML = `${parseFloat(data.total).toFixed(2)} <span class="digital3">DA</span>`;
                } else {
                    console.error('Réponse JSON inattendue:', data);
                    alert('Erreur dans les données reçues.');
                }
            })
            .catch(error => {
                console.error('Erreur lors de la récupération du total:', error);
                alert('Impossible de mettre à jour le total.');
            });
    }

</script>


<!-- function pour ajouter un vente -->

<script>
    function ajouter(button) {
        // Récupérer les valeurs des champs
        const id_fact = {{$facture->id}}; // ID de la facture injecté depuis Blade
        const id_type = document.getElementById('type-s-select').value.trim(); // Correction de l'extraction
        const id_categorie = document.getElementById('categorie-select').value.trim();
        const id_produit = document.getElementById('produit-select').value.trim();
        const prix = parseFloat(document.getElementById('prix-input').innerText.trim()); // Conversion en nombre
        const quantite = parseInt(document.getElementById('qantite').value.trim());
        const total = parseFloat(document.getElementById('total').innerText.trim());



        // Vérifier que les champs obligatoires sont remplis
        if (!id_categorie || !id_produit || isNaN(quantite) || quantite <= 0) {
            // Afficher un message d'erreur avec SweetAlert2
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Veuillez remplir tous les champs correctement avant d\'ajouter.',
            });
            return;
        }

        // Désactiver le bouton pour éviter les clics multiples
        button.disabled = true;

        // Préparer les données à envoyer
        const data = {
            id_fact: id_fact,
            id_type: id_type,
            id_categorie: id_categorie,
            id_produit: id_produit,
            prix: prix,
            quantite: quantite,
            total: total
        };
        console.log("Données du produit à ajouter:", data);
        // Envoi des données via AJAX
        fetch('/add_vente', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erreur HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Réactiver le bouton
                button.disabled = false;

                // Afficher un message de succès avec SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: 'Produit ajouté avec succès!',
                    text: 'Le produit a été ajouté à la vente.',
                });

                // Réinitialiser les champs pour une nouvelle saisie (optionnel)
                document.getElementById('categorie-select').value = '';
                document.getElementById('produit-select').value = '';
                document.getElementById('prix-input').innerText = '0.00 DA';
                document.getElementById('qantite').value = '';
                document.getElementById('total').innerText = '0.00 DA';

                loadVentes(id_fact);
                updateTotalFact(id_fact)

            })
            .catch(error => {
                // Réactiver le bouton en cas d'erreur
                button.disabled = false;
                console.error('Erreur:', error);

                // Afficher un message d'erreur avec SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Une erreur s\'est produite',
                    text: 'Impossible d\'ajouter le produit, veuillez réessayer.',
                });
            });

    }
</script>


<!-- function pour supprimer une vente   -->
<script>
    // Fonction pour supprimer une vente
    // Fonction pour supprimer une vente
    function delet_(id_vente) {
        const id_fact = {{$facture->id}}; // ID de la facture injecté depuis Blade
        // Afficher une boîte de confirmation SweetAlert avant de procéder
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: 'Vous ne pourrez pas récupérer cette vente une fois supprimée !',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler',
            reverseButtons: true // pour inverser les boutons OK et Annuler
        }).then((result) => {
            if (result.isConfirmed) {
                // Effectuer une requête AJAX DELETE si l'utilisateur confirme
                fetch(`/delet_vente/${id_vente}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => {
                        if (response.ok) {
                            // Si la suppression est réussie, supprimer la ligne du tableau
                            const row = document.querySelector(`button[onclick="delet_(${id_vente})"]`).closest('tr');
                            row.remove();
                            updateTotalFact(id_fact)
                            // Afficher un message de succès avec SweetAlert
                            Swal.fire({
                                icon: 'success',
                                title: 'Vente supprimée',
                                text: 'La vente a été supprimée avec succès.',

                            });
                        } else {
                            // Afficher un message d'erreur avec SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: 'Erreur lors de la suppression de la vente.',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Erreur AJAX:', error);

                        // Afficher un message d'erreur avec SweetAlert en cas d'échec de la requête
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Erreur lors de la suppression de la vente.',
                            confirmButtonText: 'OK'
                        });
                    });
            } else {
                // Si l'utilisateur annule, vous pouvez afficher un message de confirmation de l'annulation si nécessaire
                Swal.fire({
                    icon: 'info',
                    title: 'Annulation',
                    text: 'La vente n\'a pas été supprimée.',

                });
            }
        });
    }

</script>


<!-- reset function  -->
<script>
    function reset() {
        const typeSelect = document.getElementById('type-select');
        const categorieSelect = document.getElementById('categorie-select');
        const produitSelect = document.getElementById('produit-select');

        const prixInput = document.getElementById('prix-input'); // Champ de prix
        const qantite = document.getElementById('qantite'); // Champ de quantité
        const total = document.getElementById('total'); // Affichage total

        const ajtButton = document.getElementById('ajt');

        ajtButton.disabled = true;

        // Réinitialiser les options de typeSelect
        typeSelect.innerHTML = `
            <option value="" disabled selected>Choisissez un Type</option>
            <option value="Details">Détails</option>
            <option value="Semi-gros">Semi-gros</option>
            <option value="Gros">Gros</option>
        `;
        typeSelect.disabled = true;

        // Réinitialiser et désactiver categorieSelect
        categorieSelect.innerHTML = `
            <option value="" disabled selected>Choisissez une catégorie</option>
        `;
        categorieSelect.disabled = true;

        // Réinitialiser et désactiver produitSelect
        produitSelect.innerHTML = `
            <option value="" disabled selected>Choisissez un produit</option>
        `;
        produitSelect.disabled = true;

        // Réinitialiser le champ prix
        prixInput.innerHTML = '0.00 DA'; // Si c'est un input, utilisez `.value`

        // Désactiver et réinitialiser le champ quantité
        qantite.value = '';
        qantite.disabled = true;

        // Réinitialiser le total
        total.innerHTML = '0.00 DA'; // Assurez-vous que total est un élément textuel, sinon utilisez `.value`

        console.log('Tous les champs ont été réinitialisés et désactivés.');
    }
</script>





<!-- script pour type de vente  -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sélection des éléments nécessaires
        const typeSelect = document.getElementById('type-select');
        const categorieSelect = document.getElementById('categorie-select');
        const produitSelect = document.getElementById('produit-select');
        const prixInput = document.getElementById('prix-input');
        const qantite = document.getElementById('qantite');
        const ajtButton = document.getElementById('ajt');

        // Désactiver les champs au départ
        categorieSelect.disabled = true;
        produitSelect.disabled = true;
        prixInput.disabled = true;
        qantite.disabled = true;
        ajtButton.disabled = true;

        // Écouter le changement du "Type de vente"
        typeSelect.addEventListener('change', function () {
            const selectedValue = this.value; // Récupérer la valeur choisie

            // Activer les autres champs
            categorieSelect.disabled = false;
            produitSelect.disabled = false;
            prixInput.disabled = false;
            qantite.disabled = false;
            ajtButton.disabled = false;

            console.log(`Type de vente sélectionné : ${selectedValue}`);

            // Appeler le deuxième script lorsque le type est changé
            $('#produit-select').trigger('change');


        });
    });
</script>








<script>
    document.addEventListener('DOMContentLoaded', function () {
        const prixInput = document.getElementById('prix-input'); // Élément Prix / Kg (h6)
        const qantiteInput = document.getElementById('qantite'); // Champ Quantité (input)
        const totalElement = document.getElementById('total');   // Élément Total (h6)

        // Fonction pour mettre à jour le total
        function updateTotal() {
            // Extraire le prix depuis le texte (en retirant " DA" à la fin)
            const prix = parseFloat(prixInput.textContent.replace(' DA', '')) || 0;
            const quantite = parseFloat(qantiteInput.value) || 0; // Récupérer la quantité (valeur numérique)
            const total = prix * quantite;                      // Calculer le total

            // Mettre à jour l'affichage du total
            totalElement.textContent = `${total.toFixed(2)} DA`;
        }

        // Écouter les changements sur le champ Quantité
        qantiteInput.addEventListener('input', updateTotal);
    });
</script>



{{-- script sauvegarder --}}
<script>
    function sauvegarder(button) {
        // Utilisez le bouton pour obtenir le formulaire parent
        const form = button.closest('.edit-form');

        // Vérifiez si le formulaire a été trouvé
        if (form) {

            Swal.fire({
                title: "Voulez- vous sauvegarder le client .. ? ",
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


<!-- script pour les produit  -->
<script>
    $(document).ready(function () {
        $('#categorie-select').on('change', function () {
            const categoryId = $(this).val();
            const produitSelect = $('#produit-select');
            const prixInput = $('#prix-input');
            const qantite = $('#qantite');
            const total = $('#total');


            const atelierId = $('#atelier-select').val();
            const type_sId = $('#type-s-select').val();
            // Vider le select des produits
            produitSelect.empty().append('<option value="" disabled selected>Chargement...</option>');

            // Effectuer une requête AJAX
            $.ajax({
                url: '/get-produits/' + categoryId + '/' + type_sId,

                method: 'GET',
                success: function (data) {
                    produitSelect.empty().append('<option value="" disabled selected>Choisissez un produit</option>');
                    data.forEach(produit => {
                        produitSelect.append('<option value="' + produit.id + '">' + produit.produit + '</option>');
                        // prixInput.val('');
                        prixInput.text('0.00 DA');
                        prixInput.attr('disabled', true);
                        qantite.attr('disabled', true);
                        qantite.val('');
                        total.text('0.00 DA');


                    });
                },
                error: function () {
                    produitSelect.empty().append('<option value="" disabled selected>Aucun produit trouvé</option>');
                }
            });
        });

    });

    // script pour prix produit 
    $(document).ready(function () {
        $('#produit-select').on('change', function () {
            const produitId = $(this).val();
            const prixInput = $('#prix-input');
            const qantite = $('#qantite');
            const total = $('#total');
            const typeSelect = $('#type-select').val(); // Récupérer le type sélectionné

            const atelierID = $('#atelierid');
            const type_s_ID = $('#type_s_id');
            if (produitId) {
                // Mettre des valeurs de chargement
                prixInput.val('Chargement...');
                total.text('Chargement');

                // Appeler l'API avec AJAX
                $.ajax({
                    url: '/get-prix/' + produitId,
                    method: 'GET',
                    success: function (data) {
                        if (data.prix_vente) {
                            let prixFormate;

                            // Vérifier le type sélectionné pour ajuster le prix
                            if (typeSelect === 'Details') {
                                prixFormate = parseFloat(data.prix_vente).toFixed(2);
                            } else if (typeSelect === 'Semi-gros') {
                                prixFormate = parseFloat(data.semi_gros).toFixed(2);
                            } else if (typeSelect === 'Gros') {
                                prixFormate = parseFloat(data.gros).toFixed(2);
                            } else {
                                prixFormate = '0.00'; // Valeur par défaut
                            }

                            // Mettre à jour le champ Prix
                            prixInput.text(`${prixFormate} DA`);

                            // Activer et réinitialiser le champ Quantité
                            qantite.removeAttr('disabled');
                            qantite.val('');
                            total.text('0.00 DA'); // Réinitialiser le total

                        } else {
                            // Si aucun prix disponible
                            prixInput.val('Prix non disponible');
                            qantite.attr('disabled', true);
                            total.text('0.00 DA');
                        }
                    },
                    error: function () {
                        // Gestion des erreurs
                        prixInput.val('Erreur');
                        qantite.attr('disabled', true);
                        total.text('Erreur');
                    }
                });
            }
        });
    });




</script>
<!-- fin  -->




<!-- script pour les caisses et type de stock   -->
<script>
    $(document).ready(function () {
        $('#atelier-select').on('change', function () {
            const atelierId = $(this).val();
            const caisseSelect = $('#caisse-select');
            const typeSelect = $('#type-s-select');
            const type_vent = $('#type');


            // Réinitialiser les listes déroulantes avec un message de chargement
            caisseSelect.empty().append('<option value="" disabled selected>Chargement des caisses...</option>');
            typeSelect.empty().append('<option value="" disabled selected>Chargement des types...</option>');

            // Récupérer les caisses
            $.ajax({
                url: '/get-caisses/' + atelierId, // URL pour récupérer les caisses
                method: 'GET',
                success: function (data) {
                    caisseSelect.empty().append('<option value="" disabled selected>Sélectionnez une caisse</option>');
                    if (data.length > 0) {
                        data.forEach(caisse => {
                            caisseSelect.append('<option value="' + caisse.id + '">' + caisse.code_caisse + '</option>');
                        });
                    } else {
                        caisseSelect.append('<option value="" disabled>Aucune caisse disponible</option>');
                    }
                },
                error: function () {
                    caisseSelect.empty().append('<option value="" disabled>Erreur de chargement</option>');
                }
            });

            // Récupérer les types
            $.ajax({
                url: '/get-stock-s/' + atelierId, // URL pour récupérer les types
                method: 'GET',
                success: function (data) {
                    typeSelect.empty().append('<option value="" disabled selected>Sélectionnez un type</option>');
                    if (data.length > 0) {
                        data.forEach(type => {
                            typeSelect.append('<option value="' + type.id + '">' + type.type + '</option>');
                        });
                    } else {
                        typeSelect.append('<option value="" disabled>Aucun type disponible</option>');
                    }
                },
                error: function () {
                    typeSelect.empty().append('<option value="" disabled>Erreur de chargement</option>');
                }
            });
            reset(typeSelect);

        });
    });
</script>

<!-- script pour les categories -->
<script>
    $(document).ready(function () {
        $('#type-s-select').on('change', function () {
            const atelierId = $(this).val(); // Notez l'utilisation correcte de 'atelierId'
            const le_type = $('#type-select');
            const categorieSelect = $('#categorie-select');

            const produitSelect = document.getElementById('produit-select');
            const prixInput = document.getElementById('prix-input'); // Champ de prix
            const qantite = document.getElementById('qantite'); // Champ de quantité
            const total = document.getElementById('total'); // Affichage total
            const ajtButton = document.getElementById('ajt');

            console.log(atelierId); // Correction ici : 'atelierId' au lieu de 'atelierID'

            // Réinitialiser le menu déroulant avec un message de chargement
            categorieSelect.empty().append('<option value="" disabled selected>Chargement...</option>');

            // Effectuer une requête AJAX pour récupérer les catégories associées à un stock_id donné
            $.ajax({
                url: '/get-categories/' + atelierId, // URL Laravel pour récupérer les catégories
                method: 'GET',
                success: function (data) {
                    // Vider le menu déroulant et ajouter une option de sélection
                    categorieSelect.empty().append('<option value="" disabled selected>Sélectionnez une catégorie</option>');

                    // Vérifier si des catégories ont été renvoyées
                    if (data.length > 0) {
                        // Ajouter les options de catégories au menu déroulant
                        data.forEach(function (categorie) {
                            categorieSelect.append('<option value="' + categorie.id + '">' + categorie.categorie_nom + '</option>');
                        });

                        // Réactiver le menu déroulant
                        le_type.prop('disabled', false);

                        // Désactiver le bouton Ajouter
                        ajtButton.disabled = true;

                        // Réinitialiser et désactiver categorieSelect
                        categorieSelect.innerHTML = `<option value="" disabled selected>Choisissez une catégorie</option> `;
                        categorieSelect.disabled = true;

                        // Réinitialiser et désactiver produitSelect
                        produitSelect.innerHTML = ` <option value="" disabled selected>Choisissez un produit</option>`;


                        // Réinitialiser le champ prix
                        prixInput.textContent = '0.00 DA';

                        // Désactiver et réinitialiser le champ quantité
                        qantite.value = '';
                        qantite.disabled = true;

                        // Réinitialiser le total
                        total.textContent = '0.00 DA'; // Assurez-vous que total est un élément textuel

                        // Log pour débogage
                        console.log('Tous les champs ont été réinitialisés et désactivés.');






















                    } else {
                        // Ajouter un message indiquant qu'il n'y a aucune catégorie
                        categorieSelect.append('<option value="" disabled>Aucune catégorie</option>');
                        categorieSelect.prop('disabled', true); // Désactiver si aucune catégorie
                    }
                },
                error: function () {
                    // Si une erreur survient lors de l'appel AJAX
                    categorieSelect.empty().append('<option value="" disabled>Erreur lors du chargement</option>');
                    categorieSelect.prop('disabled', true); // Désactiver si erreur
                }


            });


        });
    });
</script>


<!-- fin  -->


<!-- credet de client  -->
<script>
    $(document).ready(function () {
        $('#client-select').on('change', function () {
            const clientId = $(this).val();
            const credetSelect = $('#credet-select');

            // Réinitialiser la valeur et la couleur du crédit
            credetSelect.text('Chargement...').css('color', 'gray');

            // Effectuer une requête AJAX
            $.ajax({
                url: '/get-credet/' + clientId,
                method: 'GET',
                success: function (data) {
                    // Mettre à jour le contenu et la couleur selon la valeur
                    credetSelect.text(data + ' DA');

                    if (data == 0) {
                        credetSelect.css('color', 'green');
                    } else if (data < 10000) {
                        credetSelect.css('color', 'orange');
                    } else {
                        credetSelect.css('color', 'red');
                    }
                },
                error: function () {
                    // En cas d'erreur
                    credetSelect.text('Erreur').css('color', 'red');
                }
            });
        });
    });
</script>

<!-- fin  -->

<!-- LIVRISON BOUTON  -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('livraison-toggle');
        const montantInput = document.getElementById('montant-input');
        const prixInput = document.getElementById('prix-input');
        const qantite = document.getElementById('qantite');


        // Activer/Désactiver le champ input basé sur le switch
        toggle.addEventListener('change', function () {
            montantInput.disabled = !toggle.checked;
            if (toggle.checked) {
                montantInput.focus();  // Si activé, le focus sera sur le champ
            } else {
                montantInput.value = '';
            }
        });

        // Permettre uniquement les chiffres et le point pour l'input
        montantInput.addEventListener('input', function () {
            // Remplacer tout ce qui n'est pas un chiffre ou un point
            this.value = this.value.replace(/[^0-9.]/g, '');
        });

        // Permettre uniquement les chiffres et le point pour l'input
        prixInput.addEventListener('input', function () {
            // Remplacer tout ce qui n'est pas un chiffre ou un point
            this.value = this.value.replace(/[^0-9.]/g, '');
        });

        // Permettre uniquement les chiffres et le point pour l'input
        qantite.addEventListener('input', function () {
            // Remplacer tout ce qui n'est pas un chiffre ou un point
            this.value = this.value.replace(/[^0-9.]/g, '');
        });
    });

</script>

<!-- FIN  -->




<script>
    // Sélectionnez les éléments
    const produitSelect = document.getElementById('produit-select');
    const lePrix = document.getElementById('le_prix');

    // Ajoutez un écouteur d'événements pour détecter le changement
    produitSelect.addEventListener('change', function () {
        // Obtenez l'option sélectionnée
        const selectedOption = this.options[this.selectedIndex];
        const prix = selectedOption.getAttribute('data-prix'); // Récupérer l'attribut data-prix

        // Mettre à jour le texte dans le champ "Prix / Kg"
        lePrix.textContent = prix ? `${prix} DA` : '0000.00 DA';
    });
</script>



<script>
    // Sélectionnez les éléments
    const produitSelect = document.getElementById('produit-select');
    const lePrix = document.getElementById('le_prix');

    // Ajoutez un écouteur d'événements
    produitSelect.addEventListener('change', function () {
        // Obtenez l'option sélectionnée
        const selectedOption = this.options[this.selectedIndex];
        const prix = selectedOption.getAttribute('data-prix');

        // Mettez à jour le texte du champ "Prix / Kg"
        lePrix.textContent = prix ? `${prix} DA` : '0000.00 DA';
    });
</script>








<style>
    @font-face {
        font-family: 'digital-7';
        src: url('/fonts/digital-7.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    .digital {
        font-family: 'digital-7', sans-serif;
        font-size: 2rem;
        /* Ajustez la taille selon vos besoins */
        text-align: center;
        color: green;
    }

    .digital1 {
        font-family: 'digital-7', sans-serif;

        font-size: 1.2rem;
    }

    .digital2 {
        font-family: 'digital-7', sans-serif;
        color: green;
        font-size: 5rem;
        text-align: right;
        display: block;
    }

    .digital3 {
        font-family: 'digital-7', sans-serif;
        font-size: 1.6rem;
        /* Ajustez la taille selon vos besoins */
        text-align: left;
        color: green;
    }

    .digital4 {
        font-family: 'digital-7', sans-serif;

        color: green;
    }
</style>




<style>
    /* From Uiverse.io by gharsh11032000 */
    /* The switch - the box around the slider */
    .switch {
        font-size: 17px;
        position: relative;
        display: inline-block;
        width: 3.5em;
        height: 2em;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background: white;
        border-radius: 50px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.215, 0.610, 0.355, 1);
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 1.4em;
        width: 1.4em;
        right: 0.3em;
        bottom: 0.3em;
        transform: translateX(150%);
        background-color: #59d102;
        border-radius: inherit;
        transition: all 0.4s cubic-bezier(0.215, 0.610, 0.355, 1);
    }

    .slider:after {
        position: absolute;
        content: "";
        height: 1.4em;
        width: 1.4em;
        left: 0.3em;
        bottom: 0.3em;
        background-color: #C91616FF;
        border-radius: inherit;
        transition: all 0.4s cubic-bezier(0.215, 0.610, 0.355, 1);
    }

    .switch input:focus+.slider {
        box-shadow: 0 0 1px #59d102;
    }

    .switch input:checked+.slider:before {
        transform: translateY(0);
    }

    .switch input:checked+.slider::after {
        transform: translateX(-150%);
    }
</style>



@endsection
@extends('layouts.admin')
@section('content')

{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row d-flex justify-content-between align-items-center">
        <div class="col-2">
            <a href="{{ url('/admin/magasin') }}" class="btn btn-dark">
                <i class="fas fa-arrow-left pr-1"></i>
                <span class="btn-description"></span>
            </a>
        </div>
        <div class="col-8 text-center">
            <h2>stock {{$magasins->type}} {{$magasins->nom}} {{$magasins->id}} </h2>
        </div>
        <div class="col-2 text-right">

        </div>
    </div>

</div>


<div class="container" style="margin-top: 10px;">

    <div class="row animate__animated animate__backInLeft">

        <div class="card shadow col-12">

            <div class="card-body">

                <div class="row">
                    <div class="col-6">

                        <h5>Nom : {{$magasins->nom}} </h5>
                        <h5>type : {{$magasins->type}} </h5>
                        <h5>N° register : {{$magasins->N_reg}} </h5>
                        <h5>N° telephone : {{$magasins->tel}} </h5>
                        <h5>état :
                            @if ($magasins->activ = 1)
                                active
                            @else
                                non active
                            @endif
                        </h5>
                    </div>

                    @if (!empty($magasins->photo) && Storage::exists('public/' . $magasins->photo))
                        <div class="col-6  text-center">
                            <!-- <label for="">Photo :</label> -->
                            <img src="{{ asset('storage/' . $magasins->photo) }}" class="img-fluid rounded" alt=""
                                style="height:80%; width:100%; margin-top: 5px; cursor: pointer;" id="preview2"
                                onclick="triggerFileInput();">
                        </div>
                    @else
                        <div class="col-6  text-center">
                            <!-- <label for="">Photo :</label> -->
                            <img src="{{ asset('img/logo_vide/your_photo.jpg') }}" class="img-fluid rounded" alt=""
                                style="height:80%; width:100%; margin-top: 5px; cursor: pointer;" id="preview2"
                                onclick="triggerFileInput();">
                        </div>
                    @endif




                </div>
                <div class="row">
                    <div class="col-12 text-center">

                        <H1>STOCK</H1>
                    </div>

                    <div class="col-12">
                        <div class="container mt-4">


                            @if ($magasins->type == 'Atelier')


                                        <ul class="nav nav-tabs ">
                                            <li class="nav-item col-6  ">
                                                <a class="nav-link active bg-danger" id="frais-tab" aria-current="page" href="#"
                                                    onclick="showTab('frais'); return false;">Frais</a>
                                            </li>

                                            <li class="nav-item col-6">
                                                <a class="nav-link bg-primary " id="congele-tab" href="#"
                                                    onclick="showTab('congele'); return false;">Congelé</a>
                                            </li>
                                        </ul>

                                        <div id="frais-content" class="tab-content mt-3">
                                            <!-- Stock frais  -->
                                            <div>
                                                <h4 class="text-center">Frais {{$frais_id}} </h4>
                                                <button type="button" class="btn btn-success col-12" data-stk="" id="trans_frais">
                                                    Transfert
                                                </button>
                                            </div>
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" id="categoryTabs" role="tablist">
                                                @foreach ($stock_frais->groupBy('categorie') as $categorie => $produits)
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link @if ($loop->first) active @endif" id="tab-{{$categorie}}"
                                                            data-toggle="tab" href="#category-{{$loop->index}}" role="tab"
                                                            aria-controls="category-{{$loop->index}}" aria-selected="true">
                                                            {{$categorie}}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                @foreach ($stock_frais->groupBy('categorie') as $categorie => $produits)
                                                    <div class="tab-pane fade @if ($loop->first) show active @endif"
                                                        id="category-{{$loop->index}}" role="tabpanel"
                                                        aria-labelledby="tab-{{$categorie}}">

                                                        <!-- Table of products -->
                                                        <table class="table-striped table-bordered col-12">
                                                            <thead class="text-center">
                                                                <tr>

                                                                    <th>Produit</th>
                                                                    <th>Poid</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($produits as $produit)
                                                                    <tr>

                                                                        <td>{{$produit->produit}}</td>
                                                                        <td>{{ number_format($produit->quantity, 2) }} kg</td>

                                                                        <td class="text-center space-x-8">


                                                                            <button id="ajst-{{ $produit->id_frais }}" type="button"
                                                                                class="btn btn-outline-info"
                                                                                onclick="showAjustModal('{{ $produit->quantity }}','{{$produit->id_frais}}')">
                                                                                ajustier
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>

                                        <!-- Stock congele  -->
                                        <div id="congele-content" class="tab-content mt-3" style="display: none;">
                                            <div>
                                                <h4 class="text-center">congele {{$congele_id}} </h4>
                                                <button type="button" class="btn btn-success col-12" data-stk="{{$congele_id}}"
                                                    id="trans_congele">
                                                    Transfert
                                                </button>
                                            </div>

                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" id="categoryTabs" role="tablist">
                                                @foreach ($stock_congele->groupBy('categorie') as $categorie => $produits)
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link @if ($loop->first) active @endif" id="tab-{{$categorie}}"
                                                            data-toggle="tab" href="#category-{{$loop->index}}" role="tab"
                                                            aria-controls="category-{{$loop->index}}" aria-selected="true">
                                                            {{$categorie}}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                @foreach ($stock_congele->groupBy('categorie') as $categorie => $produits)
                                                    <div class="tab-pane fade @if ($loop->first) show active @endif"
                                                        id="category-{{$loop->index}}" role="tabpanel"
                                                        aria-labelledby="tab-{{$categorie}}">

                                                        <!-- Table of products -->
                                                        <table class="table-striped table-bordered col-12">
                                                            <thead class="text-center">
                                                                <tr>
                                                                    <th>Produit</th>
                                                                    <th>Poid</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($stock_congele as $congele)
                                                                    <tr>
                                                                        <td>{{$congele->produit}}</td>
                                                                        <td> {{ number_format($congele->quantity, 2) }} Kg</td>

                                                                        <td class="text-center space-x-8">
                                                                            <!-- <button id="ajst" type="button" class="btn btn-outline-info">
                                                                                                                                                                                                                                                                                                                                                                        ajustier
                                                                                                                                                                                                                                                                                                                                                                    </button> -->

                                                                            <button id="ajst-{{ $congele->id_congele }}" type="button"
                                                                                class="btn btn-outline-info"
                                                                                onclick="showAjustModal('{{ $congele->quantity }}' , '{{$congele->id_congele }}')">
                                                                                ajustier
                                                                            </button>



                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>


                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            @else

                                <!-- juste frais  -->


                                <div>
                                    <h4 class="text-center">Frais {{$frais_id}} </h4>
                                    <button type="button" class="btn btn-primary" data-stk="frais" id="trans_frais">
                                        Transfert
                                    </button>
                                </div>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" id="categoryTabs" role="tablist">
                                    @foreach ($stock_frais->groupBy('categorie') as $categorie => $produits)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link @if ($loop->first) active @endif" id="tab-{{$categorie}}"
                                                data-toggle="tab" href="#category-{{$loop->index}}" role="tab"
                                                aria-controls="category-{{$loop->index}}" aria-selected="true">
                                                {{$categorie}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    @foreach ($stock_frais->groupBy('categorie') as $categorie => $produits)
                                        <div class="tab-pane fade @if ($loop->first) show active @endif" id="category-{{$loop->index}}"
                                            role="tabpanel" aria-labelledby="tab-{{$categorie}}">

                                            <!-- Table of products -->
                                            <table class="table-striped table-bordered col-12">
                                                <thead class="text-center">
                                                    <tr>

                                                        <th>Produit</th>
                                                        <th>Poid</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($produits as $produit)
                                                        <tr>

                                                            <td>{{$produit->produit}}</td>
                                                            <td>{{ number_format($produit->quantity, 2) }} Kg</td>
                                                            <td class="text-center space-x-8">


                                                                <button id="ajst-{{ $produit->id_frais }}" type="button"
                                                                    class="btn btn-outline-info"
                                                                    onclick="showAjustModal('{{ $produit->quantity }}','{{$produit->id_frais}}')">
                                                                    ajustier
                                                                </button>

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                </div>


                            @endif
                </div>

            </div>



        </div>


        <script>
            function showTab(tabName) {
                // Masquer tous les contenus
                document.getElementById('frais-content').style.display = 'none';
                document.getElementById('congele-content').style.display = 'none';

                // Afficher le contenu correspondant
                document.getElementById(tabName + '-content').style.display = 'block';

                // Enlever la classe 'active' de tous les onglets
                document.getElementById('frais-tab').classList.remove('active');
                document.getElementById('congele-tab').classList.remove('active');

                // Ajouter la classe 'active' à l'onglet sélectionné
                document.getElementById(tabName + '-tab').classList.add('active');
            }
        </script>








        <script>
            document.getElementById('trans_frais').addEventListener('click', async () => {
                const id_atl = 'frais'; // stock frais
                const id_magasin = {{$magasins->id}}; // ID du stock frais
                const magasins = {
                    @foreach ($lesmagasins as $lemagasin)
                        "{{ $lemagasin->id }}": "{{ $lemagasin->nom }}",
                    @endforeach
            };

            const { value: selectedMagasin } = await Swal.fire({
                title: "Sélectionnez un magasin",
                input: "select",
                inputOptions: magasins, // Utiliser l'objet magasins ici
                inputPlaceholder: "Sélectionnez un magasin",
                showCancelButton: true,
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (value) {
                            resolve();
                        } else {
                            resolve("Vous devez sélectionner un magasin :)");
                        }
                    });
                }
            });

            if (selectedMagasin) {
                const result = await Swal.fire({
                    title: `Voulez-vous transférer du stock de magasin ${id_magasin} de atl : {{$frais_id}} vers le magasin : ${magasins[selectedMagasin]} avec l'ID = ${selectedMagasin} ?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Oui, transférer !",
                    cancelButtonText: "Annuler"
                });

                // Si l'utilisateur confirme le transfert
                if (result.isConfirmed) {
                    // Rediriger vers la route de transfert avec les paramètres id_atl et id_magasin
                    window.location.href = `/admin/transfert/${id_atl}/${selectedMagasin}/${id_magasin}`;
                }
            }
    });
        </script>


        <script>
            document.getElementById('trans_congele').addEventListener('click', async () => {
                const id_atl = 'frais'; // stock frais
                const id_magasin = {{$magasins->id}}; // ID du stock frais
                const magasins = {
                    @foreach ($lesmagasins as $lemagasin)
                        "{{ $lemagasin->id }}": "{{ $lemagasin->nom }}",
                    @endforeach
            };

            const { value: selectedMagasin } = await Swal.fire({
                title: "Sélectionnez un magasin",
                input: "select",
                inputOptions: magasins, // Utiliser l'objet magasins ici
                inputPlaceholder: "Sélectionnez un magasin",
                showCancelButton: true,
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (value) {
                            resolve();
                        } else {
                            resolve("Vous devez sélectionner un magasin :)");
                        }
                    });
                }
            });

            if (selectedMagasin) {
                const result = await Swal.fire({
                    title: `Voulez-vous transférer du stock de magasin ${id_magasin} de atl : {{$congele_id}} vers le magasin : ${magasins[selectedMagasin]} avec l'ID = ${selectedMagasin} ?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Oui, transférer !",
                    cancelButtonText: "Annuler"
                });

                // Si l'utilisateur confirme le transfert
                if (result.isConfirmed) {
                    // Rediriger vers la route de transfert avec les paramètres id_atl et id_magasin
                    window.location.href = `/admin/transfert_congele/${id_atl}/${selectedMagasin}/${id_magasin}`;
                }
            }
    });
        </script>


        <!---------------------------------------------      script pour le bouton ajustier       -------------------------------------->
        <script>
            function showAjustModal(quantity, id) {
                // Supprimer 'const' car 'quantity' est déjà un paramètre
                quantity = parseFloat(quantity).toFixed(2);  // Convertir en nombre avec 2 décimales si nécessaire
                Swal.fire({
                    title: "Ajuster le produit",
                    text: "Modifiez la quantité si nécessaire pour le produit ID : " + id,  // Afficher l'ID du produit

                    input: 'number',  // Champ input pour la quantité
                    inputLabel: 'Quantité actuelle',
                    inputValue: quantity,  // Valeur actuelle de la quantité
                    showCancelButton: true,
                    confirmButtonText: 'Enregistrer',
                    cancelButtonText: 'Annuler',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Vous devez entrer une quantité valide !';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Action après confirmation
                        const newQuantity = parseFloat(result.value);  // Convertir la nouvelle valeur en nombre

                        // Envoyer la nouvelle quantité et l'ID au contrôleur via AJAX
                        $.ajax({
                            url: '/mettre-a-jour-quantite',  // L'URL vers laquelle envoyer les données
                            method: 'POST',  // Utiliser la méthode POST
                            data: {
                                _token: '{{ csrf_token() }}',  // Inclure le jeton CSRF pour la sécurité
                                id: id,  // ID du produit
                                quantity: newQuantity  // Nouvelle quantité
                            },
                            success: function (response) {
                                // Afficher une notification de succès après la mise à jour
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Quantité mise à jour',
                                    text: `Nouvelle quantité: ${newQuantity} Kg`,  // Afficher la nouvelle quantité
                                });
                                location.reload();
                            },
                            error: function (error) {
                                // Afficher un message d'erreur si la requête échoue
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erreur',
                                    text: "La mise à jour de la quantité a échoué.",
                                });
                            }
                        });
                    }
                });
            }
        </script>





        <!-- ------------------------------------------------------------------------------------------------------------------------ -->
        @endsection
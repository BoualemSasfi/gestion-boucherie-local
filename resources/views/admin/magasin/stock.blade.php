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
            <h2>{{$magasins->type}} {{$magasins->nom}}
                <!-- {{$magasins->id}} -->
            </h2>
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
                        <h2 class="text-center">Information </h2>
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

                        <H1>STOCK <i class="fa-solid fa-boxes-stacked fa-bounce fa-xl" style="color: #6d3134;"></i>
                        </H1>
                    </div>

                    <div class="col-12">
                        <div class="container mt-4">


                            @if ($magasins->type == 'Atelier')


                                        <ul class="nav nav-tabs ">
                                            <li class="nav-item col-6  ">
                                                <a class="nav-link active bg-danger" id="frais-tab" aria-current="page" href="#"
                                                    onclick="showTab('frais'); return false;">
                                                    <H5 class="text-center" style="color:white;"><i class="fa-solid fa-fire fa-lg"
                                                            style="color: #eceff4;"> F r a i s </i></H5>


                                                </a>
                                            </li>

                                            <li class="nav-item col-6">
                                                <a class="nav-link bg-primary " id="congele-tab" href="#"
                                                    onclick="showTab('congele'); return false;">
                                                    <H5 class="text-center" style="color:white;"><i
                                                            class="fa-solid fa-snowflake fa-lg" style="color: #eceff4;"> C o n g e l
                                                            e </i> </H5>


                                                </a>
                                            </li>
                                        </ul>

                                        <div id="frais-content" class="tab-content mt-3">
                                            <!-- Stock frais  -->
                                            <div>
                                                <!-- <h4 class="text-center">Frais {{$frais_id}} </h4> -->
                                                <button type="button" class="btn btn-success col-12" data-stk="" id="trans_frais">
                                                    <h5>Transfert <i class="fa-solid fa-right-left fa-flip fa-lg"
                                                            style="color: #dfe4ec;"></i></h5>
                                                </button>
                                            </div>
                                            <br>
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
                                                                                onclick="showAjustModal('{{ $produit->quantity }}','{{$produit->id_frais}}','{{$magasins->nom}}','{{ Auth::user()->name }}','{{$produit->produit}}','{{$categorie}}')">
                                                                                ajustier <i class="fa-solid fa-arrows-rotate fa-spin fa-sm" style="color: #63E6BE;"></i>
                                                                            </button>
                                                                            <!-- <div class="text-center">
                                                                                                                        <button type="button" class="btn btn-outline-primary"
                                                                                                                            onclick="collectData('{{ $produit->quantity }}','{{$produit->id_frais}}','{{$magasins->nom}}','{{ Auth::user()->name }}','{{$produit->produit}}','{{$categorie}}')">collect
                                                                                                                            data</button>
                                                                                                                    </div> -->
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>

                                        <!-- new congele  -->


                                        <!-- fin congele  -->



                                        <!-- Stock congele  -->
                                        <div id="congele-content" class="tab-content mt-3" style="display: none;">
                                            <div class="">


                                                <!-- <h4 class="text-center">Congelé {{ $congele_id }}</h4> -->
                                                <button type="button" class="btn btn-success col-12 " data-stk="{{ $congele_id }}"
                                                    id="trans_congele">
                                                    <h5>Transfert <i class="fa-solid fa-right-left fa-flip fa-lg"
                                                            style="color: #dfe4ec;"></i></h5>
                                                </button>
                                            </div>
                                            <br>

                                            <!-- Onglets de catégories -->
                                            <ul class="nav nav-tabs" id="categoryTabs" role="tablist">
                                                @foreach ($stock_congele->groupBy('categorie') as $index => $produits)
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link @if ($loop->first) active @endif" id="tab-{{ $index }}"
                                                            data-toggle="tab" href="#category-{{ $index }}" role="tab"
                                                            aria-controls="category-{{ $index }}"
                                                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                            {{ $index }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>

                                            <!-- Contenu des onglets -->
                                            <div class="tab-content">
                                                @foreach ($stock_congele->groupBy('categorie') as $index => $produits)
                                                    <div class="tab-pane fade @if ($loop->first) show active @endif"
                                                        id="category-{{ $index }}" role="tabpanel" aria-labelledby="tab-{{ $index }}">

                                                        <!-- Tableau des produits -->
                                                        <table class="table-striped table-bordered col-12">
                                                            <thead class="text-center">
                                                                <tr>
                                                                    <th>Produit</th>
                                                                    <th>Poids</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($produits as $congele)
                                                                    <tr>
                                                                        <td>{{ $congele->produit }}</td>
                                                                        <td>{{ number_format($congele->quantity, 2) }} Kg</td>


                                                                        <td class="text-center">

                                                                            <button id="ajst-{{ $congele->id_congele }}" type="button"
                                                                                class="btn btn-outline-info"
                                                                                onclick="showAjustModal('{{ $congele->quantity }}','{{ $congele->id_congele }}','{{$magasins->nom}}','{{ Auth::user()->name }}','{{$congele->produit}}','{{$categorie}}')">
                                                                                ajustier <i class="fa-solid fa-arrows-rotate fa-spin fa-sm" style="color: #63E6BE;"></i>
                                                                            </button>
                                                                            <!-- <div class="text-center">
                                                                                                                                            <button type="button" class="btn btn-outline-primary"
                                                                                                                                                onclick="collectData('{{ $congele->quantity }}','{{$congele->id_congele}}','{{$magasins->nom}}','{{ Auth::user()->name }}','{{$congele->produit}}','{{$categorie}}')">collect
                                                                                                                                                data</button>
                                                                                                                                        </div> -->
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

                                <!-- juste frais  magasin-->


                                <div>
                                    <!-- <h4 class="text-center">Frais {{$frais_id}} </h4> -->
                                    <button type="button" class="btn btn-primary col-12" data-stk="frais" id="retour">
                                        <h5> Retoure... <i class="fa-solid fa-rotate-left fa-spin fa-spin-reverse fa-lg"
                                                style="color: #e6e9ef;"></i></h5>

                                    </button>
                                </div>
                                <br>
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
                                                                    onclick="showAjustModal('{{ $produit->quantity }}','{{$produit->id_frais}}','{{$magasins->nom}}','{{ Auth::user()->name }}','{{$produit->produit}}','{{$categorie}}')">
                                                                    ajustier <i class="fa-solid fa-arrows-rotate fa-spin fa-sm" style="color: #63E6BE;"></i>
                                                                </button>
                                                                <!-- <div class="text-center">
                                                                                        <button type="button" class="btn btn-outline-primary"
                                                                                            onclick="collectData('{{ $produit->quantity }}','{{$produit->id_frais}}','{{$magasins->nom}}','{{ Auth::user()->name }}','{{$produit->produit}}','{{$categorie}}')">collect
                                                                                            data</button>
                                                                                    </div> -->
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
                    title: `Voulez-vous transférer du stock vers le magasin  ${magasins[selectedMagasin]}  ?`,
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



        <!-- retoure -->

        <script>
            document.getElementById('retour').addEventListener('click', async () => {
                const id_atl = 'frais'; // stock frais
                const id_magasin = {{$magasins->id}}; // ID du stock frais
                const magasins = {
                    @foreach ($lesmagasins as $lemagasin)
                        "{{ $lemagasin->id }}": "{{ $lemagasin->nom }}",
                    @endforeach
                    // a changer ajouter que les atelier
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
                    title: `Voulez-vous faire un retoure vers ${magasins[selectedMagasin]}  ?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Oui, transférer !",
                    cancelButtonText: "Annuler"
                });

                // Si l'utilisateur confirme le transfert
                if (result.isConfirmed) {
                    // Rediriger vers la route de transfert avec les paramètres id_atl et id_magasin
                    window.location.href = `/admin/retour/${id_atl}/${selectedMagasin}/${id_magasin}`;
                }
            }
    });
        </script>

        <!-- fin  -->

        <!-- transfert congele -->
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
                    title: `Voulez-vous transférer du stock  vers le magasin : ${magasins[selectedMagasin]}  ?`,
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




        <script>
            function collectData(quantity, id, magasin, user, produit, categorie) {
                let stockData = [];
                // Ajout des valeurs supplémentaires atl, mag et user
                let etat = 0;

                if (quantity > 100) {
                    etat = 1;  // Si la nouvelle quantité est inférieure à l'ancienne, état 1
                } else if (quantity < 100) {
                    etat = 0;  // Si la nouvelle quantité est supérieure, état 0
                }

                stockData.push({
                    id: id,
                    quantity: quantity,
                    magasin: magasin,
                    user: user,
                    categorie: categorie,
                    produit: produit,
                    etat: etat
                });

                console.table(stockData);



            }

            // Appeler cette fonction lorsque vous voulez collecter et afficher les données
            collectData();

        </script>

        <script>
            function showAjustModal(quantity, id, magasin, user, produit, categorie) {
                quantity = parseFloat(quantity).toFixed(2);  // Convertir en nombre avec 2 décimales si nécessaire

                Swal.fire({
                    title: "Ajuster le produit",
                    text: "Modifiez la quantité si nécessaire pour le produit ID : " + id,
                    input: 'number',
                    inputLabel: 'Quantité actuelle',
                    inputValue: quantity,
                    showCancelButton: true,
                    confirmButtonText: 'Enregistrer',
                    cancelButtonText: 'Annuler',
                    inputValidator: (value) => {
                        if (!value || isNaN(value) || value <= 0) {
                            return 'Vous devez entrer une quantité valide et supérieure à 0 !';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const newQuantity = parseFloat(result.value);  // Convertir la nouvelle valeur en nombre
                        let etat = 0;

                        if (quantity > newQuantity) {
                            etat = 1;  // Si la nouvelle quantité est inférieure à l'ancienne, état 1
                        } else if (quantity < newQuantity) {
                            etat = 0;  // Si la nouvelle quantité est supérieure, état 0
                        }

                        // Stocker les données dans un objet stockData
                        let stockData = {
                            id: id,
                            quantity: newQuantity,
                            magasin: magasin,
                            user: user,
                            categorie: categorie,
                            produit: produit,
                            etat: etat
                        };

                        console.table(stockData);

                        // Envoyer stockData via AJAX au contrôleur
                        $.ajax({
                            url: '/mettre-a-jour-quantite',  // L'URL vers laquelle envoyer les données
                            method: 'POST',  // Utiliser la méthode POST
                            data: {
                                _token: '{{ csrf_token() }}',  // Inclure le jeton CSRF pour la sécurité
                                stockData: stockData  // Envoyer tout l'objet stockData
                            },
                            success: function (response) {
                                // Afficher une notification de succès après la mise à jour
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Quantité mise à jour',
                                    text: `Nouvelle quantité: ${newQuantity} Kg`,  // Afficher la nouvelle quantité
                                });
                                location.reload();  // Rafraîchir la page après la mise à jour
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
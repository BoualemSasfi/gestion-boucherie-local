@extends('layouts.admin')
@section('content')

<div class="container" id="titre-page">
    <div class="row d-flex justify-content-between align-items-center">
        <div class="col-2">
            <a href="{{ url('/admin/magasin') }}" class="btn btn-dark">
                <i class="fas fa-arrow-left pr-1"></i>
                <span class="btn-description"></span>
            </a>
        </div>
        <div class="col-8 text-center">
            <h2>Transfert de {{ $lemagasin->nom }} {{$lemagasin->id}} vers {{ $magasins1->nom }} {{$magasins1->id}}
            </h2>
            <h2>{{ Auth::user()->name }}</h2>

        </div>
    </div>

    <div>
        <ul class="nav nav-tabs">
            @foreach ($liste_cats as $index => $cat)
                <li class="nav-item">
                    <a class="nav-link {{ $index === 0 ? 'active' : '' }}" id="{{ $cat->categorie_id }}-tab" href="#"
                        onclick="showTab('{{ $cat->categorie_id }}'); return false;">
                        {{ $cat->categorie }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="tab-content">
        @foreach ($liste_cats as $index => $cat)
            <div id="tab-content-{{ $cat->categorie_id }}" class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}">
                <div>
                    <label class="col-2"></label>
                    <label class="col-2">{{ $lemagasin->nom }}</label>
                    <label class="col-2">À ajouter</label>
                    <label class="col-2">{{ $magasins1->nom }}</label>
                </div>
                @foreach ($stocks as $stock)
                    @if ($stock->id_cat == $cat->categorie_id)
                        <div class="d-flex align-items-center mb-3">
                            <label class="col-2">{{ $stock->produit }}</label>
                            {{ $stock->id_stock_2 }}
                            <input name="poid_magasin_2" class="col-2" type="number" value="{{ $stock->poid_magasin_2 }}" readonly
                                id="poid_magasin_2_{{ $stock->id_stock_2 }}">

                            <input name="poid_ajouter" class="col-2" type="number" value=""
                                oninput="updateWeights({{ $stock->id_stock_1 }}, {{ $stock->id_stock_2 }}, this.value)">
                            {{ $stock->id_stock_1 }}
                            <input name="poid_magasin_1" class="col-2" type="number" value="{{ $stock->poid_magasin_1 }}" readonly
                                id="poid_magasin_1_{{ $stock->id_stock_1 }}">

                            <input type="hidden" id="original_poid_magasin_1_{{ $stock->id_stock_1 }}"
                                value="{{ $stock->poid_magasin_1 }}">
                            <input type="hidden" id="original_poid_magasin_2_{{ $stock->id_stock_2 }}"
                                value="{{ $stock->poid_magasin_2 }}">
                        </div>

                    @endif

                @endforeach


            </div>
        @endforeach
    </div>

    <div class="text-center">
        <button type="button" class="btn btn-outline-primary" id="btn-validate-transfer">Valider le transfert</button>
    </div>

    <div class="text-center">
        <button type="button" class="btn btn-outline-primary" onclick="collectData()">collect data</button>
    </div>

    <script>
        function collectData() {
            let stockData = [];

            // Boucle à travers les catégories
            @foreach ($liste_cats as $index => $cat)
                @foreach ($stocks as $stock)
                    if ({{ $stock->id_cat }} === {{ $cat->categorie_id }}) {
                        let poidMagasin1 = document.getElementById("poid_magasin_1_{{ $stock->id_stock_1 }}").value;
                        let poidMagasin2 = document.getElementById("poid_magasin_2_{{ $stock->id_stock_2 }}").value;

                        // Ajouter les informations de catégorie, produit, ID et poids pour chaque magasin
                        stockData.push({

                            id: {{ $stock->id_stock_1 }},  // ID stock magasin 1
                            categorie: "{{$stock->categorie}}",
                            produit: "{{$stock->produit}}",
                            poid: poidMagasin1  // Poids magasin 1
                        });

                        stockData.push({

                            id: {{ $stock->id_stock_2 }},  // ID stock magasin 2
                            categorie: "{{$stock->categorie}}",
                            produit: "{{$stock->produit}}",
                            poid: poidMagasin2  // Poids magasin 2
                        });
                    }
                @endforeach
            @endforeach

            // Afficher le tableau dans la console avec catégorie, produit, ID et poids


            // Ajout des valeurs supplémentaires atl, mag et user
            stockData.push({
                atl: "{{ $lemagasin->nom }}",  // Ajout de $atl
                mag: "{{ $magasins1->nom }}",  // Ajout de $mag
                user: "{{ Auth::user()->name }}" // Ajout de $user
            });

            console.table(stockData);
        }

        // Appeler cette fonction lorsque vous voulez collecter et afficher les données
        collectData();


    </script>

    <script>
        document.getElementById('btn-validate-transfer').addEventListener('click', function () {
            Swal.fire({
                title: 'Voulez-vous valider ce transfert?',
                text: "Cette action est irréversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, valider!',
                cancelButtonText: 'Non, annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    let stockData = [];

                    @foreach ($liste_cats as $index => $cat)
                        @foreach ($stocks as $stock)
                            if ({{ $stock->id_cat }} === {{ $cat->categorie_id }}) {
                                let poidMagasin1 = document.getElementById("poid_magasin_1_{{ $stock->id_stock_1 }}").value;
                                let poidMagasin2 = document.getElementById("poid_magasin_2_{{ $stock->id_stock_2 }}").value;

                                // Ajouter les informations de catégorie, produit, ID et poids pour chaque magasin
                                stockData.push({

                                    id: {{ $stock->id_stock_1 }},  // ID stock magasin 1
                                    categorie: "{{$stock->categorie}}",
                                    produit: "{{$stock->produit}}",
                                    poid: poidMagasin1  // Poids magasin 1
                                });

                                stockData.push({

                                    id: {{ $stock->id_stock_2 }},  // ID stock magasin 2
                                    categorie: "{{$stock->categorie}}",
                                    produit: "{{$stock->produit}}",
                                    poid: poidMagasin2  // Poids magasin 2
                                });
                            }
                        @endforeach
                    @endforeach


                    console.table(stockData);

                    // Ajout des valeurs supplémentaires atl, mag et user
                    stockData.push({
                        atl: "{{ $lemagasin->nom }}",  // Ajout de $atl
                        mag: "{{ $magasins1->nom }}",  // Ajout de $mag
                        user: "{{ Auth::user()->name }}" // Ajout de $user
                    });


                    console.table(stockData); // Affiche le tableau dans la console

                    // Message d'attente avant l'envoi
                    Swal.fire({
                        title: 'Envoi en cours...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Envoi des données via AJAX
                    fetch('{{ route("validtransfert") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json' // Indique que vous envoyez des données JSON
                        },
                        body: JSON.stringify(stockData) // Envoi des données
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Erreur réseau: ' + response.statusText);
                            }
                            return response.json();
                        })
                        .then(data => {
                            Swal.close();
                            if (data.success) {
                                Swal.fire('Succès!', 'Le transfert a été validé.', 'success');
                            } else {
                                Swal.fire('Erreur!', data.message || 'Une erreur s\'est produite.', 'error');
                            }
                        })
                        .catch(error => {
                            Swal.close();
                            console.error('Erreur AJAX: ', error); // Capturez les erreurs dans la console
                            Swal.fire('Erreur!', 'Une erreur interne s\'est produite: ' + error.message, 'error');
                        });
                }
            });
        });
    </script>





    <script>
        function showTab(catId) {
            document.querySelectorAll('.tab-pane').forEach(function (tab) {
                tab.classList.remove('show', 'active');
            });

            document.getElementById('tab-content-' + catId).classList.add('show', 'active');

            document.querySelectorAll('.nav-link').forEach(function (link) {
                link.classList.remove('active');
            });

            document.getElementById(catId + '-tab').classList.add('active');
        }

        function updateWeights(stock1Id, stock2Id, poidAjouter) {
            let poidMagasin1 = document.getElementById('poid_magasin_1_' + stock1Id);
            let poidMagasin2 = document.getElementById('poid_magasin_2_' + stock2Id);

            let originalPoidMagasin1 = parseFloat(document.getElementById('original_poid_magasin_1_' + stock1Id).value) || 0;
            let originalPoidMagasin2 = parseFloat(document.getElementById('original_poid_magasin_2_' + stock2Id).value) || 0;

            let poidAjouterValue = parseFloat(poidAjouter) || 0;

            if (poidAjouterValue < 0 || poidAjouterValue > originalPoidMagasin2) {

                Swal.fire({
                    title: "La quantité ajoutée ne peut pas être négative ou dépasser le stock disponible.",

                    icon: "error"
                });
                document.querySelector(`[name="poid_ajouter"]`).value = '';
                poidMagasin2.value = originalPoidMagasin2;
                poidMagasin1.value = originalPoidMagasin1;
                return;
            }

            if (poidMagasin1 && poidMagasin2) {
                poidMagasin2.value = originalPoidMagasin2 - poidAjouterValue;
                poidMagasin1.value = originalPoidMagasin1 + poidAjouterValue;

                poidMagasin2.style.backgroundColor = (poidMagasin2.value == 0) ? 'red' :

                    (poidMagasin2.value <= 10) ? 'orange' : '';

                poidMagasin1.style.backgroundColor = (poidMagasin1.value == 0) ? 'red' :
                    (poidMagasin1.value <= 10) ? 'orange' : '';
            }
        }
    </script>
    @endsection
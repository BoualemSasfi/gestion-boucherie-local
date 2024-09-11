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
            <h2>Transfert de {{ $lemagasin->nom }} vers {{ $magasins1->nom }}</h2>
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

    <script>
        document.getElementById('btn-validate-transfer').addEventListener('click', function () {
            // Affichage de SweetAlert2 pour confirmer l'action
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
                    // Si l'utilisateur confirme, envoyer les données via AJAX
                    let formData = new FormData();

                    // Boucler pour ajouter les données des champs d'input
                    document.querySelectorAll('input[name="poid_ajouter"]').forEach(function (input, index) {
                        formData.append('poids_ajouter[' + index + ']', input.value);
                    });

                    document.querySelectorAll('input[name="poid_magasin_1"]').forEach(function (input, index) {
                        formData.append('poids_magasin_1[' + index + ']', input.value);
                    });

                    document.querySelectorAll('input[name="poid_magasin_2"]').forEach(function (input, index) {
                        formData.append('poids_magasin_2[' + index + ']', input.value);
                    });

                    // Envoi des données via AJAX à Laravel
                    fetch('{{ route("validtransfert") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Succès!', 'Le transfert a été validé.', 'success');
                            } else {
                                Swal.fire('Erreur!', 'Une erreur s\'est produite.', 'error');
                            }
                        }).catch(error => {
                            Swal.fire('Erreur!', 'Une erreur s\'est produite.', 'error');
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
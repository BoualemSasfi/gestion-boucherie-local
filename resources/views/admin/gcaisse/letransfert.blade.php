@extends('layouts.admin')
@section('content')

<div class="container" id="titre-page">
    <div class="row d-flex justify-content-between align-items-center">
        <div class="col-2">
            <a href="{{ url('/admin/caisse') }}" class="btn btn-dark">
                <i class="fas fa-arrow-left pr-1"></i>
                <span class="btn-description"></span>
            </a>
        </div>
        <div class="col-8 text-center">
            <h2>Transfert de {{ $caisse1->solde }} {{ $caisse1->id_magasin }} valeurs {{ $caisse2->solde }}
                {{ $caisse2->id_magasin }}
            </h2>
            <h2>{{ Auth::user()->name }}</h2>
        </div>
    </div>

    <div class="tab-content">
        <div>
            <label class="col-2"></label>
            <label class="col-2">{{ $caisse1->id_magasin }}</label>
            <label class="col-2">À ajouter</label>
            <label class="col-2">{{ $caisse2->id_magasin }}</label>
        </div>

        <div class="d-flex align-items-center mb-3">
            {{ $caisse1->id }}
            <input name="solde_caisse_1" class="col-2" type="number" value="{{ $caisse1->solde }}" readonly
                id="solde_caisse_1_{{ $caisse1->id }}">

            <input name="solde_ajouter" class="col-2" type="number" value="" id="solde_ajouter_{{ $caisse1->id }}"
                oninput="updateBalances({{ $caisse1->id }}, {{ $caisse2->id }}, this.value)">

            {{ $caisse2->id }}
            <input name="solde_caisse_2" class="col-2" type="number" value="{{ $caisse2->solde }}" readonly
                id="solde_caisse_2_{{ $caisse2->id }}">

            <input type="hidden" id="original_solde_caisse_1_{{ $caisse1->id }}" value="{{ $caisse1->solde }}">
            <input type="hidden" id="original_solde_magasin_2_{{ $caisse2->id }}" value="{{ $caisse2->solde }}">
        </div>
    </div>

    <div class="text-center">

        <button type="button" class="btn btn-outline-primary" id="btn-validate-transfer"
            onclick="validateTransfer()">Valider le transfert</button>
    </div>


    <script>
        function updateBalances(caisse1Id, caisse2Id, soldeAjouter) {
            // Récupération des éléments HTML avec les bons IDs
            let soldeCaisse1 = document.getElementById('solde_caisse_1_' + caisse1Id);
            let soldeCaisse2 = document.getElementById('solde_caisse_2_' + caisse2Id);

            // Récupération des soldes originaux
            let originalSoldeCaisse1 = parseFloat(document.getElementById('original_solde_caisse_1_' + caisse1Id).value) || 0;
            let originalSoldeCaisse2 = parseFloat(document.getElementById('original_solde_magasin_2_' + caisse2Id).value) || 0;

            // Conversion de la valeur ajoutée
            let soldeAjouterValue = parseFloat(soldeAjouter) || 0;

            // Vérification de la validité de la quantité ajoutée
            if (soldeAjouterValue < 0 || soldeAjouterValue > originalSoldeCaisse1) {
                Swal.fire({
                    title: "La solde ajoutée ne peut pas être négative ou dépasser le solde disponible.",
                    icon: "error"
                });
                document.querySelector('#solde_ajouter_' + caisse1Id).value = ''; // Réinitialiser l'entrée
                return; // Sortir de la fonction si la vérification échoue
            }

            // Calcul des nouveaux soldes
            let newSoldeCaisse1 = originalSoldeCaisse1 - soldeAjouterValue;
            let newSoldeCaisse2 = originalSoldeCaisse2 + soldeAjouterValue;

            // Mise à jour des champs de solde
            soldeCaisse1.value = newSoldeCaisse1.toFixed(2);
            soldeCaisse2.value = newSoldeCaisse2.toFixed(2);
        }
    </script>




    <!-- valider transfert -->
    <script>
        function validateTransfer() {
            // Afficher une boîte de confirmation
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Cette opération va transférer les fonds.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, transférer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Collecte des données
                    let caisse1Id = {{ $caisse1->id }};
                    let caisse2Id = {{ $caisse2->id }};
                    let soldeAjouterValue = parseFloat(document.getElementById('solde_ajouter_' + caisse1Id).value) || 0;
                    let user = '{{ Auth::user()->name }}'; // Utilisation de guillemets simples

                    // Debugging: Afficher les valeurs dans la console
                    console.log('Caisse 1 ID:', caisse1Id);
                    console.log('Caisse 2 ID:', caisse2Id);
                    console.log('Montant à ajouter:', soldeAjouterValue);
                    console.log('Utilisateur:', user);

                    // Créer un tableau de données à envoyer
                    let data = {
                        caisse1_id: caisse1Id,
                        caisse2_id: caisse2Id,
                        solde_ajouter: soldeAjouterValue,
                        user: user,
                        _token: '{{ csrf_token() }}' // Ajouter le token CSRF pour la protection
                    };

                    // Envoyer les données via AJAX
                    fetch('{{ route('valide_transfer') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data)
                    })
                        .then(response => {
                            // Vérifier la réponse du serveur
                            if (!response.ok) {
                                throw new Error('Erreur réseau');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Traiter la réponse du serveur
                            if (data.success) {
                                Swal.fire({
                                    title: "Transfert validé!",
                                    text: data.message,
                                    icon: "success"
                                }).then(() => {
                                    // Redirection après succès
                                    window.location.href = '/admin/caisse'; // Redirige vers la page /admin/caisse
                                });
                            } else {
                                Swal.fire({
                                    title: "Erreur!",
                                    text: data.message,
                                    icon: "error"
                                });
                            }
                        })
                        .catch((error) => {
                            console.error('Erreur:', error);
                            Swal.fire({
                                title: "Erreur!",
                                text: "Une erreur s'est produite lors de l'envoi des données.",
                                icon: "error"
                            });
                        });
                }
            });
        }
    </script>





</div>

@endsection
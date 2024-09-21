@extends('layouts.menu_caisse')

@section('content')
    <style>
        /* Styles pour le popup */
        .modal-content {
            text-align: center;
        }
    </style>
    <style>
        /* Style pour le toggle switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 24px;
            margin-left: 5px;
            margin-right: 5px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #bebebe;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            top: 2px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #09a760;
        }

        input:checked+.slider:before {
            transform: translateX(32px);
        }
    </style>


    <!-- AFFICHEUR -->
    <div class="container-fluid m-0 p-0">
        <div class="container-fluid">
            <div class="row afficheur text-center pt-1 pb-1 pr-0 pl-0 mt-1 mb-1">
                <div class="col-2 align-content-center">
                    <h5 class="objet-titre digital" id="category_text" style="font-weight:bold;">----</h5>
                    <h5 class="objet-titre digital" id="produit_text">----</h5>
                </div>
                <div class="col-3 pt-1">
                    <h6 class="afficheur-titre"> <span>Saisie Manuelle</span>
                        <label class="switch">
                            <input type="checkbox" id="darkModeSwitch">
                            <span class="slider"></span>
                        </label>
                        <span>Par la Balance</span>
                    </h6>
                    <div class="digital">
                        <p id="balance" style="margin-top:-30px;">0.000</p>
                    </div>

                    <!-- Bouton pour ouvrir le popup -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kgModal"
                        id="bouton_quantite" style="margin-top:-60px; display:none;">
                        saisir le poids
                    </button>
                    <!-- Bouton pour ouvrir le popup -->
                    <!-- Popup -->
                    <div class="modal fade" id="kgModal" tabindex="-1" aria-labelledby="kgModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="kgModalLabel">Saisir la quantité :</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" id="kgInput" class="form-control" placeholder="0.000"
                                        style="text-align: center; font-size:26px;">
                                    <div class="mt-3">
                                        <div class="row">
                                            <div class="col-4">
                                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                    onclick="appendValue('1')" style="width:100%;">1</button>
                                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                    onclick="appendValue('4')" style="width:100%;">4</button>
                                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                    onclick="appendValue('7')" style="width:100%;">7</button>
                                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                    onclick="appendValue('0')" style="width:100%;">0</button>
                                            </div>
                                            <div class="col-4">
                                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                    onclick="appendValue('2')" style="width:100%;">2</button>
                                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                    onclick="appendValue('5')" style="width:100%;">5</button>
                                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                    onclick="appendValue('8')" style="width:100%;">8</button>
                                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                    onclick="appendValue('.')" style="width:100%;">.</button>
                                            </div>
                                            <div class="col-4">
                                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                    onclick="appendValue('3')" style="width:100%;">3</button>
                                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                    onclick="appendValue('6')" style="width:100%;">6</button>
                                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                    onclick="appendValue('9')" style="width:100%;">9</button>
                                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                    onclick="appendValue('00')" style="width:100%;">00</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" onclick="ValiderQte()"
                                        style="width:150px;">Valider</button>
                                    <button type="button" class="btn btn-danger" onclick="clearInput()">Effacer</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Popup -->

                </div>
                <div class="col-3 align-content-center">
                    <h6 class="afficheur-titre">PRIX UNITAIRE:</h6>
                    <p class="digital" id="prix_unitaire" style="margin-top:-20px;">0.00</p>
                </div>
                <div class="col-3 align-content-center">
                    <h6 class="afficheur-titre">PRIX TOTAL:</h6>
                    <p class="digital" id="prix_total" style="margin-top:-20px;">0.00</p>
                </div>
                <div class="col-1 mt-3 pl-0">
                    <button class="btn btn-success pt-3 pb-3" style="color: white;">
                        <i class="fas fa-check-circle fa-lg"></i><br>Valider
                    </button>
                </div>
            </div>
        </div>

        <!-- Produits -->
        <div class="row le_centre">
            <div class="col-8">
                <div class="container mt-2">
                    <div class="your-carousel">
                        @foreach ($categorys as $category)
                            <form class="filter-form" data-id="{{ $category->id }}" data-nom="{{ $category->nom }}"
                                onclick="FiltrageProduits(this)">
                                <div class="card cat"
                                    style="width: 150px; height: 100px; margin-right:5px; background-image: url('{{ asset('storage/' . $category->photo) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                                    <p style="color:rgb(239, 239, 239); font-weight:bold;padding-left:10px;">
                                        {{ $category->nom }}</p>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="container" style="height:75%; overflow-y: auto;">
                    <div class="row" id="products">
                        <!-- Les produits filtrés apparaîtront ici -->
                    </div>

                    {{-- <div class="col-12 zyada" style="height: 1800px;">
                        CAISSE ESPACE
                    </div> --}}
                </div>
            </div>

            <!-- Facture -->
            <div class="col-4 bg-dark p-0 m-0">
                <div class="card shadow m-3" style="height:440px;">
                    <div class="card-header py-1">
                        <div class="row afficheur text-center" style="height: 105px;">
                            <div class="col-12 p-1 m-0 align-content-center">
                                <h6 class="afficheur-titre">TOTAL FACTURE :</h6>
                                <h2 class="digital" style="margin-top:-20px;">0.00</h2>
                            </div>
                            <div class="col-12 p-0 m-0">
                                <h6 class="afficheur-titre" style="margin-top:-25px;">CLIENT : <span
                                        id="nom_client">CLIENT COMPTOIR</span></h6>

                            </div>
                        </div>
                    </div>
                    <div class="card-body m-0 p-1" style="max-height: 550px; overflow-y: auto;">
                        <h6>IdMagasin:{{ $id_magasin }}/IdUser:{{ $id_user }}/IdCaisse:{{ $id_caisse }}</h6>
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Designation:</th>
                                    <th>Qte:</th>
                                    <th>Prix:</th>
                                    <th>Total:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Les lignes de ventes -->
                            </tbody>
                        </table>
                        {{-- <div class="col-12 zyada" style="height: 500px;">CAISSE ESPACE</div> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="sticky-footer-caisse bg-white">
            <div class="container-fluid m-0 p-0">
                <div class="row align-content-center m-0 p-0">
                    <div class="col-4">
                        <div class="row">
                            <div class="col-3"><a class="btn btn-warning" href=""><i
                                        class="fas fa-calculator fa-lg"></i><br>Ouvrir Calculatrice</a></div>
                            <div class="col-3"><a class="btn btn-warning" href=""><i
                                        class="fas fa-cubes fa-lg"></i><br> Voir Stock</a></div>
                            <div class="col-3"><a class="btn btn-warning" href=""><i
                                        class="fas fa-store-alt fa-lg"></i><br> Historique Ventes</a></div>
                            <div class="col-3"><a class="btn btn-secondary" href=""><i
                                        class="fas fa-user-clock fa-lg"></i><br>Liste En Attente</a></div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <div class="col-3"><a class="btn btn-dark" href=""><i
                                        class="fas fa-balance-scale fa-lg"></i><br>Modifier QTE</a></div>
                            <div class="col-3"><a class="btn btn-dark" href=""><i
                                        class="fas fa-coins fa-lg"></i><br>Modifier PRIX</a></div>
                            <div class="col-3"><a class="btn btn-dark" href=""><i
                                        class="fas fa-chevron-up fa-lg"></i><br>Vers le Haut</a></div>
                            <div class="col-3"><a class="btn btn-dark" href=""><i
                                        class="fas fa-chevron-down fa-lg"></i><br>Vers le Bas</a></div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <div class="col-3"><a class="btn btn-danger" href=""><i
                                        class="fas fa-trash-alt fa-lg"></i><br>Supprimer Selection</a></div>
                            <div class="col-3"><a class="btn btn-primary" href=""><i
                                        class="fas fa-shopping-cart fa-lg"></i><br>Nouvelle Vente</a></div>
                            <div class="col-3"><a class="btn btn-success" href=""><i
                                        class="fas fa-cash-register fa-lg"></i><br>Encaisser Valider</a></div>
                            <div class="col-3"><a class="btn btn-secondary" href=""><i
                                        class="far fa-clock fa-lg"></i><br>Vente En Attente</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Slick JS -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('.your-carousel').slick({
                slidesToShow: 5,
                slidesToScroll: 5,
                arrows: true,
                dots: false,
                infinite: false,
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                }, {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1
                    }
                }]
            });
        });
    </script>



    <!-- Input pour le port COM -->
    <input type="text" id="port" value="COM4" style="display:none;">


    <!-- Bouton de connexion -->
    {{-- <button id="connectButton">Connecter au Port Série</button> --}}

    <script>
        let port;
        let reader;

        async function connectToPort() {
            try {
                // Demander à l'utilisateur de sélectionner un port série
                port = await navigator.serial.requestPort();

                // Ouvrir la connexion au port série
                await port.open({
                    baudRate: 9600
                });
                reader = port.readable.getReader();

                console.log('Connexion au port série établie');
                readData(); // Commencer à lire les données du port série
            } catch (error) {
                console.error('Erreur lors de la connexion au port série :', error);
            }
        }

        async function readData() {
            try {
                const {
                    value,
                    done
                } = await reader.read();
                if (done) return;

                const data = new TextDecoder().decode(value);
                const numberMatch = data.match(/(\d+(\.\d+)?)(?=kg)/);

                if (numberMatch) {
                    const weight = parseFloat(numberMatch[1]);
                    document.getElementById('balance').textContent = `${weight} kg`;
                    calculateTotal(weight);
                }

                readData();
            } catch (error) {
                console.error('Erreur de lecture des données :', error);
            }
        }

        function calculateTotal(weight) {
            const prixUnitaire = parseFloat(document.getElementById('prix_unitaire').value.replace(',', '.')) || 0;
            const total = (weight * prixUnitaire).toFixed(2);
            document.getElementById('prix_total').textContent = `${total} €`;
        }

        document.getElementById('prix_unitaire').addEventListener('input', function() {
            const weightText = document.getElementById('balance').textContent;
            const weight = parseFloat(weightText) || 0;
            calculateTotal(weight);
        });

        // Ajouter un gestionnaire d'événements pour le bouton
        document.getElementById('connectButton').addEventListener('click', function() {
            connectToPort();
        });
    </script>









    <!-- Filtrage Produits -->
    <script>
        function FiltrageProduits(form) {
            const id = form.getAttribute('data-id');
            const nom = form.getAttribute('data-nom');

            if (id !== undefined) {
                $.ajax({
                    url: '{{ url('/caisse/category') }}/' + id,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#products').empty();
                        $.each(response.produits, function(key, value) {
                            $('#products').append(
                                '<div class="col-2 p-2">' +
                                '<div class="card scat">' +
                                '<form class="affichage-form" data-id="' + value.id +
                                '" data-nom="' + value.nom_pr + '" data-prix="' + value.prix_vent +
                                '" onclick="affichage(this)">' +
                                '<img src="{{ asset('storage/') }}/' + value.photo_pr +
                                '" class="card-img-top" alt="...">' +
                                '<div class="card-body p-1 m-0 text-center">' +
                                '<h5 class="card-title">' + value.nom_pr + '</h5>' +
                                '<p class="card-text">' + value.prix_vent + ' DZD</p>' +
                                '</div>' +
                                '</form>' +
                                '</div>' +
                                '</div>'
                            );
                        });

                        $('#products').append(
                            '<div class="col-12 zyada" style="height: 500px;"></div>'
                        );
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                console.error('ERREUR ID');
            }

            if (nom !== undefined) {
                const afficheur_cat = document.getElementById('category_text');
                const afficheur_produit = document.getElementById('produit_text');
                const afficheur_qte = document.getElementById('balance');
                const afficheur_prix = document.getElementById('prix_unitaire');
                const afficheur_prix_total = document.getElementById('prix_total');
                afficheur_cat.textContent = nom;
                afficheur_produit.textContent = '----';
                // afficheur_qte.textContent = '0.000';
                afficheur_prix.textContent = '0.00';
                afficheur_prix_total.textContent = '0.00';

            } else {
                console.error('ERREUR NOM');
            }
        }
    </script>

    <!-- Affichage Détails Produit -->
    <script>
        function affichage(form) {
            const id = form.getAttribute('data-id');
            const nom = form.getAttribute('data-nom');
            const prix = form.getAttribute('data-prix');

            if (nom !== undefined) {
                const nom_produit = document.getElementById('produit_text');
                nom_produit.textContent = nom;
            } else {
                console.error('ERREUR NOM');
            }

            if (prix !== undefined) {
                const prix_produit = document.getElementById('prix_unitaire');
                const prix_total = document.getElementById('prix_total');
                const qte = parseFloat(document.getElementById('balance').textContent);
                prix_produit.textContent = prix;
                LeTotal = prix * qte;
                LeTotal = LeTotal.toFixed(0);
                prix_total.textContent = LeTotal;
                // AffichageEtCalcul(parseFloat(prix.replace(',', '.')));
            } else {
                console.error('ERREUR PRIX');
            }
        }
    </script>

    <script>
        function appendValue(value) {
            const input = document.getElementById('kgInput');
            input.value += value; // Ajoute la valeur au champ input
        }

        function assignValue(value) {
            const input = document.getElementById('kgInput');
            input.value = value; // Ajoute la valeur au champ input
        }

        function ValiderQte() {
            const QteSaisie = parseFloat(document.getElementById('kgInput').value);
            const PrixSaisie = parseFloat(document.getElementById('prix_unitaire').textContent);

            const QteAfficheur = document.getElementById('balance');
            const PrixUnitaire = document.getElementById('prix_unitaire');
            const PrixTotal = document.getElementById('prix_total');

            if (!isNaN(QteSaisie)) { // Vérifie que la saisie est un nombre valide
                QteAfficheur.textContent = QteSaisie.toFixed(3); // Met à jour l'afficheur avec 3 décimales
            } else {
                alert("Veuillez saisir une quantité valide."); // Alerte si la saisie n'est pas un nombre
            }

            if (!isNaN(QteSaisie) && !isNaN(PrixSaisie)) {
                Total = PrixSaisie * QteSaisie;
                Total = Total.toFixed(0);
                PrixTotal.textContent = Total;
            }

            // Ferme le popup
            // const modalElement = bootstrap.Modal.getInstance(document.getElementById('kgModal'));
            // if (modalElement) {
            //     modalElement.hide();
            // }
            $('#kgModal').modal('hide');
        }


        function clearInput() {
            const input = document.getElementById('kgInput');
            input.value = ''; // Efface le champ input
        }

        document.getElementById('balance').addEventListener('click', function() { 
            clearInput()
            document.getElementById('bouton_quantite').click(); // Simule le clic sur le bouton
        });

        function calculer_total() {
            const Qte = document.getElementById('balance').textContent;
            const PrixUnitaire = document.getElementById('prix_unitaire').textContent;
            const PrixTotal = document.getElementById('prix_total');
            if (!isNaN(Qte) && !isNaN(PrixUnitaire)) {
                qte = parseFloat(qte);
                PrixUnitaire = parseFloat(PrixUnitaire);
                Total = PrixUnitaire * qte;
                Total = Total.toFixed(0);
                PrixTotal.textContent = Total;
            }
        }

        ///// calculer avec la balance ///////
        document.getElementById('balance').addEventListener('change', function() {
            calculer_total()
        });




    </script>

    <style>
        .scat {
            height: 160px;
            width: 100%;
        }

        .card-img-top {
            height: 90px;
        }
    </style>
@endsection

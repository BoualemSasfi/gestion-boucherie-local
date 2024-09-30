@extends('layouts.menu_caisse')

@section('content')
    <style>
        .scat {
            height: 160px;
            width: 100%;
        }

        .card-img-top {
            height: 90px;
        }
    </style>
    {{-- css pour les poppup  --}}
    <style>
        .modal {
            z-index: 1050 !important;
        }

        .modal-backdrop {
            z-index: 1040 !important;
        }

        .modal-content {
            text-align: center;
        }

        .modal-backdrop {
            display: none !important;
        }

        /* pointer-events: auto; */
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
                    <h5 class="objet-titre digital" id="categorie_text" style="font-weight:bold;">----</h5>
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
                        <p id="balance" style="margin-top:-30px; cursor: pointer;" data-bs-toggle="modal"
                            data-bs-target="#kgModal">0.000</p>
                    </div>

                    <!-- Bouton pour ouvrir le popup -->
                    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kgModal"
                        id="bouton_quantite" style="margin-top:-60px; display:block;">
                        saisir le poids
                    </button> --}}
                    <!-- Bouton pour ouvrir le popup -->
                    <!-- Popup -->
                    <div class="modal fade" id="kgModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h4 class="modal-title" id="">QUANTITE</h4>
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
                                <div class="modal-footer m-0 p-2">
                                    {{-- <button type="button" class="btn btn-success" onclick="ValiderQte()"
                                        style="width:150px;"><i class="bi bi-check-lg"></i><br>Valider</button>
                                    <button type="button" class="btn btn-danger" onclick="clearInput()"><i class="bi bi-eraser"></i><br>Effacer</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x"></i><br>Fermer</button> --}}
                                    <div class="container pl-0">
                                        <div class="row">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-success" onclick="ValiderQte()"
                                                    style="width: 150px;">
                                                    <i class="bi bi-check-lg"></i><br>Valider
                                                </button>

                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-danger" onclick="clearInput()"
                                                    style="width: 150px;">
                                                    <i class="bi bi-eraser"></i><br>Effacer
                                                </button>

                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                                    style="width: 150px;">
                                                    <i class="bi bi-x"></i><br>Fermer
                                                </button>

                                            </div>
                                        </div>
                                    </div>
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

                    {{-- pour le produit selectionné  --}}
                    <a id="text-id-lestock" href="" style="display: none;"></a>
                    <a id="text-id-produit" href="" style="display: none;"></a>
                    {{-- pour le produit selectionné  --}}

                    <form class="valider-vente-form" data-id_facture="{{ $LastFacture->id }}"
                        data-id_user={{ $id_user }}>
                        <button class="btn btn-success pt-3 pb-3" style="color: white;" onclick="ValiderVente(this)"
                            type="button">
                            <i class="fas fa-check-circle fa-lg"></i>
                            <br>Valider
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Produits -->
        <div class="row le_centre">
            <div class="col-8">
                <div class="container mt-2">
                    <div class="your-carousel">
                        @foreach ($categories as $categorie)
                            <form class="filter-form" data-id="{{ $categorie->id }}" data-nom="{{ $categorie->nom }}"
                                onclick="FiltrageProduits(this)" style="cursor: pointer;">
                                <div class="card cat"
                                    style="width: 150px; height: 100px; margin-right:5px; background-image: url('{{ asset('storage/' . $categorie->photo) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                                    <p style="color:rgb(239, 239, 239); font-weight:bold;padding-left:10px;">
                                        {{ $categorie->nom }}</p>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
                <hr class="p-0 mb-0 mt-2">
                <div class="container" style="height:75%; overflow-y: auto;">
                    <h6 id="titre-categorie" class="p-0 m-0"></h6>
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

                {{-- stockage variable  --}}
                <a href="" style="color: aliceblue;">USER / FACTURE / MAGASIN / CAISSE</a>
                <a id="text-id-user" href="" style="display: inline-flex;">{{ $id_user }}</a>
                <a id="text-id-facture" href="" style="display: inline-flex;">{{ $LastFacture->id }}</a>
                <a id="text-id-magasin" href="" style="display: inline-flex;">{{ $id_magasin }}</a>
                <a id="text-id-caisse" href="" style="display: inline-flex;">{{ $id_caisse }}</a>
                {{-- stockage variable  --}}

                <div class="card shadow m-3" style="height:500px;">
                    <div class="card-header py-1">
                        <div class="row afficheur text-center" style="height: 105px;">
                            <div class="col-12 p-1 m-0 align-content-center">
                                <h6 class="afficheur-titre">TOTAL FACTURE :</h6>
                                <h2 id="text_total_facture" class="digital" style="margin-top:-20px;">0.00</h2>
                            </div>
                            <div class="col-12 p-0 m-0">
                                <h6 class="afficheur-titre" style="margin-top:-25px;">CLIENT : <span
                                        id="nom_client">CLIENT COMPTOIR</span></h6>

                            </div>
                        </div>
                    </div>
                    <div class="card-body m-0 p-1" style="max-height: 750px; overflow-y: auto;">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Designation:</th>
                                    <th>Qte:</th>
                                    <th>Prix:</th>
                                    <th>Total:</th>
                                </tr>
                            </thead>
                            <tbody id="ventes_liste">
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
                        <div class="row bouton-action">
                            <div class="col-3">
                                <button class="btn btn-warning" type="button" data-bs-toggle="modal"
                                    data-bs-target="#calculatorModal">
                                    <i class="fas fa-calculator fa-lg"></i>
                                    <br>Ouvrir Calculatrice
                                </button>
                            </div>
                            {{-- <div class="col-3">
                                <button class="btn btn-warning" type="button">
                                    <i class="fas fa-cubes fa-lg"></i>
                                    <br>
                                    Voir<br>Stock
                                </button>
                            </div> --}}
                            <div class="col-3">
                                <button class="btn btn-warning" type="button">
                                    {{-- <i class="fas fa-store-alt fa-lg"></i> --}}
                                    <i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i>

                                    <br> Historique Ventes
                                </button>
                            </div>
                            <div class="col-3">
                                <button class="btn btn-warning" type="button">
                                    <i class="fa fa-users fa-lg" aria-hidden="true"></i>
                                    <br>Clients
                                </button>
                            </div>
                            <div class="col-3">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-store-alt fa-lg"></i>
                                    <br> Retour vers magasin
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="row bouton-action">
                            <div class="col-3">
                                <button class="btn btn-secondary" type="button">
                                    <i class="fas fa-user-clock fa-lg"></i>
                                    <br>Liste En Attente
                                </button>
                            </div>
                            {{-- <div class="col-3">
                                <button class="btn btn-primary" type="button" onclick="Nouvelle_Facture()">
                                    <i class="fas fa-shopping-cart fa-lg"></i>
                                    <br>Nouvelle Vente
                                </button>
                            </div> --}}
                            <div class="col-6">
                                {{-- Bouton pour afficher le popup --}}
                                <button class="btn btn-success" type="button" data-bs-toggle="modal"
                                    data-bs-target="#FactureModal" id="bouton_encaisser" onclick="Ouvrir_Encaissement()">
                                    <i class="fas fa-cash-register fa-lg"></i>
                                    <br>Encaissement
                                </button>

                                <!-- Popup -->
                                <div class="modal fade" id="FactureModal" tabindex="-1" aria-labelledby=""
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- En-tête du modal -->
                                            {{-- <div class="modal-header">
                                                <h4 class="modal-title" id="FactureModalLabel">BLABLABLABLABLA :</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div> --}}
                                            <!-- Corps du modal -->
                                            <div class="modal-body">
                                                <h4 class="modal-title" id="">ENCAISSEMENT</h4>
                                                <div class="mt-3">
                                                    <div class="row">
                                                        <div class="col-12 text-left mb-3">
                                                            <label for="client_select">Client :</label>
                                                            <select class="form-select" id="client_select"
                                                                style="width: 100%;">
                                                                @foreach ($clients as $client)
                                                                    <option value="{{ $client->id }}">
                                                                        {{ $client->nom_prenom }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <label for="TotalInput">Montant total :</label>
                                                            <input type="text" id="TotalInput" class="form-control"
                                                                placeholder="0.00"
                                                                style="text-align: center; font-size:26px;" readonly>
                                                        </div>
                                                        <div class="col-4">
                                                            <label for="versementInput">Versement :</label>
                                                            <input type="number" id="VersementInput"
                                                                class="form-control" placeholder="0.00"
                                                                style="text-align: center; font-size:26px;"
                                                                inputmode="decimal">
                                                        </div>
                                                        <div class="col-4">
                                                            <label for="creditInput" id="LabelCredit">Crédit :</label>
                                                            <input type="text" id="CreditInput" class="form-control"
                                                                placeholder="0.00"
                                                                style="text-align: center; font-size:26px;" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-4 h-100">
                                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                                onclick="FactureAppendValue('1')"
                                                                style="width:100%;">1</button>
                                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                                onclick="FactureAppendValue('4')"
                                                                style="width:100%;">4</button>
                                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                                onclick="FactureAppendValue('7')"
                                                                style="width:100%;">7</button>
                                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                                onclick="FactureAppendValue('0')"
                                                                style="width:100%;">0</button>
                                                        </div>
                                                        <div class="col-4 h-100">
                                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                                onclick="FactureAppendValue('2')"
                                                                style="width:100%;">2</button>
                                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                                onclick="FactureAppendValue('5')"
                                                                style="width:100%;">5</button>
                                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                                onclick="FactureAppendValue('8')"
                                                                style="width:100%;">8</button>
                                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                                onclick="FactureAppendValue('00')"
                                                                style="width:100%;">00</button>
                                                        </div>
                                                        <div class="col-4 h-100">
                                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                                onclick="FactureAppendValue('3')"
                                                                style="width:100%;">3</button>
                                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                                onclick="FactureAppendValue('6')"
                                                                style="width:100%;">6</button>
                                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                                onclick="FactureAppendValue('9')"
                                                                style="width:100%;">9</button>
                                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                                                onclick="FactureAppendValue('000')"
                                                                style="width:100%;">000</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Pied du modal -->
                                            {{-- <div class="modal-footer text-center align-content-center justify-content-center">
                                                <button type="button" class="btn btn-success" onclick="ValiderFacture()"
                                                    style="">Valider</button>
                                                <button type="button" class="btn btn-danger" onclick="clearTotalInput()">Effacer</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                            </div> --}}

                                            <div class="modal-footer m-0 p-2">
                                                <div class="container pl-0">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <button type="button" class="btn btn-success"
                                                                onclick="ValiderFacture()" style="width: 150px;">
                                                                <i class="bi bi-check-lg"></i><br>Valider
                                                            </button>

                                                        </div>
                                                        <div class="col-4">
                                                            <button type="button" class="btn btn-danger"
                                                                onclick="ClearTotalInput()" style="width: 150px;">
                                                                <i class="bi bi-eraser"></i><br>Effacer
                                                            </button>

                                                        </div>
                                                        <div class="col-4">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal" style="width: 150px;">
                                                                <i class="bi bi-x"></i><br>Fermer
                                                            </button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- Popup -->



                            </div>
                            <div class="col-3">
                                <button class="btn btn-secondary" type="button" onclick="FactureEnAttente()">
                                    <i class="far fa-clock fa-lg"></i>
                                    <br>Vente En Attente
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="col-4">
                        <div class="row bouton-action">
                            {{-- <div class="col-3">
                                <button class="btn btn-dark" type="button">
                                    <i class="fas fa-balance-scale fa-lg"></i>
                                    <br>Modifier QTE
                                </button>
                            </div> --}}
                            <div class="col-3">
                                <button class="btn btn-danger" type="button">
                                    <i class="fas fa-trash-alt fa-lg"></i>
                                    <br>Supprimer Selection
                                </button>
                            </div>
                            <div class="col-3">
                                <button class="btn btn-dark" type="button">
                                    <i class="fas fa-coins fa-lg"></i>
                                    <br>Modifier PRIX
                                </button>
                            </div>
                            <div class="col-3">
                                <button class="btn btn-dark" type="button">
                                    <i class="fas fa-chevron-up fa-lg"></i>
                                    <br>Vers<br>le Haut
                                </button>
                            </div>
                            <div class="col-3">
                                <button class="btn btn-dark" type="button">
                                    <i class="fas fa-chevron-down fa-lg"></i>
                                    <br>Vers<br>le Bas
                                </button>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </footer>
    </div>





    <!-- Input pour le port COM -->
    <input type="text" id="port" value="COM4" style="display:none;">


    <!-- Bouton de connexion -->
    {{-- <button id="connectButton">Connecter au Port Série</button> --}}



    {{-- ------------------------------------------------------------------------------------------------------- --}}
    {{-- javascript  --}}
    {{-- ------------------------------------------------------------------------------------------------------- --}}
    <!-- Slick JS -->
    <script>
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
        console.log('Carousel executé');
    </script>
    {{-- script pour les poppup  --}}
    <script>
        // const modalElement1 = document.getElementById('FactureModal');
        // const modal1 = new bootstrap.Modal(modalElement1, {
        //     backdrop: false,
        //     keyboard: false
        // });
        // modal1.show();

        // const modalElement2 = document.getElementById('kgModal');
        // const modal2 = new bootstrap.Modal(modalElement2, {
        //     backdrop: false,
        //     keyboard: false
        // });
        // modal2.show();
        $('body').css('overflow', 'auto');
    </script>

    {{-- script pour la balance  --}}
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
            const total = (weight * prixUnitaire).toFixed(0);
            document.getElementById('prix_total').textContent = `${total}`;
        }

        document.getElementById('prix_unitaire').addEventListener('input', function() {
            const weightText = document.getElementById('balance').textContent;
            const weight = parseFloat(weightText) || 0;
            calculateTotal(weight);
        })

        // Ajouter un gestionnaire d'événements pour le bouton
        document.getElementById('connectButton').addEventListener('click', function() {
            connectToPort();
        })
    </script>
    {{-- script pour la balance  --}}







    <!-- script pour la caisse -->
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
                                '<form class="affichage-form" data-id_lestock="' + value.id +
                                '" data-id_produit="' + value.id_produit +
                                '" data-nom="' + value.nom + '" data-prix="' + value.prix +
                                '" onclick="affichage(this)" style="cursor: pointer;">' +
                                '<img src="{{ asset('storage/') }}/' + value.photo +
                                '" class="card-img-top" alt="...">' +
                                '<div class="card-body p-1 m-0 text-center">' +
                                '<h5 class="card-title">' + value.nom + '</h5>' +
                                '<p class="card-text">' + value.prix + ' DA / ' + value.mesure + '</p>' +
                                '</div>' +
                                '</form>' +
                                '</div>' +
                                '</div>'
                            );
                        });

                        $('#products').append(
                            '<div class="col-12 zyada" style="height: 600px;"></div>'
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
                const afficheur_cat = document.getElementById('categorie_text');
                const afficheur_produit = document.getElementById('produit_text');
                const afficheur_qte = document.getElementById('balance');
                const afficheur_prix = document.getElementById('prix_unitaire');
                const afficheur_prix_total = document.getElementById('prix_total');
                const titre_categorie = document.getElementById('titre-categorie');
                titre_categorie.textContent = nom;
                afficheur_cat.textContent = nom;
                afficheur_produit.textContent = '----';
                // afficheur_qte.textContent = '0.000';
                afficheur_prix.textContent = '0.00';
                afficheur_prix_total.textContent = '0.00';

            } else {
                console.error('ERREUR NOM');
            }

            console.log('Filtrage Produits executé');
        }
    </script>

    {{-- script filtrage produits  --}}
    <script>
        function affichage(form) {
            const id_lestock = form.getAttribute('data-id_lestock');
            const id_produit = form.getAttribute('data-id_produit');
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
            if (id_lestock !== undefined && id_produit !== undefined) {
                const affectation_id_lestock = document.getElementById('text-id-lestock');
                const affectation_id_produit = document.getElementById('text-id-produit');
                affectation_id_lestock.textContent = id_lestock;
                affectation_id_produit.textContent = id_produit;
            } else {
                console.error('ERREUR ID');
            }

            console.log('Calcul Total Produit*Quantité executé');
        }
    </script>

    {{-- script poppup quantite  --}}
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
            $('#kgModal').modal('hide');

            console.log('Quantite saisie executé');
        }




        function clearInput() {
            const input = document.getElementById('kgInput');
            input.value = ''; // Efface le champ input
        }




        function calculer_total_vente() {
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

            console.log('Calcul Total Vente executé');
        }

        // document.getElementById('balance').addEventListener('change', function() {
        //     calculer_total_vente()
        // })



        function ValiderVente(button) {
            const AffichageQte = document.getElementById('balance');
            const AffichagePrixUnitaire = document.getElementById('prix_unitaire');
            const AffichagePrixTotal = document.getElementById('prix_total');
            const AffichageNomProduit = document.getElementById('produit_text');

            let qte = parseFloat(AffichageQte.textContent); // Utiliser let pour qte
            let PrixUnitaire = parseFloat(AffichagePrixUnitaire.textContent); // Utiliser let pour PrixUnitaire
            let PrixTotal = parseFloat(AffichagePrixTotal.textContent); // Utiliser let pour PrixTotal

            const form = button.closest('.valider-vente-form');
            if (form) {
                qte = qte.toFixed(3); // qte est une chaîne après toFixed
                PrixUnitaire = PrixUnitaire.toFixed(0); // PrixUnitaire est une chaîne après toFixed
                PrixTotal = (qte * PrixUnitaire).toFixed(0); // Correction de PrixTotal avec qte et PrixUnitaire

                const id_user = document.getElementById('text-id-user').textContent;
                const id_facture = document.getElementById('text-id-facture').textContent;
                const id_lestock = document.getElementById('text-id-lestock').textContent; // Utiliser querySelector
                const id_produit = document.getElementById('text-id-produit').textContent; // Utiliser querySelector

                if (PrixUnitaire <= 0 && qte <= 0) {
                    Swal.fire({
                        title: "Veuillez selectionner un Produit, et saisir la Quantité",
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else

                if (qte <= 0 && PrixUnitaire > 0) {
                    Swal.fire({
                        title: "Veuillez saisir la Quantité",
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else

                if (PrixUnitaire <= 0 && qte > 0) {
                    Swal.fire({
                        title: "Veuillez selectionner un Produit",
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else

                if (id_facture && id_user && id_lestock && id_produit && qte > 0 && PrixUnitaire > 0 && PrixTotal > 0) {
                    $.ajax({
                        url: '/vente/' + id_facture + '/' + id_user + '/' + id_lestock + '/' + id_produit +
                            '/valeurs/' + PrixUnitaire + '/' + qte + '/' + PrixTotal,
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // Assurez-vous que cette balise meta est incluse dans votre HTML
                        },
                        success: function() {
                            Swal.fire({
                                title: "Validé",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });

                            ListeVentes(id_facture);

                            Calculer_Total_Facture(id_facture);

                            // Réinitialiser les affichages
                            AffichageQte.textContent = "0.000";
                            AffichagePrixUnitaire.textContent = "0.00";
                            AffichagePrixTotal.textContent = "0.00";
                            AffichageNomProduit.textContent = "----";
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                } else {
                    console.error('Conditions non remplies pour la validation.');
                }
            } else {
                console.error('Formulaire vente non trouvé.'); // Message d'erreur si le formulaire parent n'est pas trouvé
            }
            console.log('Validation Vente executé');
        }


        function ListeVentes(id_facture) {
            $.ajax({
                url: '/ventes/' + id_facture,
                type: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Assurez-vous que cette balise meta est incluse dans votre HTML
                },
                success: function(response) {
                    $('#ventes_liste').empty();
                    $.each(response.ventes, function(key, value) {
                        $('#ventes_liste').append(
                            '<tr>' +
                            '<td class="">' + value.nom_produit + '</td>' +
                            '<td class="">' + value.quantite + '</td>' +
                            '<td class="">' + value.prix_produit + '</td>' +
                            '<td class="">' + value.prix_total + '</td>' +
                            '</tr>'
                        );
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

            console.log('Réccuperation Liste des Ventes executé');
        }


        function Calculer_Total_Facture(id_facture) {
            $.ajax({
                url: '/total-facture/' + id_facture,
                type: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Assurez-vous que cette balise meta est incluse dans votre HTML
                },
                success: function(response) {
                    let AffichageTotal = document.getElementById('text_total_facture');
                    AffichageTotal.textContent = response.total;

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

            console.log('Calcul Total Facture executé');
        }
    </script>

    {{-- facture  --}}
    <script>
        function Nouvelle_Facture() {
            const id_user = document.getElementById('text-id-user').textContent;
            const id_magasin = document.getElementById('text-id-magasin').textContent;
            const id_caisse = document.getElementById('text-id-caisse').textContent;
            if (!isNaN(id_user) && !isNaN(id_magasin) && !isNaN(id_caisse)) {

                $.ajax({
                    url: '/nouvelle-facture/' + id_user + '/' + id_magasin + '/' + id_caisse,
                    type: 'get',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Assurez-vous que cette balise meta est incluse dans votre HTML
                    },
                    success: function(response) {

                        Swal.fire({
                            title: "Nouvelle Vente",
                            icon: "info",
                            showConfirmButton: false,
                            timer: 1500
                        });

                        const id_facture = response.LastFactureId;
                        let StockageIdFacture = document.getElementById('text-id-facture');
                        StockageIdFacture.textContent = id_facture;

                        ListeVentes(id_facture);
                        // Calculer_Total_Facture(id_facture);
                        zero();



                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
            console.log('Nouvelle Facture executé');
        }


        function zero() {

            const AffichageQte = document.getElementById('balance');
            const AffichagePrixUnitaire = document.getElementById('prix_unitaire');
            const AffichagePrixTotal = document.getElementById('prix_total');
            const AffichageFactureTotal = document.getElementById('text_total_facture');
            const AffichageNomCategorie = document.getElementById('categorie_text');
            const AffichageNomProduit = document.getElementById('produit_text');
            const AffichageTitreCategorie = document.getElementById('titre-categorie');

            // Réinitialiser les affichages
            AffichageQte.textContent = "0.000";
            AffichagePrixUnitaire.textContent = "0.00";
            AffichagePrixTotal.textContent = "0.00";
            AffichageFactureTotal.textContent = "0.00";
            AffichageNomCategorie.textContent = "----";
            AffichageNomProduit.textContent = "----";
            AffichageTitreCategorie.textContent = "";
            $('#products').empty();

            console.log('Remise à zero executé');
        }


        async function Ouvrir_Encaissement() {

            const AffichageTotalCaisse = document.getElementById('text_total_facture');
            const AffichageTotalPoppup = document.getElementById('TotalInput');
            const AffichageVersPoppup = document.getElementById('VersementInput');
            const AffichageCreditPoppup = document.getElementById('CreditInput');

            if (AffichageTotalCaisse.textContent === '0.00') {


                await Swal.fire({
                    title: "Facture Vide",
                    icon: "warning",
                    showConfirmButton: false,
                    timer: 1500
                });

                // Ferme le popup encaissement
                await $('#FactureModal').modal('hide');

            } else {
                const TotalCaisse = AffichageTotalCaisse.textContent;
                AffichageTotalPoppup.value = TotalCaisse;
                AffichageVersPoppup.placeholder = TotalCaisse;
                AffichageVersPoppup.value = '';
                AffichageCreditPoppup.value = '0.00';
                console.log('total : ' + TotalCaisse);
            }

            console.log('Ouverture encaissement executé');
        }

        function FactureAppendValue(value) {
            const input = document.getElementById('VersementInput');
            input.value += value;
            CalculerCredit()
        }

        function ClearTotalInput() {
            const input = document.getElementById('VersementInput');
            input.value = '';
            CalculerCredit()
        }



        // async function ValiderFacture() {
        //     const InputTotal = document.getElementById('TotalInput');
        //     const InputVersement = document.getElementById('VersementInput');
        //     const InputCredit = document.getElementById('CreditInput');

        //     const IdUser = document.getElementById('text-id-user').textContent;
        //     const IdCaisse = document.getElementById('text-id-caisse').textContent;
        //     const IdFacture = document.getElementById('text-id-facture').textContent;
        //     const IdClient = document.getElementById('client_select').value;
        //     let Total = parseFloat(InputTotal.value);
        //     let Credit = parseFloat(InputCredit.value);

        //     let Versement; // Déclare la variable en dehors du bloc if/else



        //     if (InputVersement.value === '') {
        //         Versement = Total; // Affecte la valeur de Total à Versement si l'input est vide
        //     } else {
        //         Versement = parseFloat(InputVersement.value); // Sinon, parse l'input en float
        //     }

        //     // cas pas de credit 
        //     if (Total > 0 && (Versement === Total || Versement > Total)) {
        //         Versement = Total;
        //         Credit = 0;
        //         const Etat = 'Facture-Payée';

        //         try {
        //             // Transforme l'appel AJAX en promesse pour utiliser await
        //             const response = await $.ajax({
        //                 url: '/valider-facture/' + IdUser + '/' + IdFacture + '/' + IdCaisse + '/' +
        //                     IdClient +
        //                     '/valeurs/' + Total + '/' + Versement + '/' + Credit + '/' + Etat,
        //                 type: 'put',
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
        //                         'content') // Assurez-vous que cette balise meta est incluse dans votre HTML
        //                 },
        //                 success: function(response) {

        //                     Swal.fire({
        //                         title: "Facture Validée",
        //                         icon: "success",
        //                         showConfirmButton: false,
        //                         timer: 1500
        //                     })
        //                 }
        //             });
        //         } catch (error) {
        //             console.error("Erreur lors de la validation de la facture :", error);
        //             // Gère l'erreur si nécessaire
        //         }

        //         try {
        //             const response = await $.ajax({
        //                 url: '/imprimer-ticket/' + IdFacture,
        //                 type: 'get',
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
        //                         'content') // Assurez-vous que cette balise meta est incluse dans votre HTML
        //                 },
        //                 success: function(response) {

        //                     Swal.fire({
        //                         title: "Ticket Validé",
        //                         icon: "success",
        //                         showConfirmButton: false,
        //                         timer: 1500
        //                     })
        //                 }
        //             });
        //         } catch (error) {
        //             console.error("Erreur de ticket :", error);
        //             // Gère l'erreur si nécessaire
        //         }

        //         // Ferme le modal
        //         await $('#FactureModal').modal('hide');

        //         // Appelle la fonction Nouvelle_Facture
        //         await Nouvelle_Facture();

        //     }

        //     // cas credit 
        //     if (Versement < Total || InputVersement.value === '0') {
        //         const Etat = 'Crédit';

        //         try {
        //             // Transforme l'appel AJAX en promesse pour utiliser await
        //             const response = await $.ajax({
        //                 url: '/valider-facture/' + IdUser + '/' + IdFacture + '/' + IdCaisse + '/' +
        //                     IdClient +
        //                     '/valeurs/' + Total + '/' + Versement + '/' + Credit + '/' + Etat,
        //                 type: 'put',
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
        //                         'content') // Assurez-vous que cette balise meta est incluse dans votre HTML
        //                 },
        //                 success: function(response) {

        //                     Swal.fire({
        //                         title: "Facture Validée",
        //                         icon: "success",
        //                         showConfirmButton: false,
        //                         timer: 1500
        //                     })
        //                 }
        //             });
        //         } catch (error) {
        //             console.error("Erreur lors de la validation de la facture :", error);
        //             // Gère l'erreur si nécessaire
        //         }

        //         try {
        //             const response = await $.ajax({
        //                 url: '/imprimer-ticket/' + IdFacture,
        //                 type: 'get',
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
        //                         'content') // Assurez-vous que cette balise meta est incluse dans votre HTML
        //                 },
        //                 success: function(response) {

        //                     Swal.fire({
        //                         title: "Ticket Validé",
        //                         icon: "success",
        //                         showConfirmButton: false,
        //                         timer: 1500
        //                     })
        //                 }
        //             });
        //         } catch (error) {
        //             console.error("Erreur de ticket :", error);
        //             // Gère l'erreur si nécessaire
        //         }

        //         // Ferme le modal
        //         await $('#FactureModal').modal('hide');

        //         // Appelle la fonction Nouvelle_Facture
        //         await Nouvelle_Facture();

        //     }

        //     console.log('Validation Facture executé');
        // }

        // ------------------------------------------------------------------------------------------------------

        // async function ValiderFacture() {
        //     const InputTotal = document.getElementById('TotalInput');
        //     const InputVersement = document.getElementById('VersementInput');
        //     const InputCredit = document.getElementById('CreditInput');

        //     const IdUser = document.getElementById('text-id-user').textContent;
        //     const IdCaisse = document.getElementById('text-id-caisse').textContent;
        //     const IdFacture = document.getElementById('text-id-facture').textContent;
        //     const IdClient = document.getElementById('client_select').value;
        //     let Total = parseFloat(InputTotal.value);
        //     let Credit = parseFloat(InputCredit.value);

        //     let Versement;

        //     if (InputVersement.value === '') {
        //         Versement = Total;
        //     } else {
        //         Versement = parseFloat(InputVersement.value);
        //     }

        //     // Full or overpayment case
        //     if (Total > 0 && (Versement === Total || Versement > Total)) {
        //         Versement = Total;
        //         Credit = 0;
        //         const Etat = 'Facture-Payée';

        //         try {
        //             // Validate the invoice
        //             await $.ajax({
        //                 url: `/valider-facture/${IdUser}/${IdFacture}/${IdCaisse}/${IdClient}/valeurs/${Total}/${Versement}/${Credit}/${Etat}`,
        //                 type: 'put',
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 }
        //             });

        //             Swal.fire({
        //                 title: "Facture Validée",
        //                 icon: "success",
        //                 showConfirmButton: false,
        //                 timer: 1500
        //             });

        //             // Open the PDF ticket in a new tab
        //             window.open('/imprimer-ticket/' + IdFacture, '_blank');

        //             // Wait for a moment before continuing
        //             await new Promise((resolve) => setTimeout(resolve, 1600));

        //             // Close the modal and reset after the ticket has been opened
        //             $('#FactureModal').modal('hide');
        //             await Nouvelle_Facture();

        //         } catch (error) {
        //             console.error("Erreur lors de la validation de la facture :", error);
        //         }
        //     }

        //     // Handle credit case
        //     if (Versement < Total || InputVersement.value === '0') {
        //         const Etat = 'Crédit';

        //         try {
        //             // Validate the invoice as credit
        //             await $.ajax({
        //                 url: `/valider-facture/${IdUser}/${IdFacture}/${IdCaisse}/${IdClient}/valeurs/${Total}/${Versement}/${Credit}/${Etat}`,
        //                 type: 'put',
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 }
        //             });

        //             Swal.fire({
        //                 title: "Facture Validée (Crédit)",
        //                 icon: "success",
        //                 showConfirmButton: false,
        //                 timer: 1500
        //             });

        //             // Open the PDF ticket in a new tab
        //             window.open('/imprimer-ticket/' + IdFacture, '_blank');

        //             // Wait for a moment before continuing
        //             await new Promise((resolve) => setTimeout(resolve, 1600));

        //             // Close the modal and reset after the ticket has been opened
        //             $('#FactureModal').modal('hide');
        //             await Nouvelle_Facture();

        //         } catch (error) {
        //             console.error("Erreur lors de la validation ou impression du ticket (Crédit) :", error);
        //         }
        //     }

        //     console.log('Validation Facture exécutée');
        // }



        // async function ValiderFacture() {
        //     const InputTotal = document.getElementById('TotalInput');
        //     const InputVersement = document.getElementById('VersementInput');
        //     const InputCredit = document.getElementById('CreditInput');

        //     const IdUser = document.getElementById('text-id-user').textContent;
        //     const IdCaisse = document.getElementById('text-id-caisse').textContent;
        //     const IdFacture = document.getElementById('text-id-facture').textContent;
        //     const IdClient = document.getElementById('client_select').value;
        //     let Total = parseFloat(InputTotal.value);
        //     let Credit = parseFloat(InputCredit.value);

        //     let Versement;

        //     if (InputVersement.value === '') {
        //         Versement = Total;
        //     } else {
        //         Versement = parseFloat(InputVersement.value);
        //     }

        //     // Full or overpayment case
        //     if (Total > 0 && (Versement === Total || Versement > Total)) {
        //         Versement = Total;
        //         Credit = 0;
        //         const Etat = 'Facture-Payée';

        //         try {
        //             // Validate the invoice
        //             await $.ajax({
        //                 url: `/valider-facture/${IdUser}/${IdFacture}/${IdCaisse}/${IdClient}/valeurs/${Total}/${Versement}/${Credit}/${Etat}`,
        //                 type: 'put',
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 }
        //             });

        //             Swal.fire({
        //                 title: "Facture Validée",
        //                 icon: "success",
        //                 showConfirmButton: false,
        //                 timer: 1500
        //             });

        //             // Print the PDF ticket directly using an iframe
        //             printTicket(IdFacture);

        //             // Wait before continuing
        //             await new Promise((resolve) => setTimeout(resolve, 1600));

        //             // Close the modal and reset after the print
        //             $('#FactureModal').modal('hide');
        //             await Nouvelle_Facture();

        //         } catch (error) {
        //             console.error("Erreur lors de la validation de la facture :", error);
        //         }
        //     }

        //     // Handle credit case
        //     if (Versement < Total || InputVersement.value === '0') {
        //         const Etat = 'Crédit';

        //         try {
        //             // Validate the invoice as credit
        //             await $.ajax({
        //                 url: `/valider-facture/${IdUser}/${IdFacture}/${IdCaisse}/${IdClient}/valeurs/${Total}/${Versement}/${Credit}/${Etat}`,
        //                 type: 'put',
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 }
        //             });

        //             Swal.fire({
        //                 title: "Facture Validée (Crédit)",
        //                 icon: "success",
        //                 showConfirmButton: false,
        //                 timer: 1500
        //             });

        //             // Print the PDF ticket directly using an iframe
        //             printTicketCredit(IdFacture);

        //             // Wait before continuing
        //             await new Promise((resolve) => setTimeout(resolve, 1600));

        //             // Close the modal and reset after the print
        //             $('#FactureModal').modal('hide');
        //             await Nouvelle_Facture();

        //         } catch (error) {
        //             console.error("Erreur lors de la validation ou impression du ticket (Crédit) :", error);
        //         }
        //     }

        //     console.log('Validation Facture exécutée');
        // }

        // // Function to print the ticket
        // function printTicket(IdFacture) {
        //     // Create an iframe dynamically
        //     let iframe = document.createElement('iframe');
        //     iframe.style.display = 'none'; // Hide the iframe
        //     iframe.src = `/imprimer-ticket/${IdFacture}`; // Load the ticket PDF URL
        //     document.body.appendChild(iframe);

        //     // Wait for the iframe to load, then trigger the print
        //     iframe.onload = function() {
        //         iframe.contentWindow.print(); // Trigger the print dialog
        //     };
        // }

        // // Function to print the ticket
        // function printTicketCredit(IdFacture) {
        //     // Create an iframe dynamically
        //     let iframe = document.createElement('iframe');
        //     iframe.style.display = 'none'; // Hide the iframe
        //     iframe.src = `/imprimer-ticket-credit/${IdFacture}`; // Load the ticket PDF URL
        //     document.body.appendChild(iframe);

        //     // Wait for the iframe to load, then trigger the print
        //     iframe.onload = function() {
        //         iframe.contentWindow.print(); // Trigger the print dialog
        //     };
        // }



        async function ValiderFacture() {
            const InputTotal = document.getElementById('TotalInput');
            const InputVersement = document.getElementById('VersementInput');
            const InputCredit = document.getElementById('CreditInput');

            const IdUser = document.getElementById('text-id-user').textContent;
            const IdCaisse = document.getElementById('text-id-caisse').textContent;
            const IdFacture = document.getElementById('text-id-facture').textContent;
            const IdClient = document.getElementById('client_select').value;
            let Total = parseFloat(InputTotal.value);
            let Credit = parseFloat(InputCredit.value);

            let Versement;

            if (InputVersement.value === '') {
                Versement = Total;
            } else {
                Versement = parseFloat(InputVersement.value);
            }

            let Etat;

            // Case: no credit
            if (Total > 0 && (Versement === Total || Versement > Total)) {
                Versement = Total;
                Credit = 0;
                Etat = 'Facture-Payée';
            } else {
                // Case: credit
                Etat = 'Crédit';
            }

            try {
                // AJAX request to validate the invoice
                await $.ajax({
                    url: '/valider-facture/' + IdUser + '/' + IdFacture + '/' + IdCaisse + '/' + IdClient +
                        '/valeurs/' + Total + '/' + Versement + '/' + Credit + '/' + Etat,
                    type: 'put',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Facture Validée",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            } catch (error) {
                console.error("Erreur lors de la validation de la facture :", error);
            }

            // Case: if invoice is a credit, print two copies (client + archive)
            if (Etat === 'Crédit') {
                // Open and print the client copy
                let iframeClient = document.createElement('iframe');
                iframeClient.style.display = 'none';
                iframeClient.src = '/imprimer-ticket/' + IdFacture;
                document.body.appendChild(iframeClient);

                iframeClient.onload = function() {
                    iframeClient.contentWindow.print();

                    // After printing the client copy, print the archive copy
                    setTimeout(function() {
                        let iframeArchive = document.createElement('iframe');
                        iframeArchive.style.display = 'none';
                        iframeArchive.src = '/imprimer-ticket-credit/' +
                        IdFacture; // Make sure to create a route for archive copy
                        document.body.appendChild(iframeArchive);

                        iframeArchive.onload = function() {
                            iframeArchive.contentWindow.print();
                        };
                    }, 1000); // Adjust delay if needed
                };
            } else {
                // Case: not credit, print only one copy
                let iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.src = '/imprimer-ticket/' + IdFacture;
                document.body.appendChild(iframe);

                iframe.onload = function() {
                    iframe.contentWindow.print();
                };
            }

            // Close the modal and create a new invoice
            await $('#FactureModal').modal('hide');
            await Nouvelle_Facture();

            console.log('Validation Facture executé');
        }



        // ---------------------------------------------------------------------------------------------------------------



        function TotalClick() {
            const InputTotal = document.getElementById('TotalInput');
            const InputVersement = document.getElementById('VersementInput');
            const InputCredit = document.getElementById('CreditInput');

            // Assigner la valeur de InputTotal comme placeholder de InputVersement
            InputVersement.value = '';
            InputVersement.placeholder = InputTotal.value;

            // Mettre la valeur de CreditInput à 0.00
            InputCredit.value = '0.00';
            InputCredit.placeholder = '0.00';
        }


        document.getElementById('TotalInput').addEventListener('focus', function() {
            TotalClick();
        });




        function CalculerCredit() {
            const InputTotal = document.getElementById('TotalInput');
            const InputVersement = document.getElementById('VersementInput');
            const InputCredit = document.getElementById('CreditInput');
            const LabelCredit = document.getElementById(
                'LabelCredit'); // Assurez-vous que cet ID correspond à un label HTML

            let Versement;
            let Credit;
            let Difference;
            let Total = parseFloat(InputTotal.value); // Correction : utilise la valeur de InputTotal

            // Vérifie si le versement est vide ou invalide
            if (InputVersement.value !== '' && !isNaN(InputVersement.value)) {
                Versement = parseFloat(InputVersement.value);

                // Si le versement est inférieur au total
                if (Versement < Total) {
                    Difference = Total - Versement;
                    // LabelCredit.textContent = '';
                    LabelCredit.textContent = 'Crédit';
                    InputCredit.value = Difference.toFixed(2);
                }

                // Si le versement est supérieur au total
                if (Versement > Total) {
                    Difference = Versement - Total;
                    // LabelCredit.textContent = '';
                    LabelCredit.textContent = 'Remettre au client';
                    InputCredit.value = Difference.toFixed(2);
                }

            } else {
                // Si le versement est vide ou invalide
                InputCredit.value = '0.00';
                LabelCredit.textContent = 'Crédit';
                InputVersement.placeholder = Total.toFixed(2);
            }

            console.log('( Crédit | Monnaie ) Calculé !');
        };


        async function FactureEnAttente() {
            const LabelTotal = document.getElementById('text_total_facture').textContent;
            const IdFacture = document.getElementById('text-id-facture').textContent;

            if (LabelTotal !== '0.00') {
                try {
                    let Total = parseFloat(LabelTotal);
                    Total = Total.toFixed(2);
                    const response = await $.ajax({
                        url: '/en-attente-facture/' + IdFacture + '/valeurs/' + Total,
                        type: 'put',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // Assurez-vous que cette balise meta est incluse dans votre HTML
                        }
                    });

                    // Affiche une alerte SweetAlert après la réussite de l'AJAX
                    await Swal.fire({
                        title: "Vente En-Attente",
                        icon: "info",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // Appelle la fonction Nouvelle_Facture
                    await Nouvelle_Facture();

                } catch (error) {
                    console.error("Erreur lors de la validation de la facture :", error);
                    // Gère l'erreur si nécessaire
                }
            };
            if (LabelTotal === '0.00') {
                Swal.fire({
                    title: "Facture Vide",
                    icon: "warning",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }
    </script>

    <script>
        document.getElementById('kgModal').addEventListener('show.bs.modal', function() {
            clearInput();
        });
    </script>




    {{-- calculatrice  --}}


    <style>
        .calculator {
            padding: 20px;
        }

        #result {
            width: 100%;
            height: 40px;
            text-align: right;
            font-size: 24px;
            margin-bottom: 20px;
            padding-right: 10px;
        }

        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 10px;
        }

        button {
            height: 70px;
            padding: 20px;
            font-size: 18px;
            border: none;
            background-color: #f1f1f1;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #d3d3d3;
        }

        button:active {
            background-color: #a9a9a9;
        }
    </style>


    <!-- Modal -->
    <div class="modal fade" id="calculatorModal" tabindex="-1" aria-labelledby="calculatorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="calculatorModalLabel">Calculatrice</h5>
                    <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="calculator">
                        <input type="text" id="display" class="form-control mb-3" readonly placeholder="0">

                        <div class="row">
                            <div class="col"><button class="btn btn-danger w-100" onclick="clearDisplay()">C</button>
                            </div>
                            <div class="col"><button class="btn btn-warning w-100" onclick="deleteLast()">DEL</button>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col"><button class="btn btn-secondary w-100"
                                    onclick="appendNumber('7')">7</button></div>
                            <div class="col"><button class="btn btn-secondary w-100"
                                    onclick="appendNumber('8')">8</button></div>
                            <div class="col"><button class="btn btn-secondary w-100"
                                    onclick="appendNumber('9')">9</button></div>
                            <div class="col"><button class="btn btn-primary w-100"
                                    onclick="appendNumber('/')">/</button></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col"><button class="btn btn-secondary w-100"
                                    onclick="appendNumber('4')">4</button></div>
                            <div class="col"><button class="btn btn-secondary w-100"
                                    onclick="appendNumber('5')">5</button></div>
                            <div class="col"><button class="btn btn-secondary w-100"
                                    onclick="appendNumber('6')">6</button></div>
                            <div class="col"><button class="btn btn-primary w-100"
                                    onclick="appendNumber('*')">*</button></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col"><button class="btn btn-secondary w-100"
                                    onclick="appendNumber('1')">1</button></div>
                            <div class="col"><button class="btn btn-secondary w-100"
                                    onclick="appendNumber('2')">2</button></div>
                            <div class="col"><button class="btn btn-secondary w-100"
                                    onclick="appendNumber('3')">3</button></div>
                            <div class="col"><button class="btn btn-primary w-100"
                                    onclick="appendNumber('-')">-</button></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col"><button class="btn btn-success w-100" onclick="calculate()">=</button>
                            </div>
                            <div class="col"><button class="btn btn-secondary w-100"
                                    onclick="appendNumber('0')">0</button></div>
                            <div class="col"><button class="btn btn-secondary w-100"
                                    onclick="appendNumber('.')">.</button></div>
                            <div class="col"><button class="btn btn-primary w-100"
                                    onclick="appendNumber('+')">+</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script>
        function appendNumber(number) {
            const display = document.getElementById('display');
            display.value += number; // Ajouter la valeur à l'affichage
        }

        function clearDisplay() {
            const display = document.getElementById('display');
            display.value = ''; // Effacer l'affichage
        }

        function deleteLast() {
            const display = document.getElementById('display');
            display.value = display.value.slice(0, -1); // Supprimer le dernier caractère
        }

        function calculate() {
            const display = document.getElementById('display');
            try {
                display.value = eval(display
                    .value); // Évaluer l'expression (attention aux failles XSS dans d'autres contextes)
            } catch (e) {
                display.value = 'Erreur'; // Afficher une erreur si l'évaluation échoue
                // display.value = ''; // Afficher une erreur si l'évaluation échoue
            }
        }
    </script>
@endsection

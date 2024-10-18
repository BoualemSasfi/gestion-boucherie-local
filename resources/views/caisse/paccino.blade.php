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

    <style>
        .bouton-action {
            height: 70px; 
        } 
        .bouton-caisse {
            font-size: 10px;
            /* padding: 10px; */
            height: 100%;
        }

        .bouton-caisse i {
            font-size: 28px;
            /* margin-top: 2px; */
            /* padding-top: 3px; */
            padding-bottom: 3px;
        }
    </style>

    <style>
        .carousel-item {
            transition: transform 0.3s ease-in-out;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 100px !important;
            /* Ajuster la largeur des boutons */
            height: 100%;
            /* Ajuster la hauteur des boutons */
            opacity: 0.1 !important;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            opacity: 0.3 !important;
        }


        .carousel-control-prev {
            left: 0;
            /* Ajuster la position du bouton précédent */
        }

        .carousel-control-next {
            right: 0;
            /* Ajuster la position du bouton suivant */
        }
    </style>

    <style>
        .petit_font {
            font-size: 14px;
        }
    </style>
    {{-- ---------------------------------------------------------------------------------------------------- --}}
    <!-- AFFICHEUR -->
    <div class="container-fluid m-0 p-0">
        {{-- <div class="container">
            <div class="row">
                <div class="col-12 mb-6"></div>
                <!-- Input pour le port COM -->
                <input type="text" id="port" value="COM4" style="display:none;">
            
            
                <!-- Bouton de connexion -->
                <button id="connectButton" >Connecter au Port Série</button>
            </div>
        </div> --}}
        <div class="container-fluid">
            <div class="row afficheur text-center pt-1 pb-1 pr-0 pl-0 mt-1 mb-1">
                <div class="col-2 align-content-center">
                    <h5 class="objet-titre digital" id="categorie_text" style="font-weight:bold;">----</h5>
                    <h5 class="objet-titre digital" id="produit_text">----</h5>
                </div>
                <div class="col-3 pt-1">
                    <h6 class="afficheur-titre">
                        <span>Manuelle</span>
                        <label class="switch">
                            <input type="checkbox" id="toggleBalance">
                            <span class="slider"></span>
                        </label>
                        <span>Balance</span>
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
            <div class="col-8 pb-4">
                <div class="container mt-2">
                    <div class="your-carousel" data-aos="fade-right">
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
                <div class="container" style="max-height: 450px; overflow-y: auto;">
                    <h6 id="titre-categorie" class="p-0 m-0"></h6>
                    <div class="row" id="products">
                        <!-- Les produits filtrés apparaîtront ici -->
                    </div>

                </div>
                {{-- <div class="col-12 zyada" style="height: 100px;"></div> --}}
            </div>

            <!-- Facture -->
            <div class="col-4 bg-dark p-0 m-0">

                {{-- stockage variable  --}}
                <a href="" style="color: aliceblue; display: none;">USER / FACTURE / MAGASIN / CAISSE</a>
                <a id="text-id-user" href="" style="display: none;">{{ $id_user }}</a>
                <a id="text-id-facture" href="" style="display: none;">{{ $LastFacture->id }}</a>
                <a id="text-id-magasin" href="" style="display: none;">{{ $id_magasin }}</a>
                <a id="text-id-caisse" href="" style="display: none;">{{ $id_caisse }}</a>
                {{-- stockage variable  --}}

                <div class="card shadow m-2" style="height:470px;" data-aos="flip-left">
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
                    <div class="card-body m-0 p-1" style="max-height: 500px; overflow-y: auto;">
                        <table id="affichage-produits-facture" class="text-left" style="width:100%">
                            <thead>
                                <tr>
                                    <th>LIBELLE:</th>
                                    <th>QTE:</th>
                                    <th>P.U:</th>
                                    <th>TOTAL:</th>
                                    <th></th>
                                    <th></th>
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
            <div class="container-fluid boutons-caisse m-0 p-0">
                <div class="row align-content-center m-0 p-0">
                    <div class="col-6">
                        <div class="row bouton-action">

                            <div class="col-3">
                                <button class="btn btn-dark bouton-caisse" type="button" data-bs-toggle="modal"
                                    data-bs-target="#calculatorModal">
                                    <i class="fas fa-calculator fa-lg"></i>
                                    <br>Calculatrice
                                </button>
                            </div>
                            <div class="col-3">
                                {{-- Bouton pour afficher le popup --}}
                                <button class="btn btn-dark bouton-caisse" type="button" data-bs-toggle="modal"
                                    data-bs-target="#ListeFacturesModal" onclick="liste_factures_historique()">
                                    <i class="fa fa-shopping-cart fa-lg"></i>
                                    <br> Historique Ventes
                                </button>

                                <!-- Popup -->
                                <div class="modal fade" id="ListeFacturesModal" tabindex="-1" aria-labelledby=""
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                                        <div class="modal-content">
                                            <!-- Corps du modal -->
                                            <div class="modal-body">
                                                <h4 class="modal-title" id="">Liste des ventes</h4>
                                                <div class="container bg-light mt-2 mb-2" style="height:450px;">
                                                    <div class="row">
                                                        <table id="example" class="display" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Client</th>
                                                                    <th>Date et heure</th>
                                                                    <th>Etat</th>
                                                                    <th>Montant</th>
                                                                    <th>Versement</th>
                                                                    <th>Crédit</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="historique-factures">
                                                                {{-- les factures ici  --}}
                                                            </tbody>
                                                            <a href="" id="id_vente" style="display: none;"></a>
                                                        </table>

                                                    </div>
                                                </div>

                                            </div>

                                            <div class="modal-footer m-0 p-2">
                                                <div class="container pl-0">
                                                    <div class="row">
                                                        <div class="col-12">

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
                                <button class="btn btn-danger bouton-caisse" type="button" style="display: none;">
                                    <i class="fas fa-store-alt fa-lg"></i>
                                    <br> Retour
                                </button>
                            </div>

                            {{-- <div class="col-3">
                                <button class="btn btn-dark bouton-caisse" type="button">
                                    <i class="fa fa-users fa-lg" aria-hidden="true"></i>
                                    <br>Clients
                                </button>
                            </div> --}}
                            <div class="col-3">
                                {{-- Bouton pour afficher le popup --}}
                                <button class="btn btn-warning bouton-caisse" type="button" data-bs-toggle="modal"
                                    data-bs-target="#ListeEnAttenteModal" id="bouton_liste_enattente"
                                    onclick="liste_factures_enattente()">
                                    <i class="fas fa-user-clock fa-lg"></i>
                                    <br>Liste En Attente
                                </button>

                                <!-- Popup -->
                                <div class="modal fade" id="ListeEnAttenteModal" tabindex="-1" aria-labelledby=""
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <!-- Corps du modal -->
                                            <div class="modal-body">
                                                <h4 class="modal-title" id="">Liste des ventes en attente</h4>
                                                {{-- les factures s'affichent ici  --}}
                                                {{-- <div class="mt-3" id="liste-factures">
                                                </div> --}}
                                                <div id="carouselExample1" class="carousel slide mt-3 mb-3 bg-dark"
                                                    data-bs-interval="false" style="height:470px;">

                                                    <div class="carousel-inner" id="CarouselFacturesEnAttente">
                                                        {{-- les factures s'affichent ici  --}}
                                                    </div>

                                                    <!-- Indicateurs de progression -->
                                                    <div class="carousel-indicators"
                                                        id="CarouselFacturesEnAttente_indicateurs">

                                                    </div>

                                                    <button class="carousel-control-prev bg-dark" type="button"
                                                        data-bs-target="#carouselExample1" data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon"
                                                            aria-hidden="true"></span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next bg-dark" type="button"
                                                        data-bs-target="#carouselExample1" data-bs-slide="next">
                                                        <span class="carousel-control-next-icon"
                                                            aria-hidden="true"></span>
                                                        <span class="visually-hidden">Next</span>
                                                    </button>

                                                </div>
                                            </div>

                                            <div class="modal-footer m-0 p-2">
                                                <div class="container pl-0">
                                                    <div class="row">
                                                        <div class="col-12">

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
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="row bouton-action">
                            

                            <div class="col-6">
                                <button class="btn btn-primary bouton-caisse" type="button" onclick="FactureEnAttente()">
                                    <i class="fa fa-pause-circle fa-lg"></i>
                                    <br>Vente En Attente
                                </button>
                            </div>

                            <div class="col-6">
                                {{-- Bouton pour afficher le popup --}}
                                <button class="btn btn-success bouton-caisse" type="button" data-bs-toggle="modal"
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
                                                                inputmode="decimal" readonly>
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


                        </div>
                    </div>

                    {{-- <div class="col-4">
                        <div class="row bouton-action">
                            
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
                    </div> --}}


                </div>
            </div>
        </footer>
    </div>



    <!-- Popup changement de prix -->
    <div class="modal fade" id="PrixModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <!-- En-tête du modal -->
                {{-- <div class="modal-header">
                <h4 class="modal-title" id="FactureModalLabel">BLABLABLABLABLA :</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> --}}
                <!-- Corps du modal -->
                <div class="modal-body">
                    <h4 class="modal-title" id="">MODIFIER LE PRIX</h4>
                    <div class="mt-3">

                        <div class="row justify-content-center">

                            <div class="col-8">
                                <div class="input-group mb-3 mt-3">
                                    <span class="input-group-text" id="inputGroup-sizing-lg">Prix Total :</span>
                                    <input type="number" id="PriceInput" class="form-control" placeholder="0.00"
                                        style="text-align: center; font-size:26px;" inputmode="decimal" aria-label=""
                                        value="" aria-describedby="inputGroup-sizing-lg" readonly>
                                </div>
                                {{-- <label for="versementInput">Prix Total :</label>
                                <input type="number" id="TotalInput" class="form-control" placeholder="0.00"
                                    style="text-align: center; font-size:26px;" inputmode="decimal" readonly> --}}
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 h-100">
                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                    onclick="PrixAppendValue('1')" style="width:100%;">1</button>
                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                    onclick="PrixAppendValue('4')" style="width:100%;">4</button>
                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                    onclick="PrixAppendValue('7')" style="width:100%;">7</button>
                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                    onclick="PrixAppendValue('0')" style="width:100%;">0</button>
                            </div>
                            <div class="col-4 h-100">
                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                    onclick="PrixAppendValue('2')" style="width:100%;">2</button>
                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                    onclick="PrixAppendValue('5')" style="width:100%;">5</button>
                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                    onclick="PrixAppendValue('8')" style="width:100%;">8</button>
                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                    onclick="PrixAppendValue('00')" style="width:100%;">00</button>
                            </div>
                            <div class="col-4 h-100">
                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                    onclick="PrixAppendValue('3')" style="width:100%;">3</button>
                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                    onclick="PrixAppendValue('6')" style="width:100%;">6</button>
                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                    onclick="PrixAppendValue('9')" style="width:100%;">9</button>
                                <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold"
                                    onclick="PrixAppendValue('000')" style="width:100%;">000</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer m-0 p-2">
                    <div class="container pl-0">
                        <div class="row justify-content-center">

                            <div class="col-4">
                                <form class="" data-id=""></form>
                                <button type="button" class="btn btn-success" onclick="ValiderPrixProduit()"
                                    style="width: 150px;">
                                    <i class="bi bi-check-lg"></i><br>Valider
                                </button>

                            </div>
                            <div class="col-4">
                                <button type="button" class="btn btn-danger" onclick="ClearPrixInput()"
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
        $('body').css('overflow', 'auto');
    </script>


    {{-- ---------------------------------------------------------------------------------------------- --}}

    {{-- script pour la balance  --}}

    {{-- <script>
        const balanceElement = document.getElementById('balance');
        const prixUnitaireElement = document.getElementById('prix_unitaire');
        const prixTotalElement = document.getElementById('prix_total');
        const toggleBalance = document.getElementById('toggleBalance');
        let port;
        let reader; // Variable pour stocker le lecteur

        // Fonction pour se connecter ou se déconnecter de la balance
        async function toggleConnection() {
            if (toggleBalance.checked) {
                await connectToSerialPort(); // Connecter à la balance si la case est cochée
            } else {
                if (port) {
                    // Relâcher le verrou du lecteur avant de fermer le port
                    if (reader) {
                        await reader.releaseLock();
                        reader = null; // Réinitialiser la variable reader
                    }
                    await port.close(); // Fermer le port si ouvert
                    port = null; // Réinitialiser la variable port
                }
                balanceElement.textContent = '0.000'; // Réinitialiser l'affichage du poids
                prixTotalElement.textContent = '0.00'; // Réinitialiser le prix total
            }
        }

        // Fonction pour se connecter au port série (COM4) et lire les données en temps réel
        async function connectToSerialPort() {
            try {
                port = await navigator.serial.requestPort();
                await port.open({
                    baudRate: 9600
                });

                reader = port.readable.getReader(); // Stocker le lecteur dans la variable

                while (true) {
                    const {
                        value,
                        done
                    } = await reader.read();
                    if (done) {
                        reader.releaseLock(); // Relâcher le verrou si la lecture est terminée
                        break;
                    }

                    // Convertir les données lues en chaîne de caractères
                    const textDecoder = new TextDecoder();
                    const data = textDecoder.decode(value);

                    // Extraire uniquement la partie numérique (poids) des données reçues
                    const match = data.match(/-?\d+(\.\d+)?/);
                    if (match) {
                        const weight = parseFloat(match[0]);
                        balanceElement.textContent = weight.toFixed(3); // Mettre à jour la balance

                        // Appeler la fonction pour calculer le prix total
                        calculer_total_vente(weight);
                    }
                }
            } catch (error) {
                console.error('Erreur de connexion au port série :', error);
            }
        }

        // Fonction pour calculer le prix total en temps réel
        function calculer_total_vente(weight) {
            const PrixUnitaire = parseFloat(prixUnitaireElement.textContent);
            if (!isNaN(weight) && !isNaN(PrixUnitaire)) {
                const Total = (PrixUnitaire * weight).toFixed(2);
                prixTotalElement.textContent = Total;
            }
        }

        // Écouter les changements de la case à cocher
        toggleBalance.addEventListener('change', toggleConnection);

        // Initialiser l'état de la saisie
        function init() {
            toggleConnection(); // Appeler la fonction pour établir la connexion initiale
        }

        // Appeler la fonction d'initialisation
        init();
    </script> --}}


    <script>
        const balanceElement = document.getElementById('balance');
        const prixUnitaireElement = document.getElementById('prix_unitaire');
        const prixTotalElement = document.getElementById('prix_total');
        const toggleBalance = document.getElementById('toggleBalance');
        let port;
        let reader; // Variable pour stocker le lecteur

        // Fonction pour se connecter ou se déconnecter de la balance
        async function toggleConnection() {
            if (toggleBalance.checked) {
                await connectToSerialPort(); // Connecter à la balance si la case est cochée
            } else {
                if (port) {
                    // Relâcher le verrou du lecteur avant de fermer le port
                    if (reader) {
                        try {
                            await reader.releaseLock(); // Relâcher le verrou uniquement si reader est défini
                        } catch (error) {
                            console.error('Erreur lors de la libération du lecteur :', error);
                        }
                        reader = null; // Réinitialiser la variable reader
                    }
                    await port.close(); // Fermer le port si ouvert
                    port = null; // Réinitialiser la variable port
                }
                balanceElement.textContent = '0.000'; // Réinitialiser l'affichage du poids
                prixTotalElement.textContent = '0.00'; // Réinitialiser le prix total
            }
        }

        // Fonction pour se connecter au port série (COM4) et lire les données en temps réel
        async function connectToSerialPort() {
            try {
                port = await navigator.serial.requestPort();
                await port.open({
                    baudRate: 9600
                });

                reader = port.readable.getReader(); // Stocker le lecteur dans la variable

                while (true) {
                    const {
                        value,
                        done
                    } = await reader.read();
                    if (done) {
                        if (reader) {
                            await reader.releaseLock(); // Relâcher le verrou si la lecture est terminée
                        }
                        break;
                    }

                    // Convertir les données lues en chaîne de caractères
                    const textDecoder = new TextDecoder();
                    const data = textDecoder.decode(value);

                    // Extraire uniquement la partie numérique (poids) des données reçues
                    const match = data.match(/-?\d+(\.\d+)?/);
                    if (match) {
                        const weight = parseFloat(match[0]);
                        balanceElement.textContent = weight.toFixed(3); // Mettre à jour la balance

                        // Appeler la fonction pour calculer le prix total
                        calculer_total_vente(weight);
                    }
                }
            } catch (error) {
                console.error('Erreur de connexion au port série :', error);
            }
        }

        // Fonction pour calculer le prix total en temps réel
        function calculer_total_vente(weight) {
            const PrixUnitaire = parseFloat(prixUnitaireElement.textContent);
            if (!isNaN(weight) && !isNaN(PrixUnitaire)) {
                const Total = (PrixUnitaire * weight).toFixed(2);
                prixTotalElement.textContent = Total;
            }
        }

        // Écouter les changements de la case à cocher
        toggleBalance.addEventListener('change', toggleConnection);

        // Initialiser l'état de la saisie
        function init() {
            toggleConnection(); // Appeler la fonction pour établir la connexion initiale
        }

        // Appeler la fonction d'initialisation
        init();
    </script>




    {{-- <script>
            const balanceElement = document.getElementById('balance');
            const prixUnitaireElement = document.getElementById('prix_unitaire');
            const prixTotalElement = document.getElementById('prix_total');
            let port;

            // Fonction pour se connecter au port série (COM4) et lire les données en temps réel
            async function connectToSerialPort() {
                try {
                    port = await navigator.serial.requestPort();
                    await port.open({
                        baudRate: 9600
                    });

                    const reader = port.readable.getReader();

                    while (true) {
                        const {
                            value,
                            done
                        } = await reader.read();
                        if (done) {
                            reader.releaseLock();
                            break;
                        }

                        // Convertir les données lues en chaîne de caractères
                        const textDecoder = new TextDecoder();
                        const data = textDecoder.decode(value);
                        //   console.log("Données brutes reçues : ", data);

                        // Extraire uniquement la partie numérique (poids) des données reçues
                        const match = data.match(/-?\d+(\.\d+)?/);

                        if (match) {
                            const weight = parseFloat(match[0]);
                            balanceElement.textContent = weight.toFixed(3); // Mettre à jour la balance

                            // Appeler la fonction pour calculer le prix total
                            calculer_total_vente(weight);
                        } else {
                            // console.error("Les données ne sont pas un nombre valide : ", data);
                        }
                    }
                } catch (error) {
                    console.error('Erreur de connexion au port série :', error);
                }
            }

            // Fonction pour calculer le prix total en temps réel
            function calculer_total_vente(weight) {
                const PrixUnitaire = parseFloat(prixUnitaireElement.textContent); // Récupérer le prix unitaire

                // Vérifier que les valeurs sont bien des nombres
                if (!isNaN(weight) && !isNaN(PrixUnitaire)) {
                    const Total = (PrixUnitaire * weight).toFixed(2); // Calcul du total avec 2 décimales
                    prixTotalElement.textContent = Total; // Mettre à jour le prix total
                } else {
                    console.error('Poids ou prix unitaire invalide');
                }

                console.log('Calcul Total Vente exécuté : ', weight, PrixUnitaire);
            }

            // Ajouter un événement de clic au bouton pour déclencher la connexion à la balance
            const connectButton = document.getElementById('connectButton');
            connectButton.addEventListener('click', connectToSerialPort);

    </script> --}}



    {{-- <script>
        const balanceElement = document.getElementById('balance');
        const connectButton = document.getElementById('connectButton');
        let port;
    
        // Fonction pour se connecter au port série (COM4)
        async function connectToSerialPort() {
          try {
            // Demande à l'utilisateur de choisir un port série
            port = await navigator.serial.requestPort();
            // Ouvrir le port avec des paramètres de communication spécifiques
            await port.open({ baudRate: 9600 });  // Ajuster selon votre appareil
    
            const reader = port.readable.getReader();
    
            // Boucle pour lire les données
            while (true) {
              const { value, done } = await reader.read();
              if (done) {
                // Fermer le port si terminé
                reader.releaseLock();
                break;
              }
    
              // Convertir les données lues en chaîne de caractères
              const textDecoder = new TextDecoder();
              const data = textDecoder.decode(value);
    
              // Journaliser les données pour voir ce qui est reçu
            //   console.log("Données brutes reçues : ", data);
    
              // Extraire uniquement la partie numérique (y compris les signes négatifs et décimales)
              const match = data.match(/-?\d+(\.\d+)?/);
              
              if (match) {
                // Convertir la partie numérique en float et afficher avec 3 décimales
                const weight = parseFloat(match[0]);
                balanceElement.textContent = weight.toFixed(3);
              } else {
                // console.error("Les données ne sont pas un nombre valide : ", data);
              }
            }
          } catch (error) {
            console.error('Erreur de connexion au port série :', error);
          }
        }
    
        // Ajouter un événement de clic au bouton pour déclencher la connexion
        connectButton.addEventListener('click', connectToSerialPort);

      </script> --}}


    {{-- script pour la balance  --}}

    {{-- <script>
        // Fonction de calcul du total de la vente
        function calculer_total_vente() {
          // Récupération des éléments du DOM
          const Qte = parseFloat(document.getElementById('balance').textContent);
          const PrixUnitaire = parseFloat(document.getElementById('prix_unitaire').textContent);
          const PrixTotal = document.getElementById('prix_total');
      
          // Vérification si les deux valeurs sont bien des nombres
          if (!isNaN(Qte) && !isNaN(PrixUnitaire)) {
            // Calcul du total
            const Total = (PrixUnitaire * Qte).toFixed(2); // 2 décimales pour le total
      
            // Affectation du résultat dans l'élément du prix total
            PrixTotal.textContent = Total;
          } else {
            console.error('Quantité ou prix unitaire invalide');
          }
      
          console.log('Calcul Total Vente exécuté');
        }
      
        // Surveiller les changements de la balance
        const balanceElement = document.getElementById('balance');
        
        // Déclencher le calcul à chaque fois que le contenu de l'élément balance est mis à jour
        const observer = new MutationObserver(() => {
          calculer_total_vente();
        });
      
        // Observer les changements dans le contenu de l'élément balance
        observer.observe(balanceElement, { childList: true });
      </script> --}}


    {{-- ---------------------------------------------------------------------------------------------------- --}}



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
                                '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 mb-4"  data-aos="fade-down">' +
                                '<div class="card scat">' +
                                '<form class="affichage-form" data-id_lestock="' + value.id +
                                '" data-id_produit="' + value.id_produit +
                                '" data-nom="' + value.nom + '" data-prix="' + value.prix +
                                '" onclick="affichage(this)" style="cursor: pointer;">' +
                                '<img src="{{ asset('storage/') }}/' + value.photo +
                                '" class="card-img-top" alt="...">' +
                                '<div class="card-body p-1 m-0 text-center">' +
                                '<h5 class="card-title">' + value.nom + '</h5>' +
                                '<p class="card-text">' + value.prix + ' DA / ' + value.mesure +
                                '</p>' +
                                '</div>' +
                                '</form>' +
                                '</div>' +
                                '</div>'
                            );
                        });

                        $('#products').append(
                            // '<div class="col-12 zyada" style="height: 600px;"></div>'
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




        // function calculer_total_vente() {
        //     const Qte = document.getElementById('balance').textContent;
        //     const PrixUnitaire = document.getElementById('prix_unitaire').textContent;
        //     const PrixTotal = document.getElementById('prix_total');
        //     if (!isNaN(Qte) && !isNaN(PrixUnitaire)) {
        //         qte = parseFloat(qte);
        //         PrixUnitaire = parseFloat(PrixUnitaire);
        //         Total = PrixUnitaire * qte;
        //         Total = Total.toFixed(0);
        //         PrixTotal.textContent = Total;
        //     }

        //     console.log('Calcul Total Vente executé');
        // }





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
                        // let quantite = Number.isInteger(value.quantite) ? parseInt(value.quantite) : value.quantite;
                        let quantite = Number.isInteger(value.quantite) ? value.quantite : parseFloat(
                            value.quantite);

                        $('#ventes_liste').append(
                            '<tr>' +
                            // '<td class="petit_font">' + value.nom_categorie + ' : ' + value.nom_produit +
                            '<td class="petit_font">' + value.nom_produit +
                            '</td>' +
                            '<td class="petit_font">' + quantite + ' ' + value.unite_mesure +
                            '</td>' +
                            '<td class="petit_font">' + value.prix_produit + '</td>' +
                            '<td class="petit_font">' + value.prix_total + '</td>' +
                            '<td class="">' +
                            '<form class="form-prix-produit" data-id="' + value.id +
                            '"><button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#PrixModal" id="bouton_prix" onclick="ModifierPrixProduit(this)">' +
                            '<i class="fas fa-coins"></i></button></form>' +
                            '</td>' +
                            '<td class="">' +
                            '<form class="form-supprimer-produit" data-id="' + value.id +
                            '"><button class="btn btn-danger" type="button" onclick="SupprimerProduit(this)"><i class="fas fa-trash-alt"></i></button></form>' +
                            '</td>' +
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

    <script>
        function SupprimerProduit(button) {
            const form = button.closest('.form-supprimer-produit');
            const IdVente = form.getAttribute('data-id');
            const id_facture = document.getElementById('text-id-facture').textContent;

            if (IdVente) {

                Swal.fire({
                    title: "Voulez vous la supprimée ?",
                    icon: "question",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Oui",
                    denyButtonText: `Non`,
                    customClass: {
                        confirmButton: 'btn-danger',
                        denyButton: 'btn-success'
                    }
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {

                        $.ajax({
                            url: '/supprimer-vente/' + IdVente,
                            type: 'get',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content'
                                ) // Assurez-vous que cette balise meta est incluse dans votre HTML
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: "Supprimée",
                                    icon: "error",
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                ListeVentes(id_facture);

                                Calculer_Total_Facture(id_facture);
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });

                    }
                });

            }
        }
    </script>

    <script>
        function ModifierPrixProduit(button) {
            const form = button.closest('.form-prix-produit');
            const IdVente = form.getAttribute('data-id');
            const total_input = document.getElementById('PriceInput');
            const porteur_IdVente = document.getElementById('id_vente');

            if (IdVente) {
                porteur_IdVente.textContent = IdVente;
                $.ajax({
                    url: '/prix-vente/' + IdVente,
                    type: 'get',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.vente && response.vente.total_vente) {
                            total_input.placeholder = response.vente.total_vente;
                            total_input.value = '';
                            console.log('Id Vente : ' + IdVente);
                            console.log('Total Vente : ' + response.vente.total_vente);
                        } else {
                            console.error('Vente ou total_vente introuvable');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        }

        function ValiderPrixProduit() {
            const porteur_IdVente = document.getElementById('id_vente');
            const IdVente = porteur_IdVente.textContent;
            const nv_prix = document.getElementById('PriceInput').value;
            const id_facture = document.getElementById('text-id-facture').textContent;

            if (nv_prix > 0) {
                $.ajax({
                    url: '/valider-prix-vente/' + IdVente + '/' + nv_prix,
                    type: 'get',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Validé",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        // Ferme le popup
                        $('#PrixModal').modal('hide');

                        ListeVentes(id_facture);

                        Calculer_Total_Facture(id_facture);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                Swal.fire({
                    title: "Erreur de saisie de la quantité",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }

        function PrixAppendValue(value) {
            const input = document.getElementById('PriceInput');
            input.value += value;
        }

        function ClearPrixInput() {
            const input = document.getElementById('PriceInput');
            input.value = '';
        }
    </script>


    {{-- ----------------------------------------------------------------------------------------------  --}}

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

        // ----------------------------------------------------------------------------------------------------
        // en-attente 
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
                        icon: "success",
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
        function liste_factures_enattente() {
            const IdMagasin = document.getElementById('text-id-magasin').textContent;
            // const IdMagasin = 2
            if (IdMagasin) { // Vérifie si IdMagasin n'est pas une chaîne vide
                // console.log('id magasin :' + IdMagasin);
                $.ajax({
                    url: '/liste-factures-enattente/' + IdMagasin,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        let counter = 1; // Initialisation du compteur
                        $('#CarouselFacturesEnAttente').empty();
                        $('#CarouselFacturesEnAttente_indicateurs').empty();
                        if ((!response.factures || response.factures.length === 0)) {
                            $('#CarouselFacturesEnAttente').append(

                                '<div class="carousel-item active">' +
                                '<div class="row justify-content-center">' +
                                '<div class="col-12 mt-3 mb-3">' +
                                '<h3 class="text-secondary text-bold">Liste Vide</h3>' +
                                '</div>' +
                                '</div>' +
                                '</div>'

                            );

                        }
                        $.each(response.factures, function(key, facture) {

                            const id_facture = facture.id;
                            // const ActiveClass = 'active';
                            console.log('id facture :' + id_facture);

                            $('#CarouselFacturesEnAttente').append(

                                '<div class="carousel-item ' + (counter === 1 ? 'active' : '') +
                                '">' +

                                '<div class="card shadow m-3 facture-enattente" style="height:400px;">' +

                                '<div class="card-body m-0 p-1" style="overflow-y: auto;">' +

                                '<div class="container">' +

                                '<div class="row justify-content-center">' +

                                '<div class="col-12 mt-3 mb-3">' +
                                '<h3 class="text-secondary text-bold">FACTURE N° : <b class="text-primary">' +
                                counter + '</b></h3>' +
                                '</div>' +

                                '<div class="col-4">' +
                                '<h5 class="text-secondary mt-3 mb-3">ETAT : EN-ATTENTE </h5>' +
                                '</div>' +

                                '<div class="col-4">' +
                                '<div class="input-group mb-3 mt-3">' +
                                '<span class="input-group-text" id="inputGroup-sizing-lg">Total Facture: </span>' +
                                '<input type="text" class="form-control" aria-label="" aria-describedby="inputGroup-sizing-lg" readonly value="' +
                                facture.total_facture + '">' +
                                '</div>' +
                                '</div>' +

                                '<div class="col-4">' +
                                '<form class="form-ouvrir-facture" data-id="' + id_facture + '">' +
                                '<button type="button" class="btn btn-success" onclick="Ouvrir_facture(this)" style="padding-left:40px;padding-right:40px;"><i class="bi bi-check-lg"></i><br>Ouvrir</button>' +
                                '</form>' +
                                '</div>' +

                                '</div>' +

                                '<div class="row justify-content-start">' +
                                '<div class="col-12">' +

                                '<table class="display m-3 text-left" style="width:100%">' +
                                '<thead>' +
                                '<tr>' +
                                '<th>Designation:</th>' +
                                '<th>Qte:</th>' +
                                '<th>Prix:</th>' +
                                '<th>Total:</th>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody id="produits_facture_' + id_facture + '">' +
                                '</tbody>' +
                                '</table>' +

                                '</div>' +
                                '</div>' +


                                '</div>' +

                                '</div>' +
                                '</div>' +



                                '</div>'
                            );

                            $('#CarouselFacturesEnAttente_indicateurs').append(

                                '<button type="button" data-bs-target="#carouselExample1" data-bs-slide-to="' +
                                (counter - 1) + '" ' + (counter === 1 ?
                                    ' class="active" aria-current="true"' : '') +
                                '></button>'
                            );

                            // Appel AJAX pour récupérer les ventes associées à la facture
                            $.ajax({
                                url: '/ventes/' + id_facture,
                                type: 'GET',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    $.each(response.ventes, function(key, vente) {
                                        let quantite = Number.isInteger(vente
                                                .quantite) ? vente.quantite :
                                            parseFloat(vente.quantite);
                                        $('#produits_facture_' + id_facture).append(
                                            '<tr>' +
                                            '<td class="">' + vente
                                            .nom_categorie + ' : ' + vente
                                            .nom_produit + '</td>' +
                                            '<td class="">' + quantite +
                                            ' ' + vente.unite_mesure + '</td>' +
                                            '<td class="">' + vente
                                            .prix_produit + '</td>' +
                                            '<td class="">' + vente.prix_total +
                                            '</td>' +
                                            '</tr>'
                                        );
                                    });
                                },
                                error: function(xhr, status, error) {
                                    console.error(error);
                                }
                            });

                            counter++; // Déplacer l'incrémentation ici
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    } // Retirer le point-virgule ici
                });

            } else {
                console.error('ERREUR ID');
            }
        }
    </script>

    <script>
        function Ouvrir_facture(button) {
            const form = button.closest('.form-ouvrir-facture');
            const id_facture = form.getAttribute('data-id');
            console.log('--------------------------------------------');
            console.log('id facture : ' + id_facture);

            $.ajax({
                url: '/lafacture-enattente/' + id_facture,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Récupérer l'objet 'facture' depuis la réponse JSON
                    const facture = response.facture;

                    // Assurez-vous que 'facture' n'est pas nul
                    if (facture) {
                        const id_facture = facture.id;
                        const id_magasin = facture.id_magasin;
                        const id_caisse = facture.id_caisse;
                        const id_user = facture.id_user;
                        const total_facture = facture.total_facture;

                        console.log('id facture : ' + id_facture);
                        console.log('id magasin : ' + id_magasin);
                        console.log('id caisse : ' + id_caisse);
                        console.log('id user : ' + id_user);
                        console.log('total : ' + total_facture);

                        Swal.fire({
                            title: "Ouverture de la vente en-attente",
                            icon: "info",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        const AffichageQte = document.getElementById('balance');
                        const AffichagePrixUnitaire = document.getElementById('prix_unitaire');
                        const AffichagePrixTotal = document.getElementById('prix_total');
                        const AffichageNomProduit = document.getElementById('produit_text');

                        ListeVentes(id_facture);

                        Calculer_Total_Facture(id_facture);

                        // Réinitialiser les affichages
                        AffichageQte.textContent = "0.000";
                        AffichagePrixUnitaire.textContent = "0.00";
                        AffichagePrixTotal.textContent = "0.00";
                        AffichageNomProduit.textContent = "----";

                        // let text_id_user = document.getElementById('text-id-user');
                        let text_id_facture = document.getElementById('text-id-facture');
                        let text_id_magasin = document.getElementById('text-id-magasin');
                        // let text_id_caisse = document.getElementById('text-id-caisse');

                        // text_id_user.textContent = id_user;
                        text_id_facture.textContent = id_facture;
                        text_id_magasin.textContent = id_magasin;
                        // text_id_caisse.textContent = id_caisse;

                        // zero();

                        // Ferme le popup
                        $('#ListeEnAttenteModal').modal('hide');

                    } else {
                        console.error('Facture non trouvée');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erreur AJAX:', error);
                }
            });
        }
    </script>


    <script>
        document.getElementById('kgModal').addEventListener('show.bs.modal', function() {
            clearInput();
        });
    </script>

    {{-- ------------------------------------------------------------------------------------------------------ --}}

    <script>
        function liste_factures_historique() {
            const IdMagasin = document.getElementById('text-id-magasin').textContent.trim();
            console.log('--------------------------------------------');
            console.log('id magasin : ' + IdMagasin);

            if (IdMagasin) { // Vérifie si IdMagasin n'est pas une chaîne vide
                $.ajax({
                    url: '/historique-factures/' + IdMagasin,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#historique-factures').empty();

                        $.each(response.factures, function(key, facture) {
                            const id_facture = facture.id;
                            console.log('id facture :' + id_facture);

                            $('#historique-factures').append(
                                '<tr>' +
                                '<td>' + facture.id + '</td>' +
                                '<td>' + facture.client + '</td>' +
                                '<td>' + facture.date + '</td>' +
                                '<td>' + facture.etat + '</td>' +
                                '<td>' + facture.total + '</td>' +
                                '<td>' + facture.versement + '</td>' +
                                '<td>' + facture.credit + '</td>' +
                                '<td>' +
                                '<form class="form-imprimer-facture" data-id="' + id_facture +
                                '">' +
                                '<button type="button" class="btn btn-success" onclick="Ticket(this)" style="padding-left:10px;padding-right:10px;"><i class="fas fa-print fa-lg"></i><br>Imprimer</button>' +
                                '</form>' +
                                '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td colspan="8">' +
                                '<div class="container">' +
                                '<div class="row justify-content-start">' +
                                '<div class="col-12">' +
                                '<table id="" class="text-left" style="width:100%">' +
                                '<thead>' +
                                '<tr>' +
                                '<th style="width:25%;">Designation:</th>' +
                                '<th style="width:25%;">Qte:</th>' +
                                '<th style="width:25%;">Prix:</th>' +
                                '<th style="width:25%;">Total:</th>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody id="ventes_facture_' + id_facture + '">' +
                                '</tbody>' +
                                '</table>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +
                                '</tr>' // Closing the sales row
                            );

                            // Appel AJAX pour récupérer les ventes associées à la facture
                            $.ajax({
                                url: '/ventes/' + id_facture,
                                type: 'GET',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    $.each(response.ventes, function(key, vente) {
                                        let quantite = Number.isInteger(vente
                                                .quantite) ? vente.quantite :
                                            parseFloat(vente.quantite);
                                        $('#ventes_facture_' + id_facture).append(
                                            '<tr>' +
                                            '<td class="">' + vente
                                            .nom_categorie + ' : ' + vente
                                            .nom_produit + '</td>' +
                                            '<td class="">' + quantite +
                                            ' ' + vente.unite_mesure + '</td>' +
                                            '<td class="">' + vente
                                            .prix_produit + '</td>' +
                                            '<td class="">' + vente.prix_total +
                                            '</td>' +
                                            '</tr>'
                                        );
                                    });
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error fetching ventes:', error);
                                }
                            });
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching historique factures:', error);
                    }
                });
            } else {
                console.error('ERREUR ID: ID du magasin est vide');
            }
        }
    </script>

    <script>
        function Ticket(button) {
            const form = button.closest('.form-imprimer-facture');
            const IdFacture = form.getAttribute('data-id');
            console.log('--------------------------------------------');
            console.log('id facture : ' + IdFacture);

            $.ajax({
                url: '/chercher-facture/' + IdFacture,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Récupérer l'objet 'facture' depuis la réponse JSON
                    const facture = response.facture;

                    // Assurez-vous que 'facture' n'est pas nul
                    if (facture) {
                        let iframe = document.createElement('iframe');
                        iframe.style.display = 'none';
                        iframe.src = '/imprimer-ticket/' + IdFacture;
                        document.body.appendChild(iframe);

                        iframe.onload = function() {
                            iframe.contentWindow.print();
                        };
                    } else {
                        console.error('Facture non trouvée');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erreur AJAX:', error);
                }
            });
        }
    </script>





    {{-- ------------------------------------------------------------------------------------------------------ --}}



    {{-- calculatrice  --}}


    <style>
        #calculator {
            padding: 20px;
        }

        #display {
            width: 100%;
            height: 40px;
            text-align: right;
            font-size: 34px;
            margin-bottom: 20px;
            padding: 5px;
        }

        #calculator .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 10px;
        }

        #calculator .btn {
            height: 50px;
            /* padding: 20px; */
            font-size: 20px;
            border: none;
            /* background-color: #f1f1f1; */
            cursor: pointer;
            border-radius: 5px;
            /* transition: background-color 0.3s ease; */
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



    {{-- ------------------------------------------------------------------------------------------------------   --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.querySelector('#carouselExample1');
            const carouselInstance = new bootstrap.Carousel(carousel, {
                wrap: false // Empêche le carrousel de se répéter
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                processing: true,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Tous"]
                ],
                buttons: [], // Ajoutez ici les boutons souhaités
                language: {
                    "lengthMenu": "Afficher _MENU_ éléments par page",
                    "zeroRecords": "Aucun enregistrement trouvé",
                    "info": "Page _PAGE_ sur _PAGES_",
                    "infoEmpty": "Aucun enregistrement disponible",
                    "infoFiltered": "(filtré de _MAX_ total des enregistrements)",
                    "search": "Rechercher :",
                    "paginate": {
                        "first": "Premier",
                        "last": "Dernier",
                        "next": "Suivant",
                        "previous": "Précédent"
                    }
                },
                responsive: true,

            });
        });
    </script>



    {{-- ------------------------------------------------------------------------------------------------------   --}}
@endsection

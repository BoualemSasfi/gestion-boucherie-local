{{-- @extends('layouts.menu_caisse') --}}
@extends('layouts.caisse_provisoir')


@section('content')

<style>
    .big-font {
        font-size: 40px;
    }

    .medium-font {
        font-size: 25px;
    }

    .boutons-saisie div button {
        height: 100px;
        width: 100%;
    }
</style>

<style>
    .mini-text {
        white-space: nowrap;
        /* Empêche le retour à la ligne */
        overflow: hidden;
        /* Cache le texte qui dépasse */
        text-overflow: ellipsis;
        /* Ajoute des points de suspension à la fin */
    }

    .scat {
        height: 160px;
        width: 100%;
    }

    .card-img-top {
        height: 90px;
    }
</style>
{{-- css pour les poppup --}}
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
        font-size: 14px;
        /* padding: 10px; */
        height: 100%;
    }

    .bouton-caisse i {
        font-size: 28px;
        /* margin-top: 2px; */
        /* padding-top: 3px; */
        padding-bottom: 10px;
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

{{-- <style>
    #ventes_liste {
        max-height: 300px;
        overflow-y: auto;
    }
</style> --}}

{{-- ---------------------------------------------------------------------------------------------------- --}}
<!-- AFFICHEUR -->
<div class="container-fluid m-0 p-0" style="height:100vh;">
    {{-- COM port --}}
    {{-- <input type="text" id="port" value="COM1" style="display:none;"> --}}

    {{-- <div class="container">
        <div class="row">
            <div class="col-12 mb-6"></div>
            <!-- Input pour le port COM -->


            <!-- Bouton de connexion -->
            <button id="connectButton">Connecter au Port Série</button>
        </div>
    </div> --}}

    <div class="container-fluid">
        <div class="row afficheur text-center pt-1 pb-1 pr-0 pl-0 mt-1 mb-1">
            <div class="col-2 align-content-center">
                <h5 class="objet-titre digital mini-text" id="categorie_text" style="font-weight:bold;">----</h5>
                <h5 class="objet-titre digital mini-text" id="produit_text">----</h5>
            </div>
            <div class="col-3 pt-1">
                <h6 class="afficheur-titre">
                    <span class="slider-text">Manuelle</span>
                    <label class="switch">
                        <input type="checkbox" id="toggleBalance">
                        <span class="slider"></span>
                    </label>
                    <span class="slider-text">Balance</span>
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
                                    style="text-align: center; font-size:40px;" readonly>
                                <div class="mt-3" style="font-size: 40px;">
                                    <div class="row boutons-saisie">
                                        <div class="col-4">
                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                onclick="appendValue('1')">1</button>
                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                onclick="appendValue('4')">4</button>
                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                onclick="appendValue('7')">7</button>
                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                onclick="appendValue('0')">0</button>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                onclick="appendValue('2')">2</button>
                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                onclick="appendValue('5')">5</button>
                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                onclick="appendValue('8')">8</button>
                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                onclick="appendValue('.')">.</button>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                onclick="appendValue('3')">3</button>
                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                onclick="appendValue('6')">6</button>
                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                onclick="appendValue('9')">9</button>
                                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                onclick="appendValue('00')">00</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer m-0 p-2">

                                <div class="container pl-0">
                                    <div class="row">
                                        <div class="col-4">
                                            <button type="button" class="btn btn-success medium-font"
                                                onclick="ValiderQte()" style="width: 150px;">
                                                <i class="fas fa-check fa-lg"></i><br>Valider
                                            </button>

                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn btn-danger medium-font"
                                                onclick="clearInput()" style="width: 150px;">
                                                <i class="fas fa-eraser fa-lg"></i><br>Effacer
                                            </button>

                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn btn-secondary medium-font"
                                                data-bs-dismiss="modal" style="width: 150px;">
                                                <i class="fas fa-times fa-lg"></i><br>Fermer
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
                <h6 class="afficheur-titre">PRIX UNITAIRE: </h6>
                <p class="digital" id="prix_unitaire" style="margin-top:-20px;">0.00</p>
            </div>
            <div class="col-3 align-content-center">
                <h6 class="afficheur-titre">PRIX TOTAL:</h6>
                <p class="digital" id="prix_total" style="margin-top:-20px;">0.00</p>
            </div>
            <div class="col-1 mt-3 pl-0">

                {{-- pour le produit selectionné --}}
                <a id="text-id-lestock" href="" style="display: none;"></a>
                <a id="text-id-produit" href="" style="display: none;"></a>
                <a id="text-id-sousproduit" href="" style="display: none;"></a>
                {{-- pour le produit selectionné --}}

                <form class="valider-vente-form" data-id_facture="{{ $LastFacture->id }}" data-id_user={{ $id_user }}>
                    <button class="btn btn-success pt-3 pb-3" style="color: white;width:100%;height:100%;" onclick="ValiderVente(this)"
                        type="button">
                        <i class="fas fa-check-circle fa-lg"></i>
                        <br>Valider
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // function FiltrageProduits(form) {
        //     const card = form.querySelector('.card'); // Récupère la carte associée au formulaire
        //     if (card) {
        //         // Supprime le cadre rouge de toutes les autres cartes
        //         document.querySelectorAll('.card.cat').forEach(otherCard => {
        //             otherCard.style.border = ''; // Réinitialise le cadre
        //         });

        //         // Ajoute un cadre rouge à la carte sélectionnée
        //         card.style.border = '2px solid red';
        //     }
        // }
    </script>

    <!-- Produits -->
    <div class="container-fluid pl-4 pr-4">
        <div class="row le_centre">
            <div class="col-8 pb-4">
                <div class="container-fluid mt-2" style="height: 200px;">
                    <div class="row">
                        <div class="col-1"><button id="prev-btn" class="custom-btn">←</button> <!-- Bouton gauche -->
                        </div>
                        <div class="col-10 your-carousel">
                            <!-- <div class=""> -->
                            @foreach ($categories as $categorie)
                                <form class="filter-form" data-id="{{ $categorie->id }}" data-nom="{{ $categorie->nom }}"
                                    onclick="FiltrageProduits(this)" style="cursor: pointer;">
                                    <div class="card cat" style="width: 180px; height: 180px;">
                                        <img src="{{ asset('storage/' . $categorie->photo) }}" class="card-img-top"
                                            alt="..." style="width: 180px; height: 130px;">
                                        <div class="card-body" style="width: 180px; height: 40px;">
                                            <h5 class="card-title mini-text text-center fw-bold" style="margin-top:-10px;">
                                                {{ $categorie->nom }}
                                            </h5>
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                            <!-- </div> -->
                        </div>
                        <div class="col-1"><button id="next-btn" class="custom-btn">→</button> <!-- Bouton droit -->
                        </div>
                    </div>


                </div>


                <style>
                    .custom-btn {
                        background-color: rgba(1, 1, 1, 0.57);
                        /* Couleur sombre translucide */
                        color: #fff;
                        /* Couleur du texte */
                        border: none;
                        /* padding: 10px 35px; */
                        border-radius: 5px;
                        font-size: 40px;
                        font-weight: bold;
                        cursor: pointer;
                        position: absolute;
                        /* top: 50%; */
                        height: 180px;
                        width: 100%;
                        text-align: center;
                        align-content: center;
                        justify-content: center;
                        /* Aligne verticalement au centre */
                        /* transform: translateY(-50%); */
                        /* Centre parfaitement */
                        /* z-index: 1; */
                        /* Assure que les boutons restent au-dessus */
                    }

                    #prev-btn {
                        left: 5px;
                        /* Fixe le bouton à gauche du carousel */
                        /* z-index: 1; */
                    }

                    #next-btn {
                        right: 5px;
                        /* Fixe le bouton à droite du carousel */
                    }

                    .custom-btn:hover {
                        background-color: #0056b3;
                        /* Couleur au survol */
                    }
                </style>




                <hr class="p-0 mb-0 mt-2">

                <div class="container-fluid" style="height: 80%;padding-top:20px;">
                    {{-- <h6 id="titre-categorie" class="p-0 m-0"></h6> --}}
                    <div class="row" id="products" style="max-height: 600px; overflow-y: scroll;">
                        <!-- Les produits filtrés apparaîtront ici -->
                    </div>
                </div>


            </div>

            <!-- Facture -->
            <div class="col-4 bg-dark p-0 m-0" style="position: absolute; height:100vh; right:0;">

                {{-- stockage variable --}}
                <a href="" style="color: aliceblue; display: none;">USER / FACTURE / MAGASIN / CAISSE</a>
                <a id="text-id-user" href="" style="display: none;">{{ $id_user }}</a>
                <a id="text-id-facture" href="" style="display: none;">{{ $LastFacture->id }}</a>
                <a id="text-id-magasin" href="" style="display: none;">{{ $id_magasin }}</a>
                <a id="text-id-caisse" href="" style="display: none;">{{ $id_caisse }}</a>
                {{-- -------------------------------------------- --}}
                <a id="text-id-categorie" href="" style="display: none;">0</a>
                <a id="text-id-categorie" href="" style="display: none;">0</a>
                <a id="text-type-vente" href="" style="display: none;">details</a>
                {{-- -------------------------------------------- --}}
                {{-- stockage variable --}}

                <div class="card shadow m-2" style="height: 85%" data-aos="flip-left">
                    <div class="card-header py-1">
                        <div class="row afficheur text-center" style="height: 110px;" id="facture_afficheur">

                            <div class="col-3 pt-3">
                                <h6 class="afficheur-titre pt-3" id="type_vente_header">Vente En Détails</h6>
                            </div>

                            <div class="col-9 border-start border-1 border-dark">
                                <div class="col-12 p-1 m-0 align-content-center">
                                    <h6 class="afficheur-titre">TOTAL FACTURE :</h6>
                                    <h2 id="text_total_facture" class="digital" style="margin-top:-20px;">0.00</h2>
                                </div>
                                <div class="col-12 p-0 m-0">
                                    <h6 class="afficheur-titre mini-text" style="margin-top:-25px;">CLIENT : <span
                                            id="nom_client" class=" mini-text">CLIENT COMPTOIR</span></h6>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body m-0 p-1" style="height:100%; overflow-y: auto; max-height: 90%;">
                        <table id="affichage-produits-facture" class="text-left" style="width:100%;">
                            <thead>
                                <tr>
                                    <th class="text-left">LIBELLE:</th>
                                    <th class="text-right">QTE:</th>
                                    <th class="text-right">P.U:</th>
                                    <th class="text-right">TOTAL:</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="ventes_liste">
                                <!-- Les lignes de ventes -->
                            </tbody>
                        </table>
                        {{-- <div class="col-12 zyada" style="height: 100px;">CAISSE ESPACE</div> --}}
                    </div>
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
                            <!-- <button class="btn btn-danger bouton-caisse" id="sync-button" type="button"
                                onclick="ActualiserPage()">
                                <i class="fas fa-sync-alt fa-lg"></i>
                            </button> -->
                            <button class="btn btn-danger bouton-caisse" type="button"
                                onclick="ok()">
                                <i class="fas fa-sync-alt fa-lg"></i>
                            </button>

                        </div>
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                        <script>
                            function ok(){
                            location.reload();
                        }
                        </script>

                        <script>
                            function ActualiserPage() {
                                // Ajouter un gestionnaire d'événements pour le bouton de synchronisation
                                document.getElementById("sync-button").addEventListener("click", function () {
                                    // Afficher l'alerte de confirmation
                                    Swal.fire({
                                        title: 'Êtes-vous sûr ?',
                                        text: "Cette action actualisera la page.",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Actualiser',
                                        cancelButtonText: 'Annuler'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Si l'utilisateur confirme, on enregistre les données hors ligne
                                            saveOfflineData({ produit: "Viande", quantité: 2, prix: 1500 })
                                                .then(() => {
                                                    // Actualiser la page après l'enregistrement des données
                                                    location.reload();
                                                })
                                                .catch((error) => {
                                                    console.error('Erreur lors de l\'enregistrement des données:', error);
                                                });
                                        }
                                    });
                                });
                            }

                            // Appel de la fonction pour initialiser l'événement
                            ActualiserPage();
                        </script>




                        <div class="col-3">
                            <button class="btn btn-dark bouton-caisse" type="button" data-bs-toggle="modal"
                                data-bs-target="#calculatorModal">
                                <i class="fas fa-calculator fa-lg"></i>
                                <br>Calculatrice
                            </button>
                        </div>

                        <div class="col-3">
                            <button class="btn btn-dark bouton-caisse" type="button" data-bs-toggle="modal"
                                data-bs-target="#ListeClientsModal" onclick="liste_clients()">
                                <i class="fas fa-user fa-lg"></i>
                                <br>Clients
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
                                                    <table id="example1" class="display" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Code Barres</th>
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
                                                            {{-- les factures ici --}}
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Code Barres</th>
                                                                <th>Client</th>
                                                                <th>Date et heure</th>
                                                                <th>Etat</th>
                                                                <th>Montant</th>
                                                                <th>Versement</th>
                                                                <th>Crédit</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </tfoot>
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


                            {{--
                            ----------------------------------------------------------------------------------------------
                            --}}
                            {{--
                            ----------------------------------------------------------------------------------------------
                            --}}
                            {{-- clients --}}
                            {{--
                            ----------------------------------------------------------------------------------------------
                            --}}
                            {{--
                            ----------------------------------------------------------------------------------------------
                            --}}

                            <!-- Popup -->
                            <div class="modal fade" id="ListeClientsModal" tabindex="-1" aria-labelledby=""
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                                    <div class="modal-content">
                                        <!-- Corps du modal -->
                                        <div class="modal-body">
                                            <h4 class="modal-title" id="">Liste des clients</h4>
                                            <div class="container bg-light mt-2 mb-2" style="height:450px;">
                                                <div class="row">
                                                    <table id="example2" class="display " style="width:100%">
                                                        <thead>
                                                            <tr style="border-bottom: 5px solid #252525;">
                                                                <th>ID</th>
                                                                <th>Client (Nom et Prénom)</th>
                                                                <th>Adresse</th>
                                                                <th>Détails</th>
                                                                <th>N° Tél</th>
                                                                {{-- <th>Tél ooredoo</th>
                                                                <th>Tél mobilis</th>
                                                                <th>Tél djezzy</th> --}}
                                                                <th>Total Crédit</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="liste-clients">
                                                            {{-- les clients ici --}}
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Client (Nom et Prénom)</th>
                                                                <th>Adresse</th>
                                                                <th>Détails</th>
                                                                <th>N° Tél</th>
                                                                {{-- <th>Tél ooredoo</th>
                                                                <th>Tél mobilis</th>
                                                                <th>Tél djezzy</th> --}}
                                                                <th>Total Crédit</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </tfoot>

                                                    </table>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer m-0 p-2">
                                            <div class="container pl-0">
                                                <div class="row">
                                                    <div class="col-12">

                                                        <button type="button" class="btn btn-secondary  medium-font"
                                                            data-bs-dismiss="modal" style="width: 150px;">
                                                            <i class="fas fa-times fa-lg"></i><br>Fermer
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Popup -->
                            <!-- Popup -->
                            <div class="modal fade" id="CreditModal" tabindex="-1" aria-labelledby=""
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- En-tête du modal -->
                                        {{-- <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                            <h4 class="modal-title" id="FactureModalLabel">BLABLABLABLABLA :</h4>
                                        </div> --}}
                                        <!-- Corps du modal -->
                                        <div class="modal-body">
                                            <h4 class="modal-title" id="">VERSEMENT-CREDIT-PAR</h4>

                                            <h5 class="modal-title text-primary" id="credit_nom_client"></h5>
                                            <a id="montant_credit_client" style="display: none;"></a>
                                            <a id="credit_id_client" style="display: none;"></a>

                                            <div class="mt-3">

                                                <div class="row">

                                                    <div class="col-12">

                                                        <label for="MontantVersementInput">Montant Versé :</label>
                                                        <input type="text" id="MontantVersementInput"
                                                            class="form-control" placeholder="0.00"
                                                            style="text-align: center; font-size:40px;" readonly>

                                                    </div>

                                                </div>
                                                <div class="row mt-3 boutons-saisie">
                                                    <div class="col-4 h-100">
                                                        <button
                                                            class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                            onclick="VersementAppendValue('1')">1</button>
                                                        <button
                                                            class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                            onclick="VersementAppendValue('4')">4</button>
                                                        <button
                                                            class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                            onclick="VersementAppendValue('7')">7</button>
                                                        <button
                                                            class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                            onclick="VersementAppendValue('0')">0</button>
                                                    </div>
                                                    <div class="col-4 h-100">
                                                        <button
                                                            class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                            onclick="VersementAppendValue('2')">2</button>
                                                        <button
                                                            class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                            onclick="VersementAppendValue('5')">5</button>
                                                        <button
                                                            class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                            onclick="VersementAppendValue('8')">8</button>
                                                        <button
                                                            class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                            onclick="VersementAppendValue('00')">00</button>
                                                    </div>
                                                    <div class="col-4 h-100">
                                                        <button
                                                            class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                            onclick="VersementAppendValue('3')">3</button>
                                                        <button
                                                            class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                            onclick="VersementAppendValue('6')">6</button>
                                                        <button
                                                            class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                            onclick="VersementAppendValue('9')">9</button>
                                                        <button
                                                            class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                            onclick="VersementAppendValue('000')">000</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="modal-footer m-0 p-2">
                                            <div class="container pl-0">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <button type="button" class="btn btn-success medium-font"
                                                            onclick="ValiderVersementCredit()" style="width: 150px;">
                                                            <i class="fas fa-check fa-lg"></i><br>Valider
                                                        </button>

                                                    </div>
                                                    <div class="col-4">
                                                        <button type="button" class="btn btn-danger medium-font"
                                                            onclick="ClearVersementInput()" style="width: 150px;">
                                                            <i class="fas fa-eraser fa-lg"></i><br>Effacer
                                                        </button>

                                                    </div>
                                                    <!-- <div class="col-4">
                                                        <button type="button" class="btn btn-secondary" style="width: 150px;" onclick="fermerDeuxiemePopup()">
                                                            <i class="bi bi-x"></i><br>Fermer
                                                        </button>
                                                        <script>
                                                            function fermerDeuxiemePopup() {
                                                                // Ferme le modal en utilisant jQuery
                                                                $('#CreditModal').modal('hide');
                                                            }
                                                        </script>
                                                    </div> -->
                                                    <div class="col-4">
                                                        <button type="button" class="btn btn-secondary medium-font"
                                                            data-bs-dismiss="modal" style="width: 150px;">
                                                            <i class="fas fa-times fa-lg"></i><br>Fermer
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

                        <div class="col-3">
                            <div class="dropdown">
                                <button class="btn btn-danger dropdown-toggle bouton-caisse" type="button"
                                    id="type_vente" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-store fa-lg"></i>
                                    <br><span id="selected_option">Vente-Détails</span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="type_vente">
                                    <li>
                                        <a class="dropdown-item btn btn-primary" href="#" data-value="details"
                                            id="vente_details">
                                            <br> <i class="fas fa-user-tag fa-lg"></i> <br>
                                            Vente-Détails
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item btn btn-primary" href="#" data-value="semi_gros"
                                            id="vente_semi">
                                            <br> <i class="fas fa-boxes fa-lg"></i> <br>
                                            Vente-Semi-Gros
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item btn btn-primary" href="#" data-value="gros"
                                            id="vente_gros">
                                            <br> <i class="fas fa-truck-moving fa-lg"></i> <br>
                                            Vente-Gros
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>



                        <script>
                            document.querySelectorAll('.dropdown-item').forEach(item => {
                                item.addEventListener('click', function (e) {
                                    e.preventDefault(); // Empêche le comportement par défaut du lien
                                    const selectedValue = this.getAttribute('data-value'); // Récupère la valeur sélectionnée
                                    const selectedText = this.textContent.trim(); // Récupère le texte sélectionné

                                    // Met à jour le texte et la valeur de l'option sélectionnée dans le bouton principal
                                    document.getElementById('selected_option').textContent = selectedText;
                                    document.getElementById('type_vente').setAttribute('data-selected-value', selectedValue);

                                    console.log(`Option sélectionnée : ${selectedValue} (${selectedText})`);

                                    // Si nécessaire, déclenche la fonction associée en fonction de la sélection
                                    switch (selectedValue) {
                                        case 'details':
                                            prix_details();
                                            break;
                                        case 'semi_gros':
                                            prix_semigros();
                                            break;
                                        case 'gros':
                                            prix_gros();
                                            break;
                                        default:
                                            console.error('Valeur inconnue : ', selectedValue);
                                    }
                                });
                            });
                        </script>

                        <style>
                            .dropdown {
                                height: 100%;
                                width: 100%;

                            }

                            .dropdown-toggle {
                                text-align: center;

                            }

                            #type_cente {
                                height: 100%;
                            }

                            .dropdown-menu {
                                font-size: 26px;
                                text-align: center;
                                justify-content: center;

                            }

                            .dropdown-item {
                                height: 90px;
                            }

                            #vente_details {
                                color: white;
                                background-color: rgb(12, 190, 74);
                                font-weight: bold;

                            }

                            #vente_semi {
                                color: white;
                                background-color: rgb(251, 183, 58);
                                font-weight: bold;
                            }

                            #vente_gros {
                                color: white;
                                background-color: rgb(214, 34, 34);
                                font-weight: bold;
                            }
                        </style>








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
                                            {{-- les factures s'affichent ici --}}
                                            {{-- <div class="mt-3" id="liste-factures">
                                            </div> --}}
                                            <div id="carouselExample1" class="carousel slide mt-3 mb-3 bg-dark"
                                                data-bs-interval="false" style="height:470px;">

                                                <div class="carousel-inner" id="CarouselFacturesEnAttente">
                                                    {{-- les factures s'affichent ici --}}
                                                </div>

                                                <!-- Indicateurs de progression -->
                                                <div class="carousel-indicators"
                                                    id="CarouselFacturesEnAttente_indicateurs">

                                                </div>

                                                <button class="carousel-control-prev bg-dark" type="button"
                                                    data-bs-target="#carouselExample1" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next bg-dark" type="button"
                                                    data-bs-target="#carouselExample1" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
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


                        <div class="col-3">
                            <button class="btn btn-primary bouton-caisse" type="button" onclick="FactureEnAttente()">
                                <i class="fa fa-pause-circle fa-lg"></i>
                                <br>Vente En Attente
                            </button>
                        </div>

                        {{-- -------------------------------------------- --}}
                        @if ($btn_enc == '1')
                            <div class="col-3">
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
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
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
                                                                    <option class="bg-dark text-white" value="{{ $client->id }}"
                                                                        @if ($client->id == 0) selected @endif
                                                                        style="margin-bottom:5px !important;">
                                                                        {{ $client->nom_prenom }}
                                                                    </option>
                                                                    <hr>
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
                                                            <input type="number" id="VersementInput" class="form-control"
                                                                placeholder="0.00"
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
                                                    <div class="row mt-3 boutons-saisie">
                                                        <div class="col-4 h-100">
                                                            <button
                                                                class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                                onclick="FactureAppendValue('1')">1</button>
                                                            <button
                                                                class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                                onclick="FactureAppendValue('4')">4</button>
                                                            <button
                                                                class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                                onclick="FactureAppendValue('7')">7</button>
                                                            <button
                                                                class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                                onclick="FactureAppendValue('0')">0</button>
                                                        </div>
                                                        <div class="col-4 h-100">
                                                            <button
                                                                class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                                onclick="FactureAppendValue('2')">2</button>
                                                            <button
                                                                class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                                onclick="FactureAppendValue('5')">5</button>
                                                            <button
                                                                class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                                onclick="FactureAppendValue('8')">8</button>
                                                            <button
                                                                class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                                onclick="FactureAppendValue('00')">00</button>
                                                        </div>
                                                        <div class="col-4 h-100">
                                                            <button
                                                                class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                                onclick="FactureAppendValue('3')">3</button>
                                                            <button
                                                                class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                                onclick="FactureAppendValue('6')">6</button>
                                                            <button
                                                                class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                                onclick="FactureAppendValue('9')">9</button>
                                                            <button
                                                                class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                                                onclick="FactureAppendValue('000')">000</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Pied du modal -->


                                            <div class="modal-footer m-0 p-2">
                                                <div class="container pl-0">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <button type="button" class="btn btn-success medium-font"
                                                                onclick="ValiderFacture()" style="width: 150px;">
                                                                <i class="fas fa-check fa-lg"></i><br>Valider
                                                            </button>

                                                        </div>
                                                        <div class="col-4">
                                                            <button type="button" class="btn btn-danger medium-font"
                                                                onclick="ClearTotalInput()" style="width: 150px;">
                                                                <i class="fas fa-eraser fa-lg"></i><br>Effacer
                                                            </button>

                                                        </div>
                                                        <div class="col-4">
                                                            <button type="button" class="btn btn-secondary medium-font"
                                                                data-bs-dismiss="modal" style="width: 150px;">
                                                                <i class="fas fa-times fa-lg"></i><br>Fermer
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
                        @endif
                        {{-- -------------------------------------------- --}}


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
                                    style="text-align: center; font-size:40px;" inputmode="decimal" aria-label=""
                                    value="" aria-describedby="inputGroup-sizing-lg" readonly>
                            </div>
                            {{-- <label for="versementInput">Prix Total :</label>
                            <input type="number" id="TotalInput" class="form-control" placeholder="0.00"
                                style="text-align: center; font-size:40px;" inputmode="decimal" readonly> --}}
                        </div>
                    </div>
                    <div class="row mt-3 boutons-saisie">
                        <div class="col-4 h-100">
                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                onclick="PrixAppendValue('1')">1</button>
                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                onclick="PrixAppendValue('4')">4</button>
                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                onclick="PrixAppendValue('7')">7</button>
                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                onclick="PrixAppendValue('0')">0</button>
                        </div>
                        <div class="col-4 h-100">
                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                onclick="PrixAppendValue('2')">2</button>
                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                onclick="PrixAppendValue('5')">5</button>
                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                onclick="PrixAppendValue('8')">8</button>
                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                onclick="PrixAppendValue('00')">00</button>
                        </div>
                        <div class="col-4 h-100">
                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                onclick="PrixAppendValue('3')">3</button>
                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                onclick="PrixAppendValue('6')">6</button>
                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                onclick="PrixAppendValue('9')">9</button>
                            <button class="btn btn-dark mb-2 pt-3 pb-3 font-weight-bold big-font"
                                onclick="PrixAppendValue('000')">000</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal-footer m-0 p-2">
                <div class="container pl-0">
                    <div class="row justify-content-center">

                        <div class="col-4">
                            <form class="" data-id=""></form>
                            <button type="button" class="btn btn-success medium-font" onclick="ValiderPrixProduit()"
                                style="width: 150px;">
                                <i class="fas fa-check fa-lg"></i><br>Valider
                            </button>

                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-danger medium-font" onclick="ClearPrixInput()"
                                style="width: 150px;">
                                <i class="fas fa-eraser fa-lg"></i><br>Effacer
                            </button>

                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-secondary medium-font" data-bs-dismiss="modal"
                                style="width: 150px;">
                                <i class="fas fa-times fa-lg"></i><br>Fermer
                            </button>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Popup -->


{{--
-------------------------------------------------------------------------------------------------------------------------------
--}}
{{--
-------------------------------------------------------------------------------------------------------------------------------
--}}
{{-- SOUS PRODUITS --}}
{{--
-------------------------------------------------------------------------------------------------------------------------------
--}}

{{-- Bouton pour afficher le popup --}}
<button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#SousProduitsModal"
    id="bouton_liste_sousproduits" style="display: none;">
    <br>liste des sous produits
</button>

<!-- Popup changement de prix -->
<div class="modal fade" id="SousProduitsModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-body">
                <div class="mt-3">

                    <div class="row justify-content-center">

                        <div class="col-12">
                            <div class="row p-0 m-0" id="SousProduits" style="height: 220px;">
                                {{-- <h1>liste de sous produits ici</h1> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Popup -->


{{--
-------------------------------------------------------------------------------------------------------------------------------
--}}
{{-- SOUS PRODUITS --}}
{{--
-------------------------------------------------------------------------------------------------------------------------------
--}}
{{--
-------------------------------------------------------------------------------------------------------------------------------
--}}


{{-- ------------------------------------------------------------------------------------------------------- --}}
{{-- javascript --}}
{{-- ------------------------------------------------------------------------------------------------------- --}}
<!-- Slick JS -->

<script>
    $(document).ready(function () {
        $('.your-carousel').slick({
            slidesToShow: 4, // Affiche 4 diapositives à la fois sur les grands écrans
            slidesToScroll: 1, // Défile 1 diapositive à la fois
            arrows: false, // Ajoute des flèches de navigation
            dots: true, // Ajoute des points de pagination
            infinite: false, // Permet une navigation infinie
            speed: 300, // Durée de la transition
            responsive: [{
                breakpoint: 1024, // Pour les tablettes et les petits ordinateurs
                settings: {
                    slidesToShow: 3, // Affiche 3 diapositives à la fois
                    slidesToScroll: 1, // Défile 1 diapositive à la fois
                    dots: true, // Points de pagination
                }
            },
            {
                breakpoint: 768, // Pour les tablettes et les petits appareils
                settings: {
                    slidesToShow: 2, // Affiche 2 diapositives à la fois
                    slidesToScroll: 1, // Défile 1 diapositive à la fois
                    dots: true, // Points de pagination
                }
            },
            {
                breakpoint: 480, // Pour les mobiles
                settings: {
                    slidesToShow: 1, // Affiche 1 diapositive à la fois
                    slidesToScroll: 1, // Défile 1 diapositive à la fois
                    dots: true, // Points de pagination
                }
            }
            ]
        });



        // Gestion des boutons personnalisés
        $('#prev-btn').on('click', function () {
            $('.your-carousel').slick('slickPrev'); // Navigue vers la gauche
        });

        $('#next-btn').on('click', function () {
            $('.your-carousel').slick('slickNext'); // Navigue vers la droite
        });
    });
</script>


<!-- <style>
    .slick-prev,
    .slick-next {
        display: block !important;
        /* Force l'affichage */
        z-index: 1000;
        /* Assure qu'elles ne sont pas couvertes */
        background: rgba(0, 0, 0, 0.5);
        /* Optionnel : ajoute un fond pour les rendre visibles */
        color: white !important;
        /* Couleur des flèches */
        font-size: 30px;
    }

    .slick-prev:before,
    .slick-next:before {
        color: white !important;
        /* Couleur du contenu des flèches */
    }
</style> -->




{{-- script pour les poppup --}}
<script>
    $('body').css('overflow', 'auto');
</script>


{{-- ---------------------------------------------------------------------------------------------- --}}

{{-- script pour la balance --}}

{{--
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
    let reader;

    // Fonction pour se connecter ou se déconnecter de la balance
    async function toggleConnection() {
        if (toggleBalance.checked) {
            await connectToSerialPort(); // Connecter à la balance si la case est cochée
        } else {
            if (port) {
                if (reader) {
                    try {
                        await reader.releaseLock();
                    } catch (error) {
                        console.error('Erreur lors de la libération du lecteur :', error);
                    }
                    reader = null;
                }
                await port.close();
                port = null;
            }
            balanceElement.textContent = '0.000';
            prixTotalElement.textContent = '0.00';
        }
    }

    // Fonction pour se connecter au port COM1 et lire les données en temps réel
    async function connectToSerialPort() {
        try {
            const ports = await navigator.serial.getPorts();
            port = ports.find(p => p.getInfo().usbVendorId || 'COM1'); // Fixer sur COM1 directement
            if (!port) {
                console.error('Le port COM1 est introuvable ou inaccessible.');
                return;
            }

            await port.open({
                baudRate: 9600
            });

            reader = port.readable.getReader();

            while (true) {
                const { value, done } = await reader.read();
                if (done) {
                    if (reader) {
                        await reader.releaseLock();
                    }
                    break;
                }

                const textDecoder = new TextDecoder();
                const data = textDecoder.decode(value);
                const match = data.match(/-?\d+(\.\d+)?/);
                if (match) {
                    const weight = parseFloat(match[0]);
                    balanceElement.textContent = weight.toFixed(3);
                    calculer_total_vente(weight);
                }
            }
        } catch (error) {
            console.error('Erreur de connexion au port série :', error);
        }
    }

    // Fonction pour calculer le prix total
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
        toggleConnection();
    }

    // Appeler la fonction d'initialisation
    init();
</script>





{{-- ---------------------------------------------------------------------------------------------------- --}}


<script>
    function FiltrageProduits(form) {
        try {
            const id = form.getAttribute('data-id');
            const nom = form.getAttribute('data-nom');

            console.log('le titre de la catégorie est : ' + nom);


            const text_id_categorie = document.getElementById('text-id-categorie');
            if (text_id_categorie) {
                text_id_categorie.textContent = id;
            }

            const vente_type = document.getElementById('text-type-vente')?.textContent || '';

            if (!id) {
                console.error('ERREUR ID : ID manquant');
                return;
            }

            // Récupération des autres informations nécessaires
            const id_user = document.getElementById('text-id-user')?.textContent || '';
            const id_magasin = document.getElementById('text-id-magasin')?.textContent || '';

            if (!id_user || !id_magasin) {
                console.error('ERREUR : Informations utilisateur ou magasin manquantes');
                return;
            }

            $.ajax({
                url: `/caisse/category/${id}/user/${id_user}/magasin/${id_magasin}`,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log('PRODUCTS FILTER SUCCESS');
                    const productsContainer = $('#products');
                    productsContainer.empty();

                    // Vérification des produits avant l'itération
                    if (!response.produits || response.produits.length === 0) {
                        console.warn('Aucun produit trouvé');
                        return;
                    }

                    // Ajout des produits retournés par l'API
                    response.produits.forEach(value => {
                        let prix = 0;
                        if (vente_type === 'details') prix = value.prix_detail;
                        else if (vente_type === 'semigros') prix = value.prix_semigros;
                        else if (vente_type === 'gros') prix = value.prix_gros;

                        productsContainer.append(`
                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6   mt-2 mb-2 pr-2 pl-2">
                                    <div class="card scat">
                                        <form class="affichage-form"
                                            data-id_lestock="${value.id}"
                                            data-id_produit="${value.id_produit}"
                                            data-id_sousproduit="0"
                                            data-nom="${value.nom}"
                                            data-prix-detail="${value.prix_detail}"
                                            data-prix-semigros="${value.prix_semigros}"
                                            data-prix-gros="${value.prix_gros}"
                                            onclick="Tester_SousProduits(this)"
                                            style="cursor: pointer;">
                                            <img src="{{ asset('storage/') }}/${value.photo}" class="card-img-top" alt="...">
                                            <div class="card-body p-1 m-0 text-center">
                                                <h6 class="card-title mini-text" style="line-height:1.5;">${value.nom}</h6>
                                                <h5 class="card-text mini-text fw-bold" style="line-height:1;">${Math.round(parseFloat(prix))} DA</h5>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            `);
                    });

                    // Ajout d'un espace supplémentaire
                    productsContainer.append('<div class="col-12 zyada" style="height: 100px;"></div>');

                    // Gestion des classes pour les cartes
                    document.querySelectorAll('.card.scat').forEach(card => {
                        card.classList.remove('bg-danger');
                        card.classList.add('bg-white');
                    });

                    // Ajout de la classe "bg-danger" à la carte sélectionnée
                    const card = form.closest('.card');
                    if (card) {
                        card.classList.add('bg-danger');
                        card.classList.remove('bg-white');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Erreur AJAX :', error);
                }
            });

            if (nom) {
                const afficheur_cat = document.getElementById('categorie_text');
                const afficheur_produit = document.getElementById('produit_text');
                const afficheur_prix = document.getElementById('prix_unitaire');
                const afficheur_prix_total = document.getElementById('prix_total');
                // const titre_categorie = document.getElementById('titre-categorie');

                // titre_categorie.textContent = nom;
                afficheur_cat.textContent = nom;
                afficheur_produit.textContent = '----';
                afficheur_prix.textContent = '0.00';
                afficheur_prix_total.textContent = '0.00';
            } else {
                console.error('ERREUR NOM : Nom manquant');
            }

            console.log('Filtrage Produits exécuté');
        } catch (error) {
            console.error('Erreur dans la fonction FiltrageProduits :', error);
        }

        // Pour la catégorie
        const card = form.querySelector('.card.cat'); // Récupère la carte associée au formulaire
        if (card) {
            // Réinitialise le cadre, l'ombrage et la couleur de texte de toutes les cartes
            document.querySelectorAll('.card.cat').forEach(otherCard => {
                otherCard.classList.remove('bg-danger', 'text-white');
                otherCard.classList.add('bg-white', 'text-gray');
            });

            // Applique les styles à la carte sélectionnée
            card.classList.add('bg-danger', 'text-white');
            card.classList.remove('bg-white', 'text-gray');
        }



    }
</script>





<script>
    function Tester_SousProduits(form) {
        try {
            const id_produit = form.getAttribute('data-id_produit');
            const nom = form.getAttribute('data-nom');

            if (!id_produit) {
                console.error('ERREUR : ID produit manquant');
                return;
            }

            const id_user = document.getElementById('text-id-user')?.textContent || '';
            const id_magasin = document.getElementById('text-id-magasin')?.textContent || '';
            const bouton_sousproduits = document.getElementById('bouton_liste_sousproduits');
            const vente_type = document.getElementById('text-type-vente')?.textContent || '';

            if (!id_user || !id_magasin) {
                console.error('ERREUR : Informations utilisateur ou magasin manquantes');
                return;
            }

            $.ajax({
                url: `/Get_SubProducts/${id_produit}/user/${id_user}/magasin/${id_magasin}`,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log('LISTE DES SOUS-PRODUITS RETOURNÉE');
                    const sousProduitsContainer = $('#SousProduits');
                    sousProduitsContainer.empty();

                    if (response.sousproduits && response.sousproduits.length > 0) {
                        // Produit principal
                        const produit = response.produit;
                        appendProductCard(sousProduitsContainer, produit, vente_type, 0);

                        // Sous-produits
                        response.sousproduits.forEach(subProduit => {
                            appendProductCard(sousProduitsContainer, subProduit, vente_type,
                                subProduit.id);
                        });

                        // Activer le bouton pour afficher la liste des sous-produits
                        bouton_sousproduits?.click();
                    } else {
                        sousProduitsContainer.append(`
                                <div class="alert alert-warning text-center" role="alert">
                                    Aucun sous-produit disponible.
                                </div>
                            `);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Erreur AJAX :', error);
                    affichage(form); // Si erreur, effectuer une action alternative
                }
            });

            console.log('Test des sous-produits exécuté');
        } catch (error) {
            console.error('Erreur dans la fonction Tester_SousProduits :', error);
        }
    }

    /**
     * Ajoute une carte produit ou sous-produit dans le conteneur.
     * @param {jQuery} container - Conteneur où ajouter la carte.
     * @param {Object} produit - Données du produit.
     * @param {string} vente_type - Type de vente.
     * @param {number} sousProduitId - ID du sous-produit (ou 0 pour produit principal).
     */
    function appendProductCard(container, produit, vente_type, sousProduitId) {
        let prix = 0;
        if (vente_type === 'details') prix = produit.prix_detail;
        else if (vente_type === 'semigros') prix = produit.prix_semigros;
        else if (vente_type === 'gros') prix = produit.prix_gros;

        container.append(`
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mb-4">
                    <div class="card scat" style="height: 200px;">
                        <form class="affichage-form"
                            data-id_lestock="${produit.id}"
                            data-id_lestock="${produit.id}"
                            data-id_produit="${produit.id_produit}"
                            data-id_sousproduit="${sousProduitId}"
                            data-nom="${produit.nom}"
                            data-prix-detail="${produit.prix_detail}"
                            data-prix-semigros="${produit.prix_semigros}"
                            data-prix-gros="${produit.prix_gros}"
                            onclick="affichage(this)"
                            style="cursor: pointer;">
                            <img src="{{ asset('storage/') }}/${produit.photo}" class="card-img-top" alt="Image produit" style="height: 120px;">
                            <div class="card-body p-1 m-0 text-center">
                                <h6 class="card-title mini-text">${produit.nom}</h6>
                                <h5 class="card-text mini-text">${Math.round(parseFloat(prix))} DA / ${produit.mesure}</h5>
                            </div>
                        </form>
                    </div>
                </div>
            `);
    }
</script>


<script>
    function affichage(form) {
        try {
            // Récupération des attributs du formulaire
            const id_lestock = form.getAttribute('data-id_lestock');
            const id_produit = form.getAttribute('data-id_produit');
            const id_sousproduit = form.getAttribute('data-id_sousproduit') || '0';
            const nom = form.getAttribute('data-nom');
            const vente_type = document.getElementById('text-type-vente')?.textContent || '';

            if (!id_lestock || !id_produit) {
                console.error('ERREUR : ID produit ou stock manquant');
                return;
            }

            console.log(`id_lestock=${id_lestock}`);
            console.log(`id_produit=${id_produit}`);
            console.log(`id_sousproduit=${id_sousproduit}`);
            console.log(`nom=${nom}`);
            console.log(`vente_type=${vente_type}`);

            // Détermination du prix en fonction du type de vente
            let prix = parseFloat(
                vente_type === 'details' ? form.getAttribute('data-prix-detail') :
                    vente_type === 'semigros' ? form.getAttribute('data-prix-semigros') :
                        vente_type === 'gros' ? form.getAttribute('data-prix-gros') :
                            0
            );

            if (isNaN(prix)) {
                console.error('ERREUR : Prix invalide');
                return;
            }

            // Mise à jour des informations du produit sélectionné
            const nom_produit = document.getElementById('produit_text');
            const prix_produit = document.getElementById('prix_unitaire');
            const prix_total = document.getElementById('prix_total');
            const balance = parseFloat(document.getElementById('balance')?.textContent || 0);

            if (nom_produit) nom_produit.textContent = nom || 'Nom indisponible';
            if (prix_produit) prix_produit.textContent = prix.toFixed(2);

            // Calcul et affichage du total
            const total = (prix * balance).toFixed(0);
            if (prix_total) prix_total.textContent = total;

            // Mise à jour des ID dans les champs cachés
            const text_id_sousproduit = document.getElementById('text-id-sousproduit');
            const text_id_lestock = document.getElementById('text-id-lestock');
            const text_id_produit = document.getElementById('text-id-produit');

            if (text_id_sousproduit) text_id_sousproduit.textContent = id_sousproduit;
            if (text_id_lestock) text_id_lestock.textContent = id_lestock;
            if (text_id_produit) text_id_produit.textContent = id_produit;

            // Fermeture du modal des sous-produits
            $('#SousProduitsModal').modal('hide');

            // Mise en surbrillance de la carte sélectionnée
            const card = form.closest('.card');
            if (card) {
                document.querySelectorAll('.card.scat').forEach(otherCard => {
                    otherCard.classList.remove('bg-danger', 'text-white');
                    otherCard.classList.add('bg-white', 'text-gray');
                });

                card.classList.add('bg-danger', 'text-white');
                card.classList.remove('bg-white');
            }

            console.log('Calcul Total Produit*Quantité exécuté');
        } catch (error) {
            console.error('Erreur dans la fonction affichage :', error);
        }
    }
</script>


{{-- script poppup quantite --}}
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

        const IdSousProduit = document.getElementById('text-id-sousproduit').textContent || '0';

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
            const nom_produit = AffichageNomProduit.textContent;

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

                        if (id_facture && id_user && id_lestock && id_produit && qte > 0 && PrixUnitaire > 0 && PrixTotal > 0 &&
                            nom_produit && IdSousProduit) {
                            console.log('ROUTE = /vente/' + id_facture + '/' + id_user + '/' + id_lestock + '/' + id_produit + '/' +
                                IdSousProduit + '/' + nom_produit +
                                '/valeurs/' + PrixUnitaire + '/' + qte + '/' + PrixTotal,);
                            $.ajax({
                                url: '/vente/' + id_facture + '/' + id_user + '/' + id_lestock + '/' + id_produit + '/' +
                                    IdSousProduit + '/' + nom_produit +
                                    '/valeurs/' + PrixUnitaire + '/' + qte + '/' + PrixTotal,
                                type: 'post',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content') // Assurez-vous que cette balise meta est incluse dans votre HTML
                                },
                                success: function () {
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
                                error: function (xhr, status, error) {
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
        console.log('ROUTE = /ventes/' + id_facture)
        $.ajax({
            url: '/ventes/' + id_facture,
            type: 'get',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content')
            },
            success: function (response) {
                $('#ventes_liste').empty();
                $.each(response.ventes, function (key, value) {
                    // let quantite = Number.isInteger(value.quantite) ? parseInt(value.quantite) : value.quantite;
                    let quantite = Number.isInteger(value.quantite) ? value.quantite : parseFloat(
                        value.quantite);

                    console.log('id=' + value.id + '/ nom=' + value.designation_produit +
                        '/ quantite=' + quantite + value.unite_mesure + '/ prix=' + value
                            .prix_unitaire + '/ total=' + value.total_vente);

                    $('#ventes_liste').append(
                        '<tr class="bg-warning ligne">' +
                        // '<td class="petit_font">' + value.nom_categorie + ' : ' + value.nom_produit +
                        '<td class="petit_font text-left mini-text">' + value
                            .designation_produit +
                        '</td>' +
                        '<td class="petit_font text-right mini-text">' + quantite + ' ' + value
                            .unite_mesure +
                        '</td>' +
                        '<td class="petit_font text-right mini-text">' + value.prix_unitaire +
                        '</td>' +
                        '<td class="petit_font text-right mini-text">' + value.total_vente +
                        '</td>' +
                        '<td class="">' +
                        '<form class="form-prix-produit" data-id="' + value.id +
                        '"><button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#PrixModal" id="bouton_prix" onclick="ModifierPrixProduit(this)">' +
                        '<i class="fas fa-coins"></i></button></form>' +
                        '</td>' +
                        '<td class="">' +
                        '<form class="form-supprimer-produit" data-id="' + value.id +
                        '"><button class="btn btn-danger" type="button" onclick="SupprimerProduit(this)"><i class="fas fa-trash-alt"></i></button></form>' +
                        '</td>' +
                        '</tr>' +
                        '<hr>'
                    );
                });
                console.log('Réccuperation Liste des Ventes executé');
            },
            error: function (xhr, status, error) {
                console.log('Réccuperation Liste des Ventes echoué');
                console.error(error);
            }
        });

    }


    function Calculer_Total_Facture(id_facture) {
        $.ajax({
            url: '/total-facture/' + id_facture,
            type: 'get',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content') // Assurez-vous que cette balise meta est incluse dans votre HTML
            },
            success: function (response) {
                let AffichageTotal = document.getElementById('text_total_facture');
                AffichageTotal.textContent = response.total;
                if (response.total == 0) AffichageTotal.textContent = '0.00';
                console.log('Calcul Total Facture executé');
                console.log('Total Facture = ' + response.total);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });

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
                        success: function (response) {
                            Swal.fire({
                                title: "Supprimée",
                                icon: "error",
                                showConfirmButton: false,
                                timer: 1500
                            });

                            ListeVentes(id_facture);

                            Calculer_Total_Facture(id_facture);
                        },
                        error: function (xhr, status, error) {
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
                success: function (response) {
                    if (response.vente && response.vente.total_vente) {
                        total_input.placeholder = response.vente.total_vente;
                        total_input.value = '';
                        console.log('Id Vente : ' + IdVente);
                        console.log('Total Vente : ' + response.vente.total_vente);
                    } else {
                        console.error('Vente ou total_vente introuvable');
                    }
                },
                error: function (xhr, status, error) {
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
                success: function (response) {
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
                error: function (xhr, status, error) {
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


{{-- ---------------------------------------------------------------------------------------------- --}}

{{-- facture --}}
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
                success: function (response) {

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
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
        console.log('Nouvelle Facture executé');
    }


    function zero() {


        // enlever les classes bg-danger et mètre les classes bg-white
        // document.querySelectorAll('.cat,.scat').forEach(card => {
        //     card.classList.remove('bg-danger', 'text-white'); // Supprime la classe 'bg-danger'
        //     card.classList.add('bg-white', 'text-gray'); // Ajoute la classe 'bg-white'
        //     console.log('changement des classes');

        // });

        // enlever les classes bg-danger et mètre les classes bg-white
        document.querySelectorAll('.scat').forEach(card => {
            card.classList.remove('bg-danger', 'text-white'); // Supprime la classe 'bg-danger'
            card.classList.add('bg-white', 'text-gray'); // Ajoute la classe 'bg-white'
            console.log('changement des classes');

        });

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
        // AffichageNomCategorie.textContent = "----";
        // AffichageNomProduit.textContent = "----";
        // AffichageTitreCategorie.textContent = "";
        // $('#products').empty();

        // const TextIdCategorie = document.getElementById('text-id-categorie');
        // TextIdCategorie.textContent = '0';




        prix_details()

        document.getElementById('selected_option').textContent = 'Vente-Détails';


        console.log('Remise à zero executé');
    }


    // async function Ouvrir_Encaissement() {

    //     const AffichageTotalCaisse = document.getElementById('text_total_facture');
    //     const AffichageTotalPoppup = document.getElementById('TotalInput');
    //     const AffichageVersPoppup = document.getElementById('VersementInput');
    //     const AffichageCreditPoppup = document.getElementById('CreditInput');

    //     if (AffichageTotalCaisse.textContent === '0.00') {


    //         await Swal.fire({
    //             title: "Facture Vide",
    //             icon: "warning",
    //             showConfirmButton: false,
    //             timer: 1500
    //         });

    //         // Ferme le popup encaissement
    //         await $('#FactureModal').modal('hide');

    //     } else {
    //         const TotalCaisse = AffichageTotalCaisse.textContent;
    //         AffichageTotalPoppup.value = TotalCaisse;
    //         AffichageVersPoppup.placeholder = TotalCaisse;
    //         AffichageVersPoppup.value = '';
    //         AffichageCreditPoppup.value = '0.00';
    //         console.log('total : ' + TotalCaisse);
    //     }

    //     console.log('Ouverture encaissement executé');
    // }

    async function Ouvrir_Encaissement() {
        const AffichageTotalCaisse = document.getElementById('text_total_facture');
        const AffichageTotalPoppup = document.getElementById('TotalInput');
        const AffichageVersPoppup = document.getElementById('VersementInput');
        const AffichageCreditPoppup = document.getElementById('CreditInput');
        const clientSelect = document.getElementById('client_select');

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

        // Réinitialiser la liste des clients et sélectionner l'option par défaut
        if (clientSelect) {
            clientSelect.value = "0"; // Sélectionne l'option avec id="0"
            console.log("Liste des clients réinitialisée avec id=0 sélectionné par défaut");
        }

        console.log('Ouverture encaissement exécuté');
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

    function VersementAppendValue(value) {
        const input = document.getElementById('MontantVersementInput');
        input.value += value;
        CalculerCredit()
    }

    function ClearVersementInput() {
        const input = document.getElementById('MontantVersementInput');
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

        const TypeVente = document.getElementById('text-type-vente').textContent;

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
                    '/' + TypeVente +
                    '/valeurs/' + Total + '/' + Versement + '/' + Credit + '/' + Etat,
                type: 'put',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
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

            iframeClient.onload = function () {
                iframeClient.contentWindow.print();

                // After printing the client copy, print the archive copy
                setTimeout(function () {
                    let iframeArchive = document.createElement('iframe');
                    iframeArchive.style.display = 'none';
                    iframeArchive.src = '/imprimer-ticket-credit/' +
                        IdFacture; // Make sure to create a route for archive copy
                    document.body.appendChild(iframeArchive);

                    iframeArchive.onload = function () {
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

            iframe.onload = function () {
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


    document.getElementById('TotalInput').addEventListener('focus', function () {
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
                    title: "VENTE N° " + response.numero,
                    text: "A été mise en attente",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        title: 'swal-title-large',
                        text: 'swal-text-large'
                    }
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

<style>
    .swal-title-large {
        font-size: 3rem;
        /* Ajustez la taille selon vos besoins */
        font-weight: bold;
    }

    .swal-text-large {
        font-size: 2rem;
        /* Ajustez la taille selon vos besoins */
        font-weight: bold;
    }
</style>

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
                success: function (response) {
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
                    $.each(response.factures, function (key, facture) {

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
                            success: function (response) {
                                $.each(response.ventes, function (key, vente) {
                                    let quantite = Number.isInteger(vente
                                        .quantite) ? vente.quantite :
                                        parseFloat(vente.quantite);
                                    $('#produits_facture_' + id_facture).append(
                                        '<tr>' +
                                        '<td class="">' + vente
                                            .designation_produit + '</td>' +
                                        '<td class="">' + quantite + ' ' +
                                        vente.unite_mesure + '</td>' +
                                        '<td class="">' + vente
                                            .prix_unitaire + '</td>' +
                                        '<td class="">' + vente
                                            .total_vente +
                                        '</td>' +
                                        '</tr>'
                                    );
                                });
                            },
                            error: function (xhr, status, error) {
                                console.error(error);
                            }
                        });

                        counter++; // Déplacer l'incrémentation ici
                    });
                },
                error: function (xhr, status, error) {
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
            success: function (response) {
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
            error: function (xhr, status, error) {
                console.error('Erreur AJAX:', error);
            }
        });
    }
</script>


<script>
    document.getElementById('kgModal').addEventListener('show.bs.modal', function () {
        clearInput();
    });
</script>

{{-- ------------------------------------------------------------------------------------------------------ --}}

<script>
    function liste_clients() {
        $.ajax({
            url: '/liste-clients',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content') // Assurez-vous que ce meta tag existe dans votre page HTML
            },
            success: function (response) {
                // Vérification si la réponse contient bien les données attendues
                if (response && response.clients && Array.isArray(response.clients)) {
                    $('#liste-clients').empty(); // Nettoie le tableau avant d'insérer les nouvelles données
                    console.log('Liste des clients récupérée avec succès.');

                    // Parcourir les clients
                    $.each(response.clients, function (key, client) {
                        // Déterminer la classe CSS pour le crédit
                        let creditClass = client.total_credit > 0 ? 'bg-danger text-white' :
                            'bg-success text-white';

                        // Ajouter une nouvelle ligne pour chaque client
                        let clientRow =
                            '<tr class="bg-white" style="border-bottom: 5px solid #252525; height:75px;">' +
                            '<td>' + (client.id || '') + '</td>' +
                            '<td>' + (client.nom || '') + '</td>' +
                            '<td>' + (client.adresse || '') + '</td>' +
                            '<td>' + (client.details || '') + '</td>' +
                            '<td>' + (client.tel_fix || '') + '</td>' +
                            // '<td>' + (client.tel_ooredoo || '') + '</td>' +
                            // '<td>' + (client.tel_mobilis || '') + '</td>' +
                            // '<td>' + (client.tel_djezzy || '') + '</td>' +
                            '<td class="' + creditClass + '">' + (client.total_credit || '0') +
                            '</td>';

                        // Vérifier si le crédit est supérieur à 0 pour afficher le bouton
                        if (client.total_credit > 0) {
                            clientRow += '<td>' +
                                '<form class="form-verser-credit" data-id="' + client.id +
                                '" data-nom="' + client.nom + '" data-credit="' + client
                                    .total_credit + '">' +
                                '<button type="button" class="btn btn-success" onclick="Aller_Vers_Versement_Credit(this)" style="padding-left:10px;padding-right:10px;">' +
                                '<i class="fas fa-cash-register fa-lg"></i><br>Versement' +
                                '</button>' +
                                '</form>' +
                                '</td>';
                        } else {
                            clientRow +=
                                '<td></td>'; // Si le crédit est <= 0, ne pas afficher le bouton
                        }

                        clientRow += '</tr>';

                        // Ajouter la ligne au tableau
                        $('#liste-clients').append(clientRow);
                    });

                } else {
                    console.error('Réponse inattendue du serveur:', response);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erreur lors de la récupération des clients:', error);
                console.error('Détails:', xhr.responseText);
            }
        });
    }
</script>


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
                success: function (response) {
                    $('#historique-factures').empty();
                    console.log(response.message);

                    $.each(response.factures, function (key, facture) {
                        const id_facture = facture.id;
                        console.log('id facture :' + id_facture);
                        // $('#historique-factures').append('<div style="width:100%;height:5px;"><hr></div>');
                        $('#historique-factures').append(
                            '<tr class="bg-primary text-white">' +
                            '<td>' + facture.id + '</td>' +
                            '<td>' + facture.code + '</td>' +
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
                            '</tr>'
                        );

                        // Appel AJAX pour récupérer les ventes associées à la facture
                        $.ajax({
                            url: '/ventes/' + id_facture,
                            type: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                $.each(response.ventes, function (key, vente) {
                                    let quantite = Number.isInteger(vente
                                        .quantite) ? vente.quantite :
                                        parseFloat(vente.quantite);
                                    $('#ventes_facture_' + id_facture).append(
                                        '<tr>' +
                                        '<td class="">' + vente
                                            .designation_produit + '</td>' +
                                        '<td class="">' + quantite + ' ' +
                                        vente.unite_mesure + '</td>' +
                                        '<td class="">' + vente
                                            .prix_unitaire + '</td>' +
                                        '<td class="">' + vente
                                            .total_vente +
                                        '</td>' +
                                        '</tr>' +

                                        '<tr style="height:20px;"></tr>'

                                    );
                                });
                            },

                            error: function (xhr, status, error) {
                                console.error('Error fetching ventes:', error);
                            }
                        });
                    });
                },
                error: function (xhr, status, error) {
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
            success: function (response) {
                // Récupérer l'objet 'facture' depuis la réponse JSON
                const facture = response.facture;

                // Assurez-vous que 'facture' n'est pas nul
                if (facture) {
                    let iframe = document.createElement('iframe');
                    iframe.style.display = 'none';
                    iframe.src = '/imprimer-ticket/' + IdFacture;
                    document.body.appendChild(iframe);

                    iframe.onload = function () {
                        iframe.contentWindow.print();
                    };
                } else {
                    console.error('Facture non trouvée');
                }
            },
            error: function (xhr, status, error) {
                console.error('Erreur AJAX:', error);
            }
        });
    }
</script>


<script>
    // background-color: #09a760;
    // background-color: #ffd500;
    // background-color: #ff2926;

    function prix_details() {
        const type_de_vente_variable = document.getElementById('text-type-vente');
        const afficheur_facture = document.querySelector('#facture_afficheur');
        const affect_type_vente = document.getElementById('type_vente_header');

        // Sélection des éléments
        const titre_cat_prod = document.getElementsByClassName('objet-titre');
        const titres_slider = document.getElementsByClassName('slider-text');
        const titre_afficheur_top = document.getElementsByClassName('afficheur-titre');
        const prix_unitaire_text = document.getElementById('prix_unitaire');
        const prix_total_text = document.getElementById('prix_total');
        const balance_text = document.getElementById('balance');

        // Fonction pour appliquer une couleur à une collection d'éléments
        function applyColorToCollection(collection, color) {
            for (let i = 0; i < collection.length; i++) {
                collection[i].style.color = color;
            }
        }

        // Appliquer la couleur rouge aux collections
        applyColorToCollection(titre_cat_prod, '#09a760');
        applyColorToCollection(titres_slider, '#09a760');
        applyColorToCollection(titre_afficheur_top, '#09a760');

        // Appliquer la couleur rouge aux éléments uniques
        if (prix_unitaire_text) prix_unitaire_text.style.color = '#09a760';
        if (prix_total_text) prix_total_text.style.color = '#09a760';
        if (balance_text) balance_text.style.color = '#09a760';



        if (afficheur_facture) {
            // Sélectionne tous les enfants de .facture_afficheur
            const children = afficheur_facture.querySelectorAll('*');
            children.forEach(child => {
                child.style.color = '#09a760';
            });
        }

        if (type_de_vente_variable) {
            type_de_vente_variable.textContent = 'details';
        }

        if (affect_type_vente) {
            affect_type_vente.textContent = 'Vente En Détails';
        }

        // $('#products').empty();

        // const id = document.getElementById('text-id-categorie').textContent;
        // const formName = 'filter-form';

        // // Sélection du formulaire avec la classe 'filter-form' et l'attribut data-id égal à id
        // const form = document.querySelector(`.${formName}[data-id="${id}"]`);

        // if (form && id) {
        //     FiltrageProduits(form);
        //     console.log('nouveaux prix affichés');
        // } else {
        //     console.error(`Aucun formulaire trouvé avec la classe '${formName}' et data-id='${id}'`);
        // }

        // calculer les ventes avec le nouveau type de vente 
        const IdFacture = document.getElementById('text-id-facture').textContent;
        const TypeVente = type_de_vente_variable.textContent;

        console.log(IdFacture + '/' + TypeVente);

        $.ajax({
            url: '/calculer-ventes/' + IdFacture + '/' + TypeVente,
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content')
            },
            success: function () {

                // Swal.fire({
                //     title: "Nouveaux Prix",
                //     icon: "success",
                //     showConfirmButton: false,
                //     timer: 1500
                // });

                ListeVentes(IdFacture);

                Calculer_Total_Facture(IdFacture);
            },
            error: function (xhr, status, error) {
                console.error('Erreur AJAX:', error);
            }
        });


    }

    function prix_semigros() {
        const type_de_vente_variable = document.getElementById('text-type-vente');
        const afficheur_facture = document.querySelector('#facture_afficheur');
        const affect_type_vente = document.getElementById('type_vente_header');

        // Sélection des éléments
        const titre_cat_prod = document.getElementsByClassName('objet-titre');
        const titres_slider = document.getElementsByClassName('slider-text');
        const titre_afficheur_top = document.getElementsByClassName('afficheur-titre');
        const prix_unitaire_text = document.getElementById('prix_unitaire');
        const prix_total_text = document.getElementById('prix_total');
        const balance_text = document.getElementById('balance');

        // Fonction pour appliquer une couleur à une collection d'éléments
        function applyColorToCollection(collection, color) {
            for (let i = 0; i < collection.length; i++) {
                collection[i].style.color = color;
            }
        }

        // Appliquer la couleur rouge aux collections
        applyColorToCollection(titre_cat_prod, '#ffd500');
        applyColorToCollection(titres_slider, '#ffd500');
        applyColorToCollection(titre_afficheur_top, '#ffd500');

        // Appliquer la couleur rouge aux éléments uniques
        if (prix_unitaire_text) prix_unitaire_text.style.color = '#ffd500';
        if (prix_total_text) prix_total_text.style.color = '#ffd500';
        if (balance_text) balance_text.style.color = '#ffd500';



        if (afficheur_facture) {
            // Sélectionne tous les enfants de .facture_afficheur
            const children = afficheur_facture.querySelectorAll('*');
            children.forEach(child => {
                child.style.color = '#ffd500';
            });
        }

        if (type_de_vente_variable) {
            type_de_vente_variable.textContent = 'semigros';
        }

        if (affect_type_vente) {
            affect_type_vente.textContent = 'Vente En Semi-Gros';
        }

        $('#products').empty();

        const id = document.getElementById('text-id-categorie').textContent;
        const formName = 'filter-form';

        // Sélection du formulaire avec la classe 'filter-form' et l'attribut data-id égal à id
        const form = document.querySelector(`.${formName}[data-id="${id}"]`);

        if (form) {
            FiltrageProduits(form);
            console.log('nouveaux prix affichés');
        } else {
            console.error(`Aucun formulaire trouvé avec la classe '${formName}' et data-id='${id}'`);
        }

        // calculer les ventes avec le nouveau type de vente 
        const IdFacture = document.getElementById('text-id-facture').textContent;
        const TypeVente = type_de_vente_variable.textContent;

        console.log(IdFacture + '/' + TypeVente);

        $.ajax({
            url: '/calculer-ventes/' + IdFacture + '/' + TypeVente,
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content')
            },
            success: function () {
                // Swal.fire({
                //     title: "Calculs éffectués",
                //     icon: "success",
                //     showConfirmButton: false,
                //     timer: 1500
                // });

                ListeVentes(IdFacture);

                Calculer_Total_Facture(IdFacture);
            },
            error: function (xhr, status, error) {
                console.error('Erreur AJAX:', error);
            }
        });
    }

    function prix_gros() {
        const type_de_vente_variable = document.getElementById('text-type-vente');
        const afficheur_facture = document.querySelector('#facture_afficheur');
        const affect_type_vente = document.getElementById('type_vente_header');

        // Sélection des éléments
        const titre_cat_prod = document.getElementsByClassName('objet-titre');
        const titres_slider = document.getElementsByClassName('slider-text');
        const titre_afficheur_top = document.getElementsByClassName('afficheur-titre');
        const prix_unitaire_text = document.getElementById('prix_unitaire');
        const prix_total_text = document.getElementById('prix_total');
        const balance_text = document.getElementById('balance');

        // Fonction pour appliquer une couleur à une collection d'éléments
        function applyColorToCollection(collection, color) {
            for (let i = 0; i < collection.length; i++) {
                collection[i].style.color = color;
            }
        }

        // Appliquer la couleur rouge aux collections
        applyColorToCollection(titre_cat_prod, '#ff2926');
        applyColorToCollection(titres_slider, '#ff2926');
        applyColorToCollection(titre_afficheur_top, '#ff2926');

        // Appliquer la couleur rouge aux éléments uniques
        if (prix_unitaire_text) prix_unitaire_text.style.color = '#ff2926';
        if (prix_total_text) prix_total_text.style.color = '#ff2926';
        if (balance_text) balance_text.style.color = '#ff2926';



        if (afficheur_facture) {
            // Sélectionne tous les enfants de .facture_afficheur
            const children = afficheur_facture.querySelectorAll('*');
            children.forEach(child => {
                child.style.color = '#ff2926';
            });
        }

        if (type_de_vente_variable) {
            type_de_vente_variable.textContent = 'gros';
        }

        if (affect_type_vente) {
            affect_type_vente.textContent = 'Vente En Gros';
        }

        $('#products').empty();

        const id = document.getElementById('text-id-categorie').textContent;
        const formName = 'filter-form';

        // Sélection du formulaire avec la classe 'filter-form' et l'attribut data-id égal à id
        const form = document.querySelector(`.${formName}[data-id="${id}"]`);

        if (form) {
            FiltrageProduits(form);
            console.log('nouveaux prix affichés');
        } else {
            console.error(`Aucun formulaire trouvé avec la classe '${formName}' et data-id='${id}'`);
        }

        // calculer les ventes avec le nouveau type de vente 
        const IdFacture = document.getElementById('text-id-facture').textContent;
        const TypeVente = type_de_vente_variable.textContent;

        console.log(IdFacture + '/' + TypeVente);

        $.ajax({
            url: '/calculer-ventes/' + IdFacture + '/' + TypeVente,
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content')
            },
            success: function () {
                // Swal.fire({
                //     title: "Calculs éffectués",
                //     icon: "success",
                //     showConfirmButton: false,
                //     timer: 1500
                // });

                ListeVentes(IdFacture);

                Calculer_Total_Facture(IdFacture);
            },
            error: function (xhr, status, error) {
                console.error('Erreur AJAX:', error);
            }
        });
    }
</script>


{{-- ------------------------------------------------------------------------------------------------------ --}}



{{-- calculatrice --}}


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
<div class="modal fade" id="calculatorModal" tabindex="-1" aria-labelledby="calculatorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="calculatorModalLabel">Calculatrice</h5>
                <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <div class="col"><button class="btn btn-secondary w-100" onclick="appendNumber('7')">7</button>
                        </div>
                        <div class="col"><button class="btn btn-secondary w-100" onclick="appendNumber('8')">8</button>
                        </div>
                        <div class="col"><button class="btn btn-secondary w-100" onclick="appendNumber('9')">9</button>
                        </div>
                        <div class="col"><button class="btn btn-primary w-100" onclick="appendNumber('/')">/</button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col"><button class="btn btn-secondary w-100" onclick="appendNumber('4')">4</button>
                        </div>
                        <div class="col"><button class="btn btn-secondary w-100" onclick="appendNumber('5')">5</button>
                        </div>
                        <div class="col"><button class="btn btn-secondary w-100" onclick="appendNumber('6')">6</button>
                        </div>
                        <div class="col"><button class="btn btn-primary w-100" onclick="appendNumber('*')">*</button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col"><button class="btn btn-secondary w-100" onclick="appendNumber('1')">1</button>
                        </div>
                        <div class="col"><button class="btn btn-secondary w-100" onclick="appendNumber('2')">2</button>
                        </div>
                        <div class="col"><button class="btn btn-secondary w-100" onclick="appendNumber('3')">3</button>
                        </div>
                        <div class="col"><button class="btn btn-primary w-100" onclick="appendNumber('-')">-</button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col"><button class="btn btn-success w-100" onclick="calculate()">=</button>
                        </div>
                        <div class="col"><button class="btn btn-secondary w-100" onclick="appendNumber('0')">0</button>
                        </div>
                        <div class="col"><button class="btn btn-secondary w-100" onclick="appendNumber('.')">.</button>
                        </div>
                        <div class="col"><button class="btn btn-primary w-100" onclick="appendNumber('+')">+</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




{{-- ---------------------------------------------------------------------------------------------------------------
--}}

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



{{-- ------------------------------------------------------------------------------------------------------ --}}
{{-- ------------------------------------------------------------------------------------------------------ --}}
{{-- credit client --}}
<script>
    function Aller_Vers_Versement_Credit(button) {
        // Récupérer l'ID et le nom du client à partir des attributs data-id et data-nom
        const form = button.closest('.form-verser-credit');
        const id = form.getAttribute('data-id');
        const nom = form.getAttribute('data-nom');
        const credit = form.getAttribute('data-credit');

        console.log(id);
        console.log(nom);
        console.log(credit);


        // Vérifier si les éléments avec les IDs 'credit_id_client' et 'credit_nom_client' existent
        const text_id_client = document.getElementById('credit_id_client');
        const text_nom_client = document.getElementById('credit_nom_client');
        const text_credit_client = document.getElementById('montant_credit_client');
        const input_montant = document.getElementById('MontantVersementInput');

        if (text_id_client && text_nom_client) {
            // Affecter l'ID du client et le nom du client au contenu des éléments respectifs
            text_id_client.textContent = id;
            text_nom_client.textContent = nom;
            text_credit_client.textContent = credit;
            input_montant.value = "";

            // Initialiser le modal Bootstrap et l'afficher
            // const CreditModal = new bootstrap.Modal(document.getElementById('CreditModal'));
            // CreditModal.show();

            $('#CreditModal').modal('show');


        } else {
            // Message d'erreur si les éléments sont introuvables
            console.error("L'élément avec l'ID 'credit_id_client' ou 'credit_nom_client' est introuvable.");
        }
    }
</script>

<script>
    async function ValiderVersementCredit() {

        const montant_verse = document.getElementById('MontantVersementInput').value;
        const id_client = document.getElementById('credit_id_client').textContent;
        const nom_client = document.getElementById('credit_nom_client').textContent;
        const montant_credit_client = document.getElementById('montant_credit_client').textContent;

        if (parseFloat(montant_verse) > 0 && parseFloat(montant_verse) <= parseFloat(montant_credit_client)) {
            try {

                await $.ajax({
                    url: '/valider-versement-credit/' + id_client + '/' + nom_client + '/' + montant_verse,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Swal.fire({
                            title: "Versement Validé",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            } catch (error) {
                console.error("Erreur lors de la validation de versement :", error);
            }


            let iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = '/imprimer-bon-versement/' + id_client;
            document.body.appendChild(iframe);

            iframe.onload = function () {
                iframe.contentWindow.print();
            };

            // Close the modal and create a new invoice
            await $('#CreditModal').modal('hide');
            await $('#ListeClientsModal').modal('hide');
        } else {
            Swal.fire({
                title: "Veuillez saisir un montant valide",
                icon: "warning",
                showConfirmButton: false,
                timer: 1500
            });
        }

    }
</script>


{{-- ------------------------------------------------------------------------------------------------------ --}}
{{-- ------------------------------------------------------------------------------------------------------ --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const carousel = document.querySelector('#carouselExample1');
        const carouselInstance = new bootstrap.Carousel(carousel, {
            wrap: false // Empêche le carrousel de se répéter
        });
    });
</script>



<script>
    $(document).ready(function () {
        const IdMagasin = document.getElementById('text-id-magasin').textContent.trim();
        $('#example1').DataTable({
            // processing: true, // Indique que le traitement est en cours
            serverSide: true, // Active le chargement des données côté serveur
            ajax: {
                url: '/historique-factures/' + IdMagasin,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
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
<script>
    $(document).ready(function () {
        $('#example2').DataTable({
            // processing: true, // Indique que le traitement est en cours
            serverSide: true, // Active le chargement des données côté serveur
            ajax: {
                url: '/liste-clients',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Assurez-vous que ce meta tag existe dans votre page HTML
                },
            },

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

<style>
    #ventes_liste .ligne td {
        padding: 5px !important;
        /* margin-bottom: 5px !important; */
        border-bottom: 5px solid #ffffff;
    }
</style>

{{-- ------------------------------------------------------------------------------------------------------ --}}
{{-- ------------------------------------------------------------------------------------------------------ --}}
{{-- affichage en 80% --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.body.style.zoom = "85%";
        document.body.style.margin = "0";
        document.body.style.width = "100%"; // Ajustez pour compenser le zoom
    });
</script>



{{-- ------------------------------------------------------------------------------------------------------ --}}
{{-- ------------------------------------------------------------------------------------------------------ --}}
@endsection
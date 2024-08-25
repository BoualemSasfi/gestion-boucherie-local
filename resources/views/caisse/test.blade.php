@extends('layouts.caisse')

@section('content')
    <!-- AFFICHEUR -->
    <div class="container-fluid m-0 p-0">
        <div class="container-fluid">
            <div class="row afficheur text-center pt-1 pb-1 pr-0 pl-0">
                <div class="col-2 align-content-center">
                    <h5 class="objet-titre digital" id="category_text" style="font-weight:bold;">----</h5>
                    <h5 class="objet-titre digital" id="produit_text">----</h5>
                </div>
                <div class="col-3">
                    <h6 class="afficheur-titre">QTE / Kg:</h6>
                    <div class="digital">
                        <p id="balance">0.00</p>
                    </div>
                </div>
                <div class="col-3 align-content-center">
                    <h6 class="afficheur-titre">PRIX UNITAIRE:</h6>
                    <p class="digital" id="prix_unitaire">0.00</p>
                </div>
                <div class="col-3 align-content-center">
                    <h6 class="afficheur-titre">PRIX TOTAL:</h6>
                    <p class="digital" id="prix_total">0.00</p>
                </div>
                <div class="col-1 mt-3 pl-0">
                    <button class="btn btn-primary pt-3 pb-3" style="color: white;">
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
                                <div class="card cat btn"
                                    style="width: 150px; height: 100px; background-image: url('{{ asset('storage/' . $category->photo) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
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
                </div>
            </div>

            <!-- Facture -->
            <div class="col-4 bg-dark">
                <div class="card shadow mb-4">
                    <div class="card-header py-1">
                        <div class="row afficheur text-center">
                            <div class="col-12 p-1 m-0 align-content-center">
                                <h6 class="afficheur-titre">TOTAL FACTURE :</h6>
                                <h2 class="digital">0.00</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body m-0 p-1" style="max-height: 550px; overflow-y: auto;">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Designation:</th>
                                    <th>Prix:</th>
                                    <th>QTE:</th>
                                    <th>Total:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Les lignes de produits -->
                            </tbody>
                        </table>
                        <div class="col-12 zyada" style="height: 500px;">CAISSE ESPACE</div>
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
                            <div class="col-3"><a class="btn btn-primary" href="">boutton 1</a></div>
                            <div class="col-3"><a class="btn btn-primary" href="">boutton 2</a></div>
                            <div class="col-3"><a class="btn btn-primary" href="">boutton 3</a></div>
                            <div class="col-3"><a class="btn btn-primary" href="">boutton 4</a></div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <div class="col-3"><a class="btn btn-warning" href="">boutton 1</a></div>
                            <div class="col-3"><a class="btn btn-warning" href="">boutton 2</a></div>
                            <div class="col-3"><a class="btn btn-warning" href="">boutton 3</a></div>
                            <div class="col-3"><a class="btn btn-warning" href="">boutton 4</a></div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <div class="col-3"><a class="btn btn-success" href="">boutton 1</a></div>
                            <div class="col-3"><a class="btn btn-success" href="">boutton 2</a></div>
                            <div class="col-3"><a class="btn btn-success" href="">boutton 3</a></div>
                            <div class="col-3"><a class="btn btn-danger" href="">boutton 4</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Slick JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.your-carousel').slick({
                slidesToShow: 6,
                slidesToScroll: 1,
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
                await port.open({ baudRate: 9600 });
                reader = port.readable.getReader();
                
                console.log('Connexion au port série établie');
                readData(); // Commencer à lire les données du port série
            } catch (error) {
                console.error('Erreur lors de la connexion au port série :', error);
            }
        }
    
        async function readData() {
            try {
                const { value, done } = await reader.read();
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
                                '<p class="card-text">' + value.prix_vent + '</p>' +
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
                const afficheur_prix = document.getElementById('prix_unitaire');
                afficheur_cat.textContent = nom;
                afficheur_produit.textContent = '----';
                afficheur_prix.textContent = '0.00';

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
                prix_produit.textContent = prix;
                AffichageEtCalcul(parseFloat(prix.replace(',', '.')));
            } else {
                console.error('ERREUR PRIX');
            }
        }
    </script>

    <style>
        .cat {
            margin: 3px;
        }

        .scat {
            height: 160px;
            width: 100%;
        }

        .card-img-top {
            height: 90px;
        }
    </style>
@endsection

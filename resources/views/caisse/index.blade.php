@extends('layouts.caisse')

@section('content')
    {{-- AFFICHEUR  --------------------------------------------------------- --}}
    <div class="container-fluid m-0 p-0">


        <div class="row afficheur text-center pt-1 pb-1 pr-0 pl-0">

            <div class="col-2 align-content-center">
                <h6 class="objet-titre">POULET</h6>
                <p class="objet-titre">Cuisses</p>
            </div>
            <div class="col-3">
                    <h6 class="afficheur-titre ">QTE / Kg:</h6>
                    <!-- <p class="digital" ><span id="output"></span> </p> -->
                    <div class="digital">
                        <p  id="balance"></p>
                        
                    </div>

                </div>
            <div class="col-3 align-content-center">
                <h6 class="afficheur-titre">PRIX UNITAIRE:</h6>
                <p class="digital">750.00</p>
            </div>
            <div class="col-3 align-content-center">
                <h6 class="afficheur-titre">PRIX TOTAL:</h6>
                <p class="digital">00.00</p>
            </div>
            <div class="col-1 mt-3 pl-0">
                <button class="btn btn-primary pt-3 pb-3" style="color: white;">
                    <i class="fas fa-check-circle fa-lg"></i>
                    <br>
                    Valider
                </button>
            </div>
        </div>

    </div>

    <div class="row"  >
        <div class="col-8">





            <div class="container mt-2">
                <div class="your-carousel">
                    <div class="card cat"
                        style="width: 150px; height: 100px; background-image: url('img/animal/poulet_vif.webp');background-size: cover; background-position: center; background-repeat: no-repeat;">
                    </div>
                    <div class="card cat"
                        style="width: 150px; height: 100px; background-image: url('img/animal/toro.jpg');background-size: cover; background-position: center; background-repeat: no-repeat;">
                    </div>
                    <div class="card cat"
                        style="width: 150px; height: 100px; background-image: url('img/animal/dindon.jfif');background-size: cover; background-position: center; background-repeat: no-repeat;">
                    </div>
                    <div class="card cat"
                        style="width: 150px; height: 100px; background-image: url('img/animal/mouton.webp');background-size: cover; background-position: center; background-repeat: no-repeat;">
                    </div>
                    <div class="card cat"
                        style="width: 150px; height: 100px; background-image: url('img/animal/lapin.jpg');background-size: cover; background-position: center; background-repeat: no-repeat;">
                    </div>
                    <div class="card cat"
                        style="width: 150px; height: 100px; background-image: url('img/animal/cheval.jpg');background-size: cover; background-position: center; background-repeat: no-repeat;">
                    </div>
                    <div class="card cat"
                        style="width: 150px; height: 100px; background-image: url('img/animal/poisson.jpg');background-size: cover; background-position: center; background-repeat: no-repeat;">
                    </div>

                </div>
            </div>

            <hr>

            <div class="container" style="height:75%; overflow-y: auto;">
                <div class="row">
                    <div class="col-2 p-2">
                        <div class="card scat">
                            <img src="img/animal/jaja_complet.jfif" class="card-img-top" alt="...">
                            <div class="card-body p-1 m-0 text-center">
                                <h5 class="card-title">Complet</h5>
                                <p class="card-text">350 DA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 p-2">
                        <div class="card scat">
                            <img src="img/animal/jaja_poitrine.webp" class="card-img-top" alt="...">
                            <div class="card-body p-1 m-0 text-center">
                                <h5 class="card-title">Poitrine</h5>
                                <p class="card-text">750 DA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 p-2">
                        <div class="card scat">
                            <img src="img/animal/jaja_cuisses.png" class="card-img-top" alt="...">
                            <div class="card-body p-1 m-0 text-center">
                                <h5 class="card-title">Cuisses</h5>
                                <p class="card-text">250 DA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 p-2">
                        <div class="card scat">
                            <img src="img/animal/jaja_ail.png" class="card-img-top" alt="...">
                            <div class="card-body p-1 m-0 text-center">
                                <h5 class="card-title">Ails</h5>
                                <p class="card-text">150 DA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 p-2">
                        <div class="card scat">
                            <img src="img/animal/jaja_foie.jfif" class="card-img-top" alt="...">
                            <div class="card-body p-1 m-0 text-center">
                                <h5 class="card-title">Foie</h5>
                                <p class="card-text">950 DA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 p-2">
                        <div class="card scat">
                            <img src="img/animal/jaja_farci.jfif" class="card-img-top" alt="...">
                            <div class="card-body p-1 m-0 text-center">
                                <h5 class="card-title">Farci</h5>
                                <p class="card-text">1500 DA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 p-2">
                        <div class="card scat">
                            <img src="img/animal/jaja_farci.jfif" class="card-img-top" alt="...">
                            <div class="card-body p-1 m-0 text-center">
                                <h5 class="card-title">Farci</h5>
                                <p class="card-text">1500 DA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 p-2">
                        <div class="card scat">
                            <img src="img/animal/jaja_complet.jfif" class="card-img-top" alt="...">
                            <div class="card-body p-1 m-0 text-center">
                                <h5 class="card-title">Complet</h5>
                                <p class="card-text">350 DA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 p-2">
                        <div class="card scat">
                            <img src="img/animal/jaja_poitrine.webp" class="card-img-top" alt="...">
                            <div class="card-body p-1 m-0 text-center">
                                <h5 class="card-title">Poitrine</h5>
                                <p class="card-text">750 DA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 p-2">
                        <div class="card scat">
                            <img src="img/animal/jaja_cuisses.png" class="card-img-top" alt="...">
                            <div class="card-body p-1 m-0 text-center">
                                <h5 class="card-title">Cuisses</h5>
                                <p class="card-text">250 DA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 p-2">
                        <div class="card scat">
                            <img src="img/animal/jaja_ail.png" class="card-img-top" alt="...">
                            <div class="card-body p-1 m-0 text-center">
                                <h5 class="card-title">Ails</h5>
                                <p class="card-text">150 DA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 p-2">
                        <div class="card scat">
                            <img src="img/animal/jaja_foie.jfif" class="card-img-top" alt="...">
                            <div class="card-body p-1 m-0 text-center">
                                <h5 class="card-title">Foie</h5>
                                <p class="card-text">950 DA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 p-2">
                        <div class="card scat">
                            <img src="img/animal/jaja_farci.jfif" class="card-img-top" alt="...">
                            <div class="card-body p-1 m-0 text-center">
                                <h5 class="card-title">Farci</h5>
                                <p class="card-text">1500 DA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 p-2">
                        <div class="card scat">
                            <img src="img/animal/jaja_farci.jfif" class="card-img-top" alt="...">
                            <div class="card-body p-1 m-0 text-center">
                                <h5 class="card-title">Farci</h5>
                                <p class="card-text">1500 DA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 zyada" style="height: 1800px;">
                        CAISSE ESPACE
                    </div>
                    {{-- morceau --}}

                </div>

            </div>







        </div>
        <div class="col-4 bg-dark">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-1">
                    <div class="row afficheur text-center">
                        <div class="col-12 p-1 m-0 align-content-center">
                            <h6 class="afficheur-titre">TOTAL FACTURE :</h6>
                            <p class="digital">0.00</p>
                        </div>
                    </div>
                    {{-- <h6 class="m-0 font-weight-bold text-center text-primary">Lise des achats</h6> --}}
                </div>




                <!-- script datatable  -->


                <div class="card-body">

                    <!-- new script table  -->



                    <!-- script datatable  -->


                    <div class="card-body m-0 p-1" style="max-height: 550px; overflow-y: auto;  ">

                        <table id="example" class="display" style="width:100% ">
                            <thead>
                                <tr>
                                    <th>Designation:</th>
                                    <th>Prix:</th>
                                    <th>QTE:</th>
                                    <th>Total:</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <tr>
                                    <td>cuisse de poulet</td>
                                    <td>800 DA</td>
                                    <td>250 g</td>
                                    <td>1 200</td>

                                </tr>
                                <tr>
                                    <td>cuisse de poulet</td>
                                    <td>800 DA</td>
                                    <td>250 g</td>
                                    <td>1 200</td>

                                </tr>
                                <tr>
                                    <td>cuisse de poulet</td>
                                    <td>800 DA</td>
                                    <td>250 g</td>
                                    <td>1 200</td>

                                </tr>
                                <tr>
                                    <td>cuisse de poulet</td>
                                    <td>800 DA</td>
                                    <td>250 g</td>
                                    <td>1 200</td>

                                </tr>
                                <tr>
                                    <td>cuisse de poulet</td>
                                    <td>800 DA</td>
                                    <td>250 g</td>
                                    <td>1 200</td>

                                </tr>

                                <tr>
                                    <td>cuisse de poulet</td>
                                    <td>800 DA</td>
                                    <td>250 g</td>
                                    <td>1 200</td>

                                </tr>

                                <tr>
                                    <td>cuisse de poulet</td>
                                    <td>800 DA</td>
                                    <td>250 g</td>
                                    <td>1 200</td>

                                </tr>

                                <tr>
                                    <td>cuisse de poulet</td>
                                    <td>800 DA</td>
                                    <td>250 g</td>
                                    <td>1 200</td>

                                </tr>

                                <tr>
                                    <td>cuisse de poulet</td>
                                    <td>800 DA</td>
                                    <td>250 g</td>
                                    <td>1 200</td>

                                </tr>

                                <tr>
                                    <td>Michael Silva</td>
                                    <td>Marketing Designer</td>
                                    <td>London</td>
                                    <td>6</td>

                                </tr>
                                <tr>
                                    <td>Paul Byrd</td>
                                    <td>Chief Financial Officer (CFO)</td>
                                    <td>New York</td>
                                    <td>64</td>

                                </tr>

                            </tbody>
                        </table>
                        <div class="col-12 zyada" style="height: 500px;">
                            CAISSE ESPACE
                        </div>
                    </div>
                    <!-- end new script table  -->


                </div>
            </div>






        </div>

        {{-- FIN FACTURE  ----------------------------------------------------- --}}

    </div>
    {{-- FIN SELECTION PRODUIT ET FACTURE  -------------------------------------------------------}}










    <!-- Footer -->
    <footer class="sticky-footer-caisse bg-white">
        <div class="container-fluid m-0 p-0">
            <div class="row align-content-center m-0 p-0">

                <div class="col-4">
                    <div class="row">
                        <div class="col-3">
                            <a class="btn btn-primary" href="">boutton 1</a>
                        </div>
                        <div class="col-3">
                            <a class="btn btn-primary" href="">boutton 2</a>
                        </div>
                        <div class="col-3">
                            <a class="btn btn-primary" href="">boutton 3</a>
                        </div>
                        <div class="col-3">
                            <a class="btn btn-primary" href="">boutton 4</a>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-3">
                            <a class="btn btn-warning" href="">boutton 1</a>
                        </div>
                        <div class="col-3">
                            <a class="btn btn-warning" href="">boutton 2</a>
                        </div>
                        <div class="col-3">
                            <a class="btn btn-warning" href="">boutton 3</a>
                        </div>
                        <div class="col-3">
                            <a class="btn btn-warning" href="">boutton 4</a>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-3">
                            <a class="btn btn-success" href="">boutton 1</a>
                        </div>
                        <div class="col-3">
                            <a class="btn btn-success" href="">boutton 2</a>
                        </div>
                        <div class="col-3">
                            <a class="btn btn-success" href="">boutton 3</a>
                        </div>
                        <div class="col-3">
                            <a class="btn btn-danger" href="">boutton 4</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </footer>
    <!-- End of Footer -->


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
                    },
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });
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



        /*  */
    </style>

    </div>



    <script>
    const connectButton = document.getElementById('connect');
    // const output = document.getElementById('output');
    const balance = document.getElementById('balance');

    connectButton.addEventListener('click', async () => {
        try {
            // Demander à l'utilisateur de sélectionner un port série
            const port = await navigator.serial.requestPort();

            // Ouvrir une connexion au port série
            await port.open({ baudRate: 9600 });

            // Créer un lecteur de flux pour lire les données du port série
            const reader = port.readable.getReader();

            // Lire les données du port série
            while (true) {
                const { value, done } = await reader.read();
                if (done) break;

                // Convertir les données en texte
                const data = new TextDecoder().decode(value);

                // Extraire uniquement le nombre (poids) avant 'kg'
                const numberMatch = data.match(/(\d+(\.\d+)?)(?=kg)/);

                if (numberMatch) {
                    const number = numberMatch[1]; // Extraire le nombre

                    // Mettre à jour le contenu de <h1 id="balance">
                    balance.textContent = `${number}`;
                }

                // Afficher les données complètes dans le <pre id="output"> pour débogage (optionnel)
                // output.textContent = data;
            }

            // Fermer la connexion au port série
            await port.close();
        } catch (error) {
            console.error('Erreur de communication série :', error);
        }
    });
</script>
@endsection

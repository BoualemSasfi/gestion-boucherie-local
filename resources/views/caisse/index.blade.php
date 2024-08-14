@extends('layouts.caisse')

@section('content')
    <div class="container-fluid m-0 p-0">






        <!-- End of Topbar -->
        <!-- numerique -->

        <div class="row afficheur p-1">
            <div class="col-8">
                <div class="row text-center">
                    <div class="col-3">
                        <h6 class="objet-titre">POULET</h6>
                        <p class="objet-titre">poitrine</p>
                    </div>
                    <div class="col-3">
                        <h6 class="afficheur-titre">QTE:</h6>
                        <p class="digital">00,000</p>
                    </div>
                    <div class="col-3">
                        <h6 class="afficheur-titre">PRIX UNITAIRE:</h6>
                        <p class="digital">750.00</p>
                    </div>
                    <div class="col-3">
                        <h6 class="afficheur-titre">PRIX TOTAL :</h6>
                        <p class="digital">00.00</p>
                    </div>
                </div>
                
                
            </div>
            <div class="col-4 text-center">
                <h6 class="afficheur-titre">TOTAL FACTURE :</h6>
                <p class="digital">0.00</p>
            </div>
        </div>

        <div class="row" style="margin-top: 2px;">
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

                <div class="container" style="height: 300px; overflow-y: auto;">
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

                        {{-- morceau --}}
                        <div class="zyada col-12" style="height: 80px;"></div>

                    </div>
                </div>

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





            </div>
            <div class="col-4 bg-dark">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-1">
                        <h6 class="m-0 font-weight-bold text-center text-primary">Lise des achats</h6>
                    </div>




                    <!-- script datatable  -->


                    <div class="card-body">
                        <div class="">
                            <table id="facture" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Disigniation</th>
                                        <th>PRIX/Kg</th>
                                        <th>Poid</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>

                                        <th>Total</th>
                                        <th></th>
                                        <th>2000 DA</th>
                                    </tr>
                                </tfoot>
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
                                        <td>Michael Silva</td>
                                        <td>Marketing Designer</td>
                                        <td>London</td>
                                        <td>66</td>

                                    </tr>
                                    <tr>
                                        <td>Paul Byrd</td>
                                        <td>Chief Financial Officer (CFO)</td>
                                        <td>New York</td>
                                        <td>64</td>

                                    </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

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

    </div>
@endsection

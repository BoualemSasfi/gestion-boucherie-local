@extends('layouts.caisse')

@section('content')
    <div class="container-fluid m-0 p-0">






        <!-- End of Topbar -->
        <!-- numerique -->

        <div class="row affich">
            <div class="numerique col-8">
                <label for="">
                    0.5<span class="dz"> Kg</span>
                </label>
            </div>
            <div class="numerique col-4">
                <label for="">
                    012345 <span class="dz"> DZ</span>
                </label>
            </div>
        </div>

        <div class="row " style="margin-top: 2px;">
            <div class="col-8 ">


                {{-- <div class="row cat ">

                    <div class="card col-2" style="width: 100px; height: 100px;">
                        <img src="/img/animal/poulet.png" style="width: 100%; height: 100%;" alt="...">

                    </div>
                    <div class="card col-2" style="width: 100px; height: 100px;">
                        <img src="/img/animal/vache.png" style="width: 100%; height: 100%;" alt="...">

                    </div>
                    <div class="card col-2" style="width: 100px; height: 100px;">
                        <img src="/img/animal/dande.png" style="width: 100%; height: 100%;" alt="...">

                    </div>
                    <div class="card col-2" style="width: 100px; height: 100px;">
                        <img src="/img/animal/mouton.png" style="width: 100%; height: 100%;" alt="...">

                    </div>
                    <div class="card col-2" style="width: 100px; height: 100px;">
                        <img src="/img/animal/lapain.png" style="width: 100%; height: 100%;" alt="...">

                    </div>
                    <div class="card col-2" style="width: 100px; height: 100px;">
                        <img src="/img/animal/cheval.png" style="width: 100%; height: 100%;" alt="...">

                    </div>
                    <div class="card col-2" style="width: 100px; height: 100px;">
                        <img src="/img/animal/lapain.png" style="width: 100%; height: 100%;" alt="...">

                    </div>
                    <div class="card col-2" style="width: 100px; height: 100px;">
                        <img src="/img/animal/cheval.png" style="width: 100%; height: 100%;" alt="...">

                    </div>


                </div> --}}

                <div class="row cat">

                    <div class="container mt-4">
                        <div class="your-carousel">
                            <div class="card" style="width: 100px; height: 100px;">
                                <img src="/img/animal/lapain.png" style="width: 100%; height: 100%;" alt="...">
                            </div>
                            <div class="card" style="width: 100px; height: 100px;">
                                <img src="/img/animal/vache.png" style="width: 100%; height: 100%;" alt="...">
                            </div>
                            <div class="card" style="width: 100px; height: 100px;">
                                <img src="/img/animal/dande.png" style="width: 100%; height: 100%;" alt="...">
                            </div>
                            <div class="card" style="width: 100px; height: 100px;">
                                <img src="/img/animal/mouton.png" style="width: 100%; height: 100%;" alt="...">
                            </div>
                            <div class="card" style="width: 100px; height: 100px;">
                                <img src="/img/animal/lapain.png" style="width: 100%; height: 100%;" alt="...">
                            </div>
                            <div class="card" style="width: 100px; height: 100px;">
                                <img src="/img/animal/cheval.png" style="width: 100%; height: 100%;" alt="...">
                            </div>
                            <div class="card" style="width: 100px; height: 100px;">
                                <img src="/img/animal/lapain.png" style="width: 100%; height: 100%;" alt="...">
                            </div>
                            <div class="card" style="width: 100px; height: 100px;">
                                <img src="/img/animal/cheval.png" style="width: 100%; height: 100%;" alt="...">
                            </div>
                        </div>
                    </div>

                </div>






                <div class="row sous_cat">


                </div>

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
        $(document).ready(function(){
            $('.your-carousel').slick({
                slidesToShow: 6,
                slidesToScroll: 1,
                arrows: true,
                dots: false,
                infinite: false,
                responsive: [
                    {
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

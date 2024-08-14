@extends('layouts.caisse')

@section('content')










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


        <div class="row cat ">





            <!-- new  -->
         
            <!-- end  -->



            <div class="card" style="width: 150px; height: 150px;">
                <img src="/img/animal/poulet.png" class="card-img-top" alt="...">

            </div>
            <div class="card" style="width: 150px; height: 150px;">
                <img src="/img/animal/vache.png" class="card-img-top" alt="...">

            </div>
            <div class="card" style="width: 150px; height: 150px;">
                <img src="/img/animal/dande.png" class="card-img-top" alt="...">

            </div>
            <div class="card" style="width: 150px; height: 150px;">
                <img src="/img/animal/mouton.png" class="card-img-top" alt="...">

            </div>
            <div class="card" style="width: 150px; height: 150px;">
                <img src="/img/animal/lapain.png" class="card-img-top" alt="...">

            </div>
            <div class="card" style="width: 150px; height: 150px;">
                <img src="/img/animal/cheval.png" class="card-img-top" alt="...">

            </div>
            <div class="card" style="width: 150px; height: 150px;">
                <img src="/img/animal/chevre.png" class="card-img-top" alt="...">

            </div>
            <div class="card" style="width: 150px; height: 150px;">
                <img src="/img/animal/lapain.png" class="card-img-top" alt="...">

            </div>
            <div class="card" style="width: 150px; height: 150px;">
                <img src="/img/animal/poulet.png" class="card-img-top" alt="...">

            </div>
        </div>








        <div class="row sous_cat">


            <div class="card border border-primary rounded position-relative vesitable-item"
                style="width: 150px; height: 150px;">
                <div class="vesitable-img">
                    <img src="/img/animal/poulet.png" class="img-fluid w-100 rounded-top" alt="...">
                </div>
            </div>
            <div class="card border border-primary rounded position-relative vesitable-item"
                style="width: 150px; height: 150px;">
                <div class="vesitable-img">
                    <img src="/img/animal/mouton.png" class="img-fluid w-100 rounded-top" alt="...">
                </div>
            </div>
            <div class="card border border-primary rounded position-relative vesitable-item"
                style="width: 150px; height: 150px;">
                <div class="vesitable-img">
                    <img src="/img/animal/vache.png" class="img-fluid w-100 rounded-top" alt="...">
                </div>
            </div>
            <div class="card border border-primary rounded position-relative vesitable-item"
                style="width: 150px; height: 150px;">
                <div class="vesitable-img">
                    <img src="/img/animal/dande.png" class="img-fluid w-100 rounded-top" alt="...">
                </div>
            </div>
            <div class="card border border-primary rounded position-relative vesitable-item"
                style="width: 150px; height: 150px;">
                <div class="vesitable-img">
                    <img src="/img/animal/chevre.png" class="img-fluid w-100 rounded-top" alt="...">
                </div>
            </div>
            <div class="card border border-primary rounded position-relative vesitable-item"
                style="width: 150px; height: 150px;">
                <div class="vesitable-img">
                    <img src="/img/animal/lapain.png" class="img-fluid w-100 rounded-top" alt="...">
                </div>
            </div>
            <div class="card border border-primary rounded position-relative vesitable-item"
                style="width: 150px; height: 150px;">
                <div class="vesitable-img">
                    <img src="/img/animal/cheval.png" class="img-fluid w-100 rounded-top" alt="...">
                </div>
            </div>


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





@endsection
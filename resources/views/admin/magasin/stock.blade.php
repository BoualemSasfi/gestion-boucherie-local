@extends('layouts.admin')
@section('content')

{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row d-flex justify-content-between align-items-center">
        <div class="col-2">
            <a href="{{ url('/admin/magasin') }}" class="btn btn-dark">
                <i class="fas fa-arrow-left pr-1"></i>
                <span class="btn-description"></span>
            </a>
        </div>
        <div class="col-8 text-center">
            <h2>stock {{$magasins->type}} {{$magasins->nom}} </h2>
        </div>
        <div class="col-2 text-right">

        </div>
    </div>

</div>


<div class="container" style="margin-top: 10px;">

    <div class="row animate__animated animate__backInLeft">

        <div class="card shadow col-12">

            <div class="card-body">

                <div class="row">
                    <div class="col-6">

                        <h5>Nom : {{$magasins->nom}} </h5>
                        <h5>type : {{$magasins->type}} </h5>
                        <h5>N° register : {{$magasins->N_reg}} </h5>
                        <h5>N° telephone : {{$magasins->tel}} </h5>
                        <h5>état :
                            @if ($magasins->activ = 1)
                                active
                            @else
                                non active
                            @endif
                        </h5>
                    </div>

                    @if (!empty($magasins->photo) && Storage::exists('public/' . $magasins->photo))
                        <div class="col-6  text-center">
                            <!-- <label for="">Photo :</label> -->
                            <img src="{{ asset('storage/' . $magasins->photo) }}" class="img-fluid rounded" alt=""
                                style="height:80%; width:100%; margin-top: 5px; cursor: pointer;" id="preview2"
                                onclick="triggerFileInput();">
                        </div>
                    @else
                        <div class="col-6  text-center">
                            <!-- <label for="">Photo :</label> -->
                            <img src="{{ asset('img/logo_vide/your_photo.jpg') }}" class="img-fluid rounded" alt=""
                                style="height:80%; width:100%; margin-top: 5px; cursor: pointer;" id="preview2"
                                onclick="triggerFileInput();">
                        </div>
                    @endif




                </div>
                <div class="row">
                    <div class="col-12 text-center">

                        <H1>STOCK</H1>
                    </div>

                    <div class="col-12">
                        <div class="container mt-4">


                            @if ($magasins->type == 'Atelier')


                                    <ul class="nav nav-tabs ">
                                        <li class="nav-item col-6  ">
                                            <a class="nav-link active bg-danger" id="frais-tab" aria-current="page" href="#"
                                                onclick="showTab('frais'); return false;">Frais</a>
                                        </li>

                                        <li class="nav-item col-6">
                                            <a class="nav-link bg-primary " id="congele-tab" href="#"
                                                onclick="showTab('congele'); return false;">Congelé</a>
                                        </li>
                                    </ul>

                                    <div id="frais-content" class="tab-content mt-3">
                                        <div>

                                            <h4 class="text-center">Frais</h4>
                                            <button>
                                                transfaire
                                            </button>
                                        </div>
                                        <table class="table-striped table-bordered col-12">
                                            <thead class="text-center">

                                                <tr>
                                                    <th>categorré</th>
                                                    <th>produit</th>

                                                    <th>poid</th>
                                                    <th>action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($stock_frais as $frais)


                                                    <tr>
                                                        <td>{{$frais->categorie}}</td>
                                                        <td>{{$frais->produit}}</td>
                                                        <td>{{$frais->quantity}}</td>

                                                        <td class="text-center space-x-8">
                                                            <!-- <button type="button" class="btn btn-outline-secondary">add</button>
                                                                                            <button type="button" class="btn btn-outline-danger">trasfirer</button> -->
                                                            <button type="button" class="btn btn-outline-info">ajustier</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div id="congele-content" class="tab-content mt-3" style="display: none;">
                                        <h4 class="text-center">Congelé</h4>
                                        <table class="table-striped table-bordered col-12">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>categorré</th>
                                                    <th>produit</th>

                                                    <th>poid</th>
                                                    <th>action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($stock_congele as $congele)


                                                    <tr>
                                                        <td>{{$congele->categorie}}</td>
                                                        <td>{{$congele->produit}}</td>

                                                        <td>{{$congele->quantity}}</td>

                                                        <td class="text-center space-x-8">
                                                            <!-- <button type="button" class="btn btn-outline-secondary">add</button>
                                                                                            <button type="button" class="btn btn-outline-danger">trasfirer</button> -->
                                                            <button type="button" class="btn btn-outline-info">ajustier</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                </di v>

                            @else

                                <table class="table-striped table-bordered col-12">
                                    <thead class="text-center">
                                        <tr>
                                            <th>categorré</th>
                                            <th>produit</th>

                                            <th>poid</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($stock_frais as $frais)


                                            <tr>
                                                <td>{{$frais->categorie}} </td>
                                                <td>{{$frais->produit}} </td>
                                                <td>{{$frais->quantity}} </td>

                                                <td class="text-center space-x-8">
                                                    <!-- <button type="button" class="btn btn-outline-secondary">add</button>
                                                                            <button type="button" class="btn btn-outline-danger">trasfirer</button> -->
                                                    <button type="button" class="btn btn-outline-info">ajustier</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            @endif
                    </div>

                </div>



            </div>


            <script>
                function showTab(tabName) {
                    // Masquer tous les contenus
                    document.getElementById('frais-content').style.display = 'none';
                    document.getElementById('congele-content').style.display = 'none';

                    // Afficher le contenu correspondant
                    document.getElementById(tabName + '-content').style.display = 'block';

                    // Enlever la classe 'active' de tous les onglets
                    document.getElementById('frais-tab').classList.remove('active');
                    document.getElementById('congele-tab').classList.remove('active');

                    // Ajouter la classe 'active' à l'onglet sélectionné
                    document.getElementById(tabName + '-tab').classList.add('active');
                }
            </script>




<button id="trans">
    Transfert
</button>



<script>
    document.getElementById('trans').addEventListener('click', async () => {
        // Convert the PHP array of magasins into a JavaScript object
        const magasins = {
            @foreach ($lesmagasins as $lemagasin)
                "{{ $lemagasin->id }}": "{{ $lemagasin->nom }}",
            @endforeach
        };

        const { value: selectedMagasin } = await Swal.fire({
            title: "Sélectionnez un magasin",
            input: "select",
            inputOptions: magasins, // Use the magasins object here
            inputPlaceholder: "Sélectionnez un magasin",
            showCancelButton: true,
            inputValidator: (value) => {
                return new Promise((resolve) => {
                    if (value) {
                        resolve();
                    } else {
                        resolve("Vous devez sélectionner un magasin :)");
                    }
                });
            }
        });

        if (selectedMagasin) {
            Swal.fire(`Vous avez sélectionné : ${magasins[selectedMagasin]}`);
        }
    });
</script>



            @endsection
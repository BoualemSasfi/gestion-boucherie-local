@extends('layouts.admin')
@section('content')





{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row d-flex justify-content-between align-items-center">
        <div class="col-2">
            <a href="{{ url('/admin/liste_fact') }}" class="btn btn-dark">
                <i class="fas fa-arrow-left pr-1"></i>
                <span class="btn-description"></span>
            </a>
        </div>

        <div class="col-8 text-center">
            <h2>Details de facture N° {{$facture->code_facture}} <i class="fa-solid fa-right-left fa-flip fa-xl"
                    style="color: #63E6BE;"></i></h2>
        </div>
        <div class="col-2 text-right">
            <!-- <a href="{{ url('/admin/vente/liste') }}" class="btn btn-success">
                <i class="fas fa-plus fa-xl pr-1"></i>
                <span class="btn-description"></span>
            </a> -->
            <button class="btn btn-success" id="printButton">Imprimer <i class="fa-solid fa-print"></i></button>
        </div>
    </div>

</div>
<!-- script pour facture et recu de paiement -->
<script>
document.getElementById('printButton').addEventListener('click', function () {
    const id_fact = {{$facture->id}};

    Swal.fire({
        title: 'Choisissez une option',
        icon: 'question',
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: 'Facture',
        denyButtonText: 'Bon',
        cancelButtonText: 'Annuler',
    }).then((result) => {
        if (result.isConfirmed) {
            // Ouvrir le PDF dans un nouvel onglet
            let newTab = window.open(`/imprimer_facteur/${id_fact}`, '_blank');
            
            // Attendre que le PDF soit complètement chargé puis lancer l'impression
            newTab.onload = function() {
                newTab.print(); // Imprimer le PDF dans le nouvel onglet
            };
        } else if (result.isDenied) {
            Swal.fire('Non implémenté', 'La fonction Bon est encore à implémenter.', 'info');
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            console.log('Action annulée');
        }
    });
});

</script>



<div class="container" style="margin-top: 10px;">
    <div class="row animate__animated animate__backInLeft">
        <div class="card shadow col-12 ">
            <div class="row">
                <div class="col-6">
                    <div class="card shadow m-1">
                        <div class="card-body">
                            <H4 class="text-center">Information D'Atelier <i class="fa-solid fa-warehouse fa-lg"></i>
                            </H4>
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="">
                                        @foreach ($magasins as $magasin)
                                            @if ($magasin->id == $facture->id_magasin)
                                                Nom : {{$magasin->nom}}
                                                <br>
                                                N°RC : {{$magasin->N_reg}}
                                                <br>
                                                NIF : {{$magasin->N_reg}}
                                                <br>
                                                NIS : {{$magasin->N_reg}}
                                                <br>
                                                Adresse : {{$magasin->adresse}}
                                                <br>
                                                tel : {{$magasin->tel}}
                                                <br>
                                            @endif
                                        @endforeach
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($facture->credit > 0)
                        <h3>credti de la facteur :<span style="float: right;"> {{$facture->credit}} DA </span> </h3>
                    @endif
                </div>

                <div class="col-6">
                    <div class="card shadow m-1">
                        <div class="card-body">
                            <H4 class="text-center">Information Client <i class="fa-solid fa-user-tie fa-lg"></i></H4>
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="">
                                        @foreach ($clients as $client)
                                            @if ($client->id == $facture->id_client)
                                                Nom : {{$client->nom_prenom}}
                                                <br>
                                                N°RC : {{$client->n_rc}}
                                                <br>
                                                NIF : {{$client->NIF}}
                                                <br>
                                                NIS : {{$client->NIS}}
                                                <br>
                                                Adresse : {{$client->adresse}}
                                                <br>
                                                Tel : {{$client->fix}}
                                            @endif
                                        @endforeach
                                        <br>
                                    </h5>
                                    <h5>

                                        @php
                                            $totalCredit = 0;
                                        @endphp
                                        @foreach ($credits as $credit)
                                                                            @if ($credit->id_client == $facture->id_client)
                                                                                                                @php
                                                                                                                    $totalCredit += $credit->credit;
                                                                                                                @endphp
                                                                            @endif
                                        @endforeach
                                        @if ($totalCredit != 0)
                                            Total crédit client : <span style="float: right;">{{ $totalCredit }}.00 DA
                                            </span>
                                        @endif
                                    </h5>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-body">
                <div class="card-body">
                    <table id="example" class="table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Categorie</th>
                                <th>Produit</th>
                                <th>PU</th>
                                <th>Q</th>

                                <th>TOTAL </th>

                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($listes as $liste)
                                <tr>
                                    <td class=" align-middle">{{ $liste->categorie}}</td>
                                    <td class=" align-middle">{{ $liste->produit}}</td>
                                    <td class=" align-middle">{{ $liste->PU}}</td>
                                    <td class=" align-middle">{{ $liste->Q}}</td>
                                    <td class=" align-middle">{{ $liste->total}}</td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-8 ">

                    </div>
                    <!-- <div class="col-4 ">
                        <H4>TOTAL HT : <span style="float: right;">{{$facture->total_facture}} DA </span> </H4>
                        <H4>TOTAL TVA :<span style="float: right;">0.00 DA</span> </H4>
                        <H4>TOTAL TTC :<span style="float: right;">{{$facture->total_facture}} DA </span></H4>
                    </div> -->
                    <H3>Total facteur : <span style="float: right;"> {{$facture->total_facture}} DA </span> </H3>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- pour afficher le message dialoge apre les funciton de controller  -->
@if(session('success'))
    <script>
        Swal.fire({
            title: 'Succès',
            text: '{{ session('success') }}',
            icon: 'success',
            timer: '2000',
            showConfirmButton: false
        });
    </script>
@endif



<!-- pour afficher le message dialoge apre les funciton de controller  -->
@if(session('success'))
    <script>
        Swal.fire({
            title: 'Succès',
            text: '{{ session('success') }}',
            icon: 'success',
            timer: '3000',
            showConfirmButton: false
        });
    </script>
@endif



@endsection
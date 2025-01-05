@extends('layouts.admin')
@section('content')

{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row d-flex justify-content-between align-items-center">
        <div class="col-2">
            <a href="{{ url('/admin/client') }}" class="btn btn-dark">
                <i class="fas fa-arrow-left pr-1"></i>
                <span class="btn-description"></span>
            </a>
        </div>
        <div class="col-8 text-center">
            <h2>Details de client  {{$client->nom_prenom}} </h2>
        </div>
        <div class="col-2 text-right">

        @if ($credit > 0 )
        <button class="btn btn-success" style="float: right;">Versement </button>
        
        @endif




        </div>
    </div>

</div>


<div class="container" style="margin-top: 10px;">

    <div class="row animate__animated animate__backInLeft">

        <div class="card shadow col-12">

            <div class="card-body">

                <div class="row">
                    <div class="col-6">

                        <h5>Nom : {{$client->nom_prenom}} </h5>
                        <h5>N° telephone : {{$client->fix}} </h5>
                        <h5>Details : {{$client->details}} </h5>

                    </div>


                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <H1>état des payements </H1>
                    </div>
                    <div>
                        <h5>Total achat: <span style="color: green;">{{$totalfacture}}</span> DA</h5>

                        <h5 style=" margin-top: 10px;">Crédit : <span style="color: red;">{{$credit}}</span> DA</h5>
                    </div>


                    <div class="col-12">
                        <div class="container mt-4">

                            <!-- Table of products -->
                            <table class="table-striped table-bordered col-12">
                                <thead class="text-center">
                                    <tr>

                                        <th>Id </th>
                                        <th>Date</th>
                                        <th>total</th>
                                        <th>verseemnt </th>
                                        <th>credit </th>
                                        <th>état </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($listes as $liste)
                                        <tr class="text-center">

                                            <td>{{$liste->id_facture}}</td>
                                            <td>{{$liste->created_at}}</td>
                                            <td>{{$liste->total_facture}} DA</td>
                                            <td>{{$liste->versement}} DA</td>
                                            <td>{{$liste->credit}} DA</td>

                                            <!-- <td >
                                                                        @if ($liste->etat_credit == 'impayé')
                                                                            <i class="fa-solid fa-circle-xmark fa-lg" style="color: #f7224c;"></i>
                                                                        @else
                                                                            <i class="fa-solid fa-circle-check fa-lg" style="color: #63E6BE;"></i>
                                                                        @endif
                                                                    </td> -->
                                            <td>
                                                @if ($liste->etat_credit == 'impayé')
                                                    <button
                                                        onclick="afficherSweetAlert({{ $liste->id_facture }}, {{ $liste->credit }})"
                                                        style="background: none; border: none;">
                                                        <i class="fa-solid fa-circle-xmark fa-lg" style="color: #f7224c;"></i>
                                                    </button>
                                                @else
                                                    <i class="fa-solid fa-circle-check fa-lg" style="color: #63E6BE;"></i>
                                                @endif
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>







                    </div>
                </div>

                <script>
                    function afficherSweetAlert(id_facture, credit) {
                        Swal.fire({
                            title: `Crédit impayé : ${credit} DA`,
                            text: `voulez vous valider ce credit ..?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Valider',
                            cancelButtonText: 'Annuler',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirige vers le contrôleur avec l'ID de la facture
                                window.location.href = `/admin/client/valider_paiement/${id_facture}`;
                            }
                        });
                    }

                </script>



                @if(session('success'))
                    <script>
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });

                        Toast.fire({
                            icon: "success",
                            title: "{{ session('success') }}"
                        });
                    </script>
                @endif
                <!-- ------------------------------------------------------------------------------------------------------------------------ -->
                @endsection
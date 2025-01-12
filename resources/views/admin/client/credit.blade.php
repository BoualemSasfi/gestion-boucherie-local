@extends('layouts.admin')
@section('content')

{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row d-flex justify-content-between align-items-center">
        <div class="col-12 col-md-2 mb-3 mb-md-0">
            <a href="{{ url('/admin/client') }}" class="btn btn-dark">
                <i class="fas fa-arrow-left pr-1"></i>
                <span class="btn-description"></span>
            </a>
        </div>
        <div class="col-12 col-md-8 text-center">
            <h2>Details de client {{$client->nom_prenom}} </h2>
        </div>
        <div class="col-12 col-md-2 text-right">
            @if ($client->credit > 0)
                <button onclick="afficherSweetAlert({{$client->credit}}, {{$client->id}})" class="btn btn-success"
                    style="float: right;">Versement </button>
            @endif
        </div>
    </div>
</div>

<div class="container mt-3">

    <div class="row animate__animated animate__backInLeft">

        <div class="card shadow col-12">

            <div class="card-body">

                <div class="row">
                    <div class="col-12 col-md-6">

                        <h5>Nom : {{$client->nom_prenom}} </h5>
                        <h5>N° telephone : {{$client->fix}} </h5>
                        <h5>Details : {{$client->details}} </h5>

                    </div>
                    <div class="col-12 col-md-6">

                        <h5>NRC : {{$client->n_rc}} </h5>
                        <h5>NIF : {{$client->NIF}} </h5>
                        <h5>NIS : {{$client->NIS}} </h5>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <H1>état de Credit</H1>
                    </div>
                    <div>
                        <h5>Total achat: <span style="color: green;">{{$totalfacture}}</span> DA</h5>

                        <h5 style=" margin-top: 10px;">Crédit : <span style="color: red;"> {{$client->credit}} </span>
                            DA</h5>
                    </div>
                    <div class="col-12 text-center">
                        <H2>Liste des versemnts</H2>
                    </div>

                    <div class="col-12">
                        <div class="container mt-4">

                            <!-- Table of products -->
                            <table id="produitsTable" class="table table-striped table-bordered w-100">
                                <thead class="text-center">
                                    <tr>
                                        <th>Date</th>
                                        <th>Montant </th>
                                        <th>Action </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($versements as $versement)
                                        <tr class="text-center">
                                            <td>{{$versement->created_at}}</td>
                                            <td>{{$versement->montant}} DA</td>
                                            <td>
                                                <button onclick="print({{ $versement->id }})"
                                                    style="background: none; border: none;">
                                                    <i class="fa-solid fa-print fa-lg" style="color: #74C0FC;"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!-- data table -->
                <script>
                    $(document).ready(function () {
                        $('#produitsTable').DataTable({
                            "pageLength": 10,
                            "lengthMenu": [[10, 20, 50], [10, 20, 50]],
                            "scrollY": "400px",
                            "scrollCollapse": true,
                            "searching": true,

                        });
                    });
                </script>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    function print(id_versement) {
                        window.open(`/admin/client/print_recu/${id_versement}`, '_blank');
                    }
                </script>

                <script>
                    function afficherSweetAlert(credit, client) {
                        Swal.fire({
                            title: `Total crédit : ${credit} DA`,
                            html: `
                                <p>Saisissez un montant à verser :</p>
                                <input type="number" id="montant-input" class="swal2-input" 
                                       min="1" max="${credit}" placeholder="Montant (1 à ${credit})" required />
                            `,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Valider',
                            cancelButtonText: 'Annuler',
                            preConfirm: () => {
                                const inputValue = parseFloat(document.getElementById('montant-input').value);
                                if (!inputValue || inputValue <= 0 || inputValue > credit) {
                                    Swal.showValidationMessage(`Le montant doit être entre 1 et ${credit} DA.`);
                                    return false;
                                }
                                return inputValue; // Retourne la valeur valide pour l'utiliser après
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const montant = result.value; // Récupère le montant saisi
                                if (montant) {
                                    // Envoie la requête AJAX pour générer le PDF
                                    fetch(`/admin/client/valider_versement/${montant}/${client}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                // Récupère l'ID du versement depuis la réponse JSON
                                                const id_versement = data.id_versement;
                                                // Ouvre le PDF dans un nouvel onglet
                                                window.open(`/admin/client/print_recu/${id_versement}`, '_blank');
                                                location.reload();  // Rafraîchir la page

                                            } else {
                                                Swal.fire('Erreur', 'Une erreur est survenue lors de la génération du PDF.', 'error');
                                            }
                                        })
                                        .catch(error => {
                                            Swal.fire('Erreur', 'Une erreur est survenue lors de la communication avec le serveur.', 'error');
                                        });
                                }
                            }
                        });
                    }
                </script>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        @if(session('success'))
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
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
                        @endif

                        @if(session('error'))
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "error",
                                title: "{{ session('error') }}"
                            });
                        @endif
                    });
                </script>

            </div>
        </div>
    </div>
</div>
@endsection
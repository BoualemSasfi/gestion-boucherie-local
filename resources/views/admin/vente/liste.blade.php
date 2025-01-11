@extends('layouts.admin')
@section('content')





{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row d-flex justify-content-between align-items-center">
        <div class="col-2">
            <a href="{{ url('/admin') }}" class="btn btn-dark">
                <i class="fas fa-arrow-left pr-1"></i>
                <span class="btn-description"></span>
            </a>
        </div>

        <div class="col-8 text-center">
            <h2>Liste des factures <i class="fa-solid fa-right-left fa-flip fa-xl" style="color: #63E6BE;"></i></h2>
        </div>
        <div class="col-2 text-right">
            <a href="{{ url('/admin') }}" class="btn btn-success">
                <i class="fas fa-plus fa-xl pr-1"></i>
                <span class="btn-description"></span>
            </a>
        </div>
    </div>

</div>


<div class="container" style="margin-top: 10px;">

    <div class="row animate__animated animate__backInLeft">

        <div class="card shadow col-12">


            <div class="card-body">


                <div class="table-responsive">
                    <table id="produitsTable" class="table table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Total</th>

                                <th>Actions</th>
                                <th>état</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($listes as $liste)
                                <tr>
                                    <td class=" align-middle">{{ $liste->code_facture}}</td>
                                    <td class=" align-middle">{{ $liste->created_at}}</td>
                                    <td class="align-middle">
                                        @foreach ($clients as $client)
                                            @if ($client->id == $liste->id_client)
                                                {{ $client->nom_prenom }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class=" align-middle">{{ $liste->total_facture}}</td>
                                    <td>
                                        <div>
                                            <div class="col-1">
                                                {{-- edit VOIR STOCK --}}
                                                <form class="show-form"
                                                    action="{{ url('/admin/facture_details/' . $liste->id) }}" method="GET">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-info alpa shadow"><i
                                                            class="bi bi-pen"></i>Details</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td class=" align-middle">{{ $liste->etat_facture}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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


<script>
    $(document).ready(function () {
        $('#produitsTable').DataTable({
            "pageLength": 10,
            "lengthMenu": [[10, 20, 50], [10, 20, 50]],
            "scrollY": "400px",
            "scrollCollapse": true,
            "searching": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
            }
        });
    });
</script>


@endsection
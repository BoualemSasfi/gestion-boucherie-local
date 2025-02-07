@extends('layouts.admin')
@section('content')
 

    <div class="container" id="titre-page">
        <div class="row">
            <div class="col-2 d-flex align-items-center">
                <a href="{{ url('/admin/') }}" class="btn btn-dark"><i class="bi bi-house pr-2"></i><span
                        class="btn-description">Acceuil</span></a>
            </div>
            <div class="col-8 text-center">
                <h2>Liste des Magasins</h2>
            </div>
            <div class="col-2 d-flex align-items-center">
            </div>
        </div>
    </div>



    {{-- --------------------------------------------------------------------------------------------------------------------------------- --}}

    {{-- javascript DataTables --}}

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                processing: true,
                // scroller
                scrollCollapse: true,
                scroller: true,
                scrollY: 400 ,
                scrollX: true,
                // ----------
                // dom: '<"buttons-container"lBfrtip>', 
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ], // Specify the options
                buttons: [],
                language: {
                    "lengthMenu": "Afficher _MENU_ éléments par page",
                    "zeroRecords": "Aucun enregistrement trouvé",
                    "info": "Page _PAGE_ sur _PAGES_",
                    "infoEmpty": "Aucun enregistrement disponible",
                    "infoFiltered": "(filtré de _MAX_ total des enregistrements)",
                    "search": "Rechercher :",
                    "paginate": {
                        "first": "Premier",
                        "last": "Dernier",
                        "next": "Suivant",
                        "previous": "Précédent"
                    }
                },
                initComplete: function() {
                    // Ajouter des styles personnalisés
                    $('.dataTables_length select').css('width',
                        '60px'); // ajustez la largeur selon vos besoins
                },
            });
        });
    </script>

    {{-- CSS  --}}

    <style>
        .buttons-container {
            text-align: left;
            margin-top: 10px;
            margin-bottom: 10px;
            background-color: rgb(255, 255, 255);
        }

        #titre-page {
            margin-bottom: 20px;
        }
    </style>
    {{-- --------------------------------------------------------------------------------------------------------------------------------- --}}



    {{-- html  --}}

    <div class="container-fluid" style="padding-top:10px;padding-bottom:80px;">
        <div class="row animate__animated animate__backInLeft">
            <div class="col-md-12">
                <div class="card shadow" style="background-color: #ffff;">
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                        {{-- <table id="example" class="table cell-border compact hover" style="width:100%;"> --}}
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Magasin</th>
                                    <th>Adresse</th>
                                    <th>Nombre de Caisses</th>
                                    <th>Libelle Des Caisses</th>
                                    <th>Actions</th>
                            </thead>

                            <tbody>
                                @foreach ($magasins as $magasin)
                                    <tr>

                                        <td class="text-center">{{ $magasin->id }}</td>
                                        <td class="text-center">{{ $magasin->nom }}</td>
                                        <td class="text-center">{{ $magasin->adresse }}</td>
                                        <td class="text-center">
                                            @foreach($nombre_caisses as $nombre_caisse)
                                            @if($nombre_caisse->id_magasin == $magasin->id)
                                            {{ $nombre_caisse->count }}
                                            @endif
                                            @endforeach
                                        </td>

                                        <td class="text-left">
                                            @foreach($caisses as $caisse)
                                            @if($caisse->id_magasin == $magasin->id)
                                            {{ $caisse->code_caisse }} <br>
                                            @endif
                                            @endforeach
                                        </td>

                                        <td class="text-center" style="width:240px;">

                                            <div class="container">
                                                <div class="row">

                                                    <div class="col-12">
                                                        {{-- show button    --}}
                                                        <form class="show-form"
                                                            action="{{ url('/admin/calculs/' . $magasin->id . '/stock/voir') }}"
                                                            method="GET">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-outline-info shadow">
                                                                <i class="fas fa-eye fa-lg"></i>
                                                                Voir</button>
                                                        </form>
                                                    </div>


                                                </div>
                                            </div>


                                        </td>

                                    </tr>

                                @endforeach
                            </tbody>
                            <tfoot>                             
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>





    {{-- footer  --}}
    <div class="container" id="pied-page">


    @endsection

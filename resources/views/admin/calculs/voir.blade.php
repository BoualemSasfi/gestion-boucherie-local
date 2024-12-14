@extends('layouts.admin')
@section('content')
    <div class="container" id="titre-page">
        <div class="row">
            <div class="col-2 d-flex align-items-center">
                <a href="{{ url('/admin/calculs') }}" class="btn btn-dark"><i class="bi bi-house"></i><span
                        class="btn-description">Retour</span></a>
            </div>
            <div class="col-8 text-center">
                <h2>Calculs de transfert</h2>
            </div>
            <div class="col-2 d-flex align-items-center">
            </div>
        </div>
    </div>



    {{-- --------------------------------------------------------------------------------------------------------------------------------- --}}

    {{-- javascript DataTables --}}
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
                                    <th>calculs_par_jour_id</th>
                                    <th>categorie_id</th>
                                    <th>categorie_designation</th>

                                    <th>total_ventes</th>
                                    <th>total_quantite_transfere</th>
                                    <th>total_quantite_retour</th>
                                    <th>total_quantite_reste</th>

                                    <th>poids_os</th>
                                    <th>prix_os</th>
                                    <th>poids_dechets</th>
                                    <th>prix_dechets</th>

                                    <th>poids_decalage</th>
                                    <th>poids_insere</th>
                                    <th>montant_insere</th>
                                    
                                    <th>created_at</th>
                                    
                            </thead>

                            <tbody>
                                @foreach ($calculs_transferts as $calculs_transfert)
                                    <tr>
                                        <td class="text-center">{{ $calculs_transfert->id }}</td>
                                        <td class="text-center">{{ $calculs_transfert->calculs_par_jour_id }}</td>
                                        <td class="text-center">{{ $calculs_transfert->categorie_id }}</td>
                                        <td class="text-center">{{ $calculs_transfert->categorie_designation }}</td>

                                        <td class="text-center">{{ $calculs_transfert->total_ventes }}</td>
                                        <td class="text-center">{{ $calculs_transfert->total_quantite_transfere }}</td>
                                        <td class="text-center">{{ $calculs_transfert->total_quantite_retour }}</td>
                                        <td class="text-center">{{ $calculs_transfert->total_quantite_reste }}</td>

                                        <td class="text-center">{{ $calculs_transfert->poids_os }}</td>
                                        <td class="text-center">{{ $calculs_transfert->prix_os }}</td>
                                        <td class="text-center">{{ $calculs_transfert->poids_dechets }}</td>
                                        <td class="text-center">{{ $calculs_transfert->prix_dechets }}</td>

                                        <td class="text-center">{{ $calculs_transfert->poids_decalage }}</td>
                                        <td class="text-center">{{ $calculs_transfert->poids_insere }}</td>
                                        <td class="text-center">{{ $calculs_transfert->montant_insere }}</td>

                                        <td class="text-center">{{ $calculs_transfert->created_at }}</td>

                                    </tr>

                                    {{-- produits de la catégorie  --}}

                                    <table id="example2" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>calculs_transfert_id</th>
                                            <th>lestock_id</th>
                                            <th>produit_id</th>
                                            <th>produit_designation</th>
                                            <th>quantite_ventes</th>
                                            <th>quantite_retour</th>
                                            <th>quantite_reste</th>
                                            <th>montant_ventes</th>
                                            <th>created_at</th>
                                        </tr>
                                    </thead>
                                
                                    <tbody>
                                        @foreach($calculs_lists as $calculs_list)
                                        @if( $calculs_list->calculs_transfert_id == $calculs_transfert->id )
                                        <td class="text-center">{{ $calculs_list->id }}</td>
                                        <td class="text-center">{{ $calculs_list->calculs_transfert_id }}</td>
                                        <td class="text-center">{{ $calculs_list->lestock_id }}</td>
                                        <td class="text-center">{{ $calculs_list->produit_id }}</td>
                                        <td class="text-center">{{ $calculs_list->produit_designation }}</td>
                                        <td class="text-center">{{ $calculs_list->quantite_ventes }}</td>
                                        <td class="text-center">{{ $calculs_list->quantite_retour }}</td>
                                        <td class="text-center">{{ $calculs_list->quantite_reste }}</td>
                                        <td class="text-center">{{ $calculs_list->montant_ventes }}</td>
                                        <td class="text-center">{{ $calculs_list->created_at }}</td>
                                        @endif
                                        @endforeach
                                    </tbody>
                                    </table>

                                @endforeach
                            </tbody>
                            <tfoot>
                                {{-- <tr>
                                    <th>id</th>
                                    <th>calculs_par_jour_id</th>
                                    <th>categorie_id</th>
                                    <th>categorie_designation</th>

                                    <th>total_ventes</th>
                                    <th>total_quantite_transfere</th>
                                    <th>total_quantite_retour</th>
                                    <th>total_quantite_reste</th>

                                    <th>poids_os</th>
                                    <th>prix_os</th>
                                    <th>poids_dechets</th>
                                    <th>prix_dechets</th>

                                    <th>poids_decalage</th>
                                    <th>poids_insere</th>
                                    <th>montant_insere</th>
                                    
                                    <th>created_at</th>
                                    <th>Actions</th>
                                </tr> --}}
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

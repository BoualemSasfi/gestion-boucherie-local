@extends('layouts.admin')
@section('content')
    

<div class="container" id="titre-page">
    <div class="row">
        <div class="col-2 d-flex align-items-center">
            <a href="{{ url('/admin/') }}" class="btn btn-dark"><i class="bi bi-house pr-2"></i><span
                    class="btn-description">Acceuil</span></a>
        </div>
        <div class="col-8 text-center">
            <h2>Calculs des ventes par catégories</h2>
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
                scrollY: 400,
                scrollX: true,
                // ----------
                // dom: '<"buttons-container"lBfrtip>', 
                lengthMenu: [
                    [-1],
                    ["All"]
                ], // Specify the options
                pageLength: -1, // Afficher tous les éléments sur une seule page
                buttons: [],
                searching: false, // Désactiver la recherche
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


    <div class="container-fluid" style="padding-top:10px;padding-bottom:80px;">
        <div class="row animate__animated animate__backInLeft">
            <div class="col-md-12">
                <div class="card shadow" style="background-color: #ffff;">
                    <div class="card-body">

                        <div class="row align-items-center border p-3 mb-3" id="filtrage-row"
                            style="background-color: #f8f9fa; border-radius: 8px;">
                            <div class="col-4">
                                <label for="start-datetime" class="form-label">Début (Date & Heure)</label>
                                <input type="datetime-local" id="start-datetime" class="form-control">
                            </div>
                            <div class="col-4">
                                <label for="end-datetime" class="form-label">Fin (Date & Heure)</label>
                                <input type="datetime-local" id="end-datetime" class="form-control">
                            </div>
                            <div class="col-4 text-center">
                                <button id="apply-filter" class="btn btn-primary mt-4 w-100" onclick="FiltrerData()">
                                    <i class="bi bi-filter pr-2"></i>Appliquer le filtre
                                </button>
                                <br>
                                <button id="delete-filter" class="btn btn-danger mt-4 w-100"
                                    onclick="window.location.href='{{ url('/admin/calculs/categories') }}'">
                                    <i class="bi bi-x-lg pr-2"></i>Supprimer le filtre
                                </button>

                            </div>
                        </div>



                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            {{-- <table id="example" class="table cell-border compact hover" style="width:100%;"> --}}
                            <thead>
                                <tr>
                                    <th>CATEGORIE</th>
                                    <th>QUANTITE VENDUE</th>
                                    <th>MONTANT TOTAL</th>
                                </tr>


                            </thead>

                            <tbody id="data">
                                @forelse ($ventes as $vente)
                                    <tr>
                                        <td><b>{{ $vente->categorie_nom }}</b></td>
                                        <td>{{ $vente->total_quantite}} {{ $vente->unite }}</td>
                                        <td>{{ $vente->total_total_vente }} DA</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Aucun résultat trouvé</td>
                                    </tr>
                                @endforelse
                            </tbody>

                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- --------------------------------------------------------------------------------------------------------------------------------- --}}
    <script>
        function formatDateToYMDHIS(dateString) {
            const date = new Date(dateString);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');
            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }
    </script>

    <script>
        async function FiltrerData() {

            let date1 = document.getElementById('start-datetime').value;
            let date2 = document.getElementById('end-datetime').value;


            let filtreCase = '';
            if (date1 && date2) {
                filtreCase = 'periode';
            } else if (date1 && !date2) {
                filtreCase = 'debut';
            } else if (!date1 && date2) {
                filtreCase = 'fin';
            } else {
                filtreCase = 'vide';
            }

            // Récupérer la date courante
            let currentDate = new Date();

            // Si tu veux la date au format YYYY-MM-DD (par exemple)
            let formattedDate = currentDate.toISOString().split('T')[0];

            if (!date1) {
                date1 = formattedDate;
            }

            if (!date2) {
                date2 = formattedDate;
            }


            if (filtreCase === 'vide') {
                Swal.fire({
                    title: "Veuillez saisir la date et l'heure",
                    icon: "warning",
                    showConfirmButton: false,
                    timer: 1000,
                });
                return;
            }

            console.log('/admin/calculs/categories/' + date1 + '/' + date2 + '/' + filtreCase);


            try {
                $.ajax({
                    url: `/admin/calculs/categories/${date1}/${date2}/${filtreCase}`,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        console.log('Réponse JSON:', response.ventes);
                        const DataContainer = $('#data');
                        DataContainer.empty();
                        Swal.fire({
                            title: "Filtre Activé",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1000,
                        });

                        if (!response.ventes || response.ventes.length === 0) {
                            Swal.fire({
                                title: "Aucun résultat trouvé",
                                icon: "info",
                                showConfirmButton: false,
                                timer: 1000,
                            });
                            return;
                        }

                        response.ventes.forEach(value => {
                            DataContainer.append(`
                            <tr>
                                <td><b>${value.categorie_nom}</b></td>
                                <td>${value.total_quantite} ${value.unite}</td>
                                <td>${value.total_total_vente} DA</td>
                            </tr>
                        `);
                        });
                    },
                    error: function(error) {
                        console.error('Erreur lors de l\'appel AJAX:', error);
                        Swal.fire({
                            title: "Erreur lors du filtrage",
                            text: "Veuillez réessayer.",
                            icon: "error",
                            showConfirmButton: true,
                        });
                    },
                });
            } catch (error) {
                console.error('Erreur dans FiltrerData:', error);
            }




            // try {
            //     $.ajax({
            //         url: `/admin/calculs/stock/${id_magasin}/${formattedDate1}/${formattedDate2}/${filtreCase}`,
            //         type: 'GET',
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            //         },
            //         success: function(response) {
            //             console.log('Réponse JSON:', response.resultats_magasin);

            //             // Sélection du conteneur pour afficher les données
            //             const DataContainer = $('#data');
            //             DataContainer.empty(); // Vidage du conteneur avant l'ajout des nouvelles données

            //             // Message de succès après activation du filtre
            //             Swal.fire({
            //                 title: "Filtre Activé",
            //                 icon: "success",
            //                 showConfirmButton: false,
            //                 timer: 1000,
            //             });

            //             // Vérification des données dans la réponse
            //             if (!response.resultats_magasin || response.resultats_magasin.length === 0) {
            //                 Swal.fire({
            //                     title: "Aucun résultat trouvé",
            //                     icon: "info",
            //                     showConfirmButton: false,
            //                     timer: 1000,
            //                 });
            //                 return; // Arrêt si aucune donnée n'est trouvée
            //             }

            //             // Affichage des données dans le tableau
            //             response.resultats_magasin.forEach(value => {
            //                 DataContainer.append(`
        //     <tr>
        //         <td><b>${value['categorie']}</b></td>
        //         <td><b>${value['produit']}</b></td>
        //         <td>${value['quantite_transferee'] || 0}</td> <!-- Si vide, afficher 0 -->
        //         <td>${value['stock'] || 0}</td> <!-- Si vide, afficher 0 -->
        //         <td>${value['quantite_vendue'] || 0}</td> <!-- Si vide, afficher 0 -->
        //         <td>${value['quantite_retour'] || 0}</td> <!-- Si vide, afficher 0 -->
        //         <td>${value['quantite_difference'] || 0}</td> <!-- Si vide, afficher 0 -->
        //     </tr>
        // `);
            //             });
            //         },
            //         error: function(error) {
            //             console.error('Erreur lors de l\'appel AJAX:', error);
            //             Swal.fire({
            //                 title: "Erreur lors du filtrage",
            //                 text: "Veuillez réessayer.",
            //                 icon: "error",
            //                 showConfirmButton: true,
            //             });
            //         },
            //     });
            // } catch (error) {
            //     console.error('Erreur dans FiltrerData:', error);
            //     Swal.fire({
            //         title: "Erreur",
            //         text: "Une erreur est survenue. Veuillez réessayer.",
            //         icon: "error",
            //         showConfirmButton: true,
            //     });
            // }

            // $.ajax({
            //     url: `/admin/calculs/stock/${id_magasin}/${formattedDate1}/${formattedDate2}/${filtreCase}`,
            //     type: 'GET',
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            //     },
            //     success: function(response) {
            //         if (response.magasin) {
            //             console.log('Magasin:', response.magasin);
            //         } else {
            //             console.log('Aucun magasin trouvé');
            //         }
            //     },
            //     error: function(error) {
            //         console.error('Erreur lors de l\'appel AJAX:', error);
            //     }
            // });


        }
    </script>




    {{-- --------------------------------------------------------------------------------------------------------------------------------- --}}

    {{-- footer  --}}
    <div class="container" id="pied-page">
    @endsection

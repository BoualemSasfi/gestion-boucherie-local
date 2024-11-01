@extends('layouts.admin')
@section('content')
    <style>
        .hr-white {
            border: none;
            border-top: 2px dashed white;
            height: 0;
            margin: 10px 0;
        }
    </style>


    <div class="container-fluid">
        <h2>Etat des Caisses :</h2>
        <div class="row" id="caisses-display">

            {{-- affichage caisses --}}

        </div>
    </div>


    <script>
        // Fonction à exécuter
        function EtatCaisses() {
            console.log("La fonction est exécutée!");

            $.ajax({
                url: '/admin/argent',
                type: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Liste des classes de fond
                    const bgClasses = ["bg-primary", "bg-secondary", "bg-success", "bg-danger", "bg-warning",
                        "bg-dark"
                    ];

                    $('#caisses-display').empty();
                    $.each(response.caisses, function(index, value) {
                        // Assigner une couleur fixe en utilisant l'index
                        const fixedClass = bgClasses[index % bgClasses.length];

                        $('#caisses-display').append(
                            '<div id="caisse-item" class="col-xs-12 col-sm-6 col-md-3 col-lg-3">' +
                            '<div id="caisse-card" class="caisse-items ' + fixedClass +
                            ' rounded text-center text-white m-2 shadow-lg m-3">' +
                            '<i class="fas fa-cash-register fa-lg" style="font-size: 30px; text-align: center; padding-top: 30px; padding-bottom: 10px;"></i>'+
                            '<h4 class="p-2">' + value.magasin_nom + '</h4>' +
                            '<h4 class="p-2">' + value.caisse_titre + '</h4>' +
                            '<hr class="hr-white">' +
                            // '<h5 class="pt-2">FOND :</h5>' +
                            // '<h3 class="pt-2 pb-3 fw-bold">' + value.caisse_fond + '</h3>' +
                            '<h5 class="pt-2">SOLDE :</h5>' +
                            '<h3 class="pt-2 fw-bold">' + value.caisse_solde + '</h3>' +
                            '<h5 class="pt-1 pb-3 fw-bold">DZD</h5>' +
                            '</div>' +
                            '</div>'
                        );
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });




        }

        // Exécuter la fonction au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            EtatCaisses(); // Exécution immédiate au chargement
            // Exécuter la fonction chaque minute (60 000 millisecondes)
            setInterval(EtatCaisses, 2000);
        });
    </script>
@endsection

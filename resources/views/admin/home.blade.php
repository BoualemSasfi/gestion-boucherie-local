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
        <h1>Etat des Caisses :</h1>
        <div class="row">
            
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
                
                <div class="caisse  bg-primary rounded text-center text-white m-2 shadow-lg h-auto w-auto m-3">
                    <h3 class="pt-3 pb-1">NOM MAGASIN</h3>
                    {{-- <hr class="hr-white"> --}}
                    <h3 class="pt-1 pb-1">CAISSE N° 1</h3>
                    <hr class="hr-white">
                    <h3 class="pt-1">SOLDE :</h3>
                    <h4 class="pt-3 pb-3 fw-bold">231000 DZD</h4>
                </div>

            </div>

        </div>
    </div>


    <script>
// Fonction à exécuter
function EtatCaisses() {
    console.log("La fonction est exécutée!");
    // Ajoute ici le code que tu souhaites exécuter
}

// Exécuter la fonction au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    EtatCaisses(); // Exécution immédiate au chargement
    // Exécuter la fonction chaque minute (60 000 millisecondes)
    setInterval(EtatCaisses, 10000);
});

    </script>

@endsection

@extends('layouts.admin')
@section('content')
<style>
    .hr-white {
        border: none;
        border-top: 2px dashed white;
        height: 0;
        margin: 10px 0;
    }

    .mini-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<div class="container-fluid">
    <h2>Etat des Caisses :</h2>
    <!-- Affichage des messages de session -->
    @if(session('success'))
        <div id="alert-message" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div id="alert-message" class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row" id="caisses-display">
        {{-- Contenu des caisses ajouté dynamiquement par JavaScript --}}
    </div>
</div>
<script>
    // Fonction pour récupérer et afficher les caisses
    function EtatCaisses() {
        console.log("Exécution de la fonction EtatCaisses");
        $.ajax({
            url: '/admin/argent',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                // Liste des classes de fond
                const bgClasses = ["bg-primary", "bg-secondary", "bg-success", "bg-danger", "bg-warning", "bg-dark"];

                // Vider le conteneur avant de le remplir
                $('#caisses-display').empty();

                // Ajouter les données reçues
                $.each(response.caisses, function (index, value) {
                    const fixedClass = bgClasses[index % bgClasses.length];
                    $('#caisses-display').append(`
                        <div id="caisse-item" class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                            <div id="caisse-card" class="caisse-items ${fixedClass} rounded text-center text-white m-2 shadow-lg m-3">
                                <i class="fas fa-cash-register fa-lg" style="font-size: 30px; text-align: center; padding-top: 30px; padding-bottom: 10px;"></i>
                                <h4 class="p-2 mini-text">${value.magasin_nom}</h4>
                                <h4 class="p-2 mini-text">${value.caisse_titre}</h4>
                                <hr class="hr-white">
                                <h5 class="pt-2">SOLDE :</h5>
                                <h3 class="pt-2 fw-bold">${value.caisse_solde}</h3>
                                <h5 class="pt-1 pb-3 fw-bold">DZD</h5>
                            </div>
                        </div>
                    `);
                });
            },
            error: function (xhr, status, error) {
                console.error("Erreur lors de la récupération des caisses :", error);
            }
        });
    }
    // Fonction pour masquer les messages d'alerte après 3 secondes
    function hideAlertAfterDelay() {
        const alertMessage = document.getElementById('alert-message');
        if (alertMessage) {
            setTimeout(() => {
                alertMessage.classList.remove('show'); // Masque l'alerte visuellement
                alertMessage.classList.add('fade');   // Ajoute un effet de disparition
            }, 3000); // 3000 millisecondes = 3 secondes
        }
    }
    // Exécuter la fonction au chargement de la page et périodiquement
    document.addEventListener('DOMContentLoaded', function () {
        EtatCaisses(); // Chargement initial
        hideAlertAfterDelay(); // Cache les messages d'alerte après 3 secondes
        setInterval(EtatCaisses, 60000); // Mise à jour toutes les 60 secondes
    });
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
@endsection
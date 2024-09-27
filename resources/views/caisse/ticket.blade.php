<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TICKET DE CAISSE</title>
</head>

<body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Attente avant de lancer l\'impression');
            setTimeout(function() {
                window.print();
            }, 5000); // Attendre 1 seconde
        });
    </script>

    <div class="container">

        <div class="facture part">
            {{-- <img class="barcode" src="{{ $barcodePath }}" alt="CODE BARRES"> --}}
            <h5 id="code">Ticket N°: {{ $num_facture }} <span id="etat">Etat-Facture: {{ $etat_facture }}</span> </h5>
            <h5 id="vendeur">Vendeur: {{ $vendeur }}</h5>
            <h5 id="magasin">Magasin: {{ $magasin }} Caisse: {{ $caisse }}</h5>
            <h5 id="date">Date et Heure: {{ $date_facture }}</h5>
            <h5 id="client">Client: {{ $client }}</h5>
        </div>

        <div class="ventes part">
            <table>
                <tr>
                    <th>Designation:</th>
                    <th>Qte:</th>
                    <th>Prix u:</th>
                    <th>Total:</th>
                </tr>
                @foreach ($ventes as $vente)
                    <tr>
                        <td>{{ $vente->nom_produit }} </td>
                        <td>{{ $vente->quantite }} </td>
                        <td>{{ $vente->prix_produit }} </td>
                        <td>{{ $vente->prix_total }} </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="resume part">
            <h5 id="total">Total: {{ $total }} DA</h5>
            <h5 id="versement">Versement: {{ $versement }} DA</h5>
            <h5 id="credit">Crédit: {{ $credit }} DA</h5>
        </div>

        <div class="message part">
            <h6>Merci pour votre visite<br>à bientôt</h6>
        </div>
    </div>

    {{-- CSS  --}}
    <style>
        body {
            margin: 0;
            padding: 0;
            font-size: 14px;
        }

        .container {
            margin: 0;
            padding: 0;
        }

        .part {
            margin-top: 20px;
        }

        .barcode {
            width: 100%;
            height: 25px;
        }
    </style>



    {{-- <script>
    window.onload = function() {
        window.print(); // Lancer l'impression automatiquement
    }
</script> --}}

    {{-- <script>
setTimeout(function() {
    window.print();
}, 1000);
</script> --}}

    {{-- <script>
    function imprimerPDF() {
    window.print(); // Lancer l'impression
}

window.onload = function() {
    imprimerPDF(); // Appeler la fonction d'impression
};
</script> --}}

</body>

</html>

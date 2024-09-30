<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TICKET DE CAISSE</title>
</head>

<body>
    <div class="container">
        <h2 id="ticket-titre">{{ $informations->nom_entr }}</h2>
        <div class="facture part">
            <div class="cell">
                <h5 id="code">Ticket N°: <br> {{ $num_facture }}</h5>
            </div>
            <div class="cell">
                <h5 id="code-barres">CODE BARRES</h5>
            </div>
            <div class="cell">
                <h5 id="vendeur">Vendeur: <br> {{ $vendeur }}</h5>
            </div>
            <div class="cell">
                <h5 id="magasin">Magasin: {{ $magasin }} <br> Caisse: {{ $caisse }}</h5>
            </div>
            <div class="cell">
                <h5 id="date">Date et Heure: <br> {{ $date_facture }}</h5>
            </div>
            <div class="cell">
                <h5 id="client">Client: <br> {{ $client }}</h5>
            </div>
        </div>
        <div class="ventes part">
            <hr>
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
                        <td><b>{{ $vente->prix_total }}</b></td>
                    </tr>
                @endforeach
            </table>
            <hr>
        </div>
        <div class="resume part">
            <h5 id="total">Total: {{ $total }} DA</h5>
            <h5 id="versement">Versement: {{ $versement }} DA</h5>
            <h5 id="credit">Crédit: {{ $credit }} DA</h5>
        </div>
        <div class="message part">
            <h5>Merci pour votre visite<br>à bientôt</h5>
        </div>
    </div>

    <style>
        html {
            margin: 20px;
            padding: 0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-size: 14px;
            line-height: 0.5cm;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            margin: 0;
            padding: 0;
        }

        .part {
            background-color: rgb(214, 250, 69);
        }

        .barcode {
            width: 100%;
            height: 25px;
        }

        .resume {
            text-align: right;
            font-size: 18px;
        }

        .facture {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 colonnes */
            gap: 0; /* Pas d'espacement */
            background-color: rgb(39, 231, 39);
            width: 260px; /* Largeur du ticket */
        }
        
        .cell {
            background-color: rgb(53, 53, 242);
            border: 1px solid rgb(0, 0, 0);
            text-align: center;
            padding: 0;
            height: 80px; /* Hauteur de la cellule */
            width: 130px; /* Largeur du ticket */
        }

        #ticket-titre {
            text-align: center;
        }

        td {
            padding: 3px;
        }

        .message {
            font-family: 'Courier New', Courier, monospace !important;
            text-align: center;
        }
    </style>

</body>

</html>

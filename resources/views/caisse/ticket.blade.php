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
            {{-- <div class="cell" id="cell-1">
                <h5 id="code">Ticket N° : {{ $num_facture }}</h5>
            </div> --}}
            <div class="cell" id="cell-2">
                {{-- <h5 id="code-barres">CODE BARRES</h5> --}}
                <img src="{{ $barcodePath }}" alt="">
                <h5>{{ $code_barres_facture }}</h5>
            </div>
            <div class="cell" id="cell-5">
                <h5 id="date">Date et Heure : {{ $date_facture }}</h5>
            </div>
            <div class="cell" id="cell-6">
                <h5 id="client">Client : {{ $client }}</h5>
            </div>
        </div>
        <div class="ventes part">
            <hr class="dashed-hr">
            <table>
                <tr>
                    <th class="designation">Designation :</th>
                    <th class="prix">Prix :</th>
                    <th class="prix_total">Total :</th>
                </tr>
                @foreach ($ventes as $vente)
                    <tr>
                        <td class="designation">{{ $vente->nom_categorie }}:{{ $vente->nom_produit }} <br> x
                             {{ $vente->quantite == (int) $vente->quantite ? (int) $vente->quantite : $vente->quantite }} 
                             {{ $vente->unite_mesure }}
                            </td>
                        <td class="prix">{{ $vente->prix_produit }} </td>
                        <td class="prix_total"><b>{{ $vente->prix_total }}</b></td>
                    </tr>
                @endforeach
            </table>
            <hr class="dashed-hr">
        </div>
        <div class="resume part">
            <h5 id="total">Montant Total : {{ $total }} DA</h5>
            <h5 id="versement">Versement : {{ $versement }} DA</h5>
            <h5 id="credit">Crédit : {{ $credit }} DA</h5>
        </div>

        <div class="facture part">
            <hr class="dashed-hr">
            <div class="cell" id="cell-3">
                <h5 id="vendeur">Vendeur : {{ $vendeur }}</h5>
            </div>
            <div class="cell" id="cell-4">
                <h5 id="magasin">Magasin : {{ $magasin }} | Caisse : {{ $caisse }}</h5>
            </div>
            <hr class="dashed-hr">
        </div>


        <div class="message part">
            <h5>Merci pour votre visite<br>à bientôt</h5>
        </div>
    </div>

    <style>
        html {
            margin: 10px;
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
            margin: 0;
        }

        .barcode {
            width: 100%;
            height: 35px;
        }

        .resume {
            text-align: right;
            font-size: 16px;
        }

        .resume h5 {}

        .facture {
            /* display: grid; */
            /* grid-template-columns: repeat(1, 1fr); */
            /* gap: 0; */
            margin-top: 5px;
            margin-bottom: 5px;
            width: 100%;
        }

        .cell {
            text-align: center;
            padding: 0;
            margin: 0;
            width: 100%;
        }

        .cell h5 {}

        #ticket-titre {
            text-align: center;
        }

        table{
            padding: 0;
            margin: 0;
        }

        td {
            padding: 2px;
        }

        th {
            font-size: 13px;
            text-align: left;
        }

        tr {
            /* display: grid; */
            /* grid-template-columns: repeat(3, 1fr); */
            /* gap: 0; */
            width: 100%;
        }
        .designation{
            width: 130px;
            margin-left: 0;
            padding-left: 0;
        }
        .prix{
            width:70px;
            text-align: center;
        }
        .prix_total{
            width:75px;
            text-align: center;
        }

        .message {
            font-family: 'Courier New', Courier, monospace !important;
            text-align: center;
        }

        h5 {
            margin: 0;
        }

        .dashed-hr {
            border: none;
            border-top: 1px dashed #000;
            height: 0;
            margin: 10px 0;
        }

        .ventes {
            padding: 0;
            margin: 0;
        }
    </style>

</body>

</html>

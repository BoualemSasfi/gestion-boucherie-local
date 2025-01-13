<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BON DE VERSEMENT</title>
</head>

<body>
    <div class="container">
        <!-- Informations de l'entreprise et magasin -->
        <div class="header">
            <h2 id="ticket-titre">{{ $informations->nom_entr }}</h2>
        </div>
        
        
        <!-- Détails du bon de versement -->
        <div class="ventes part" style="width: 100%;">
            <hr class="dashed-hr">
            <h1 id="ticket-titre">BON DE VERSEMENT</h1>
            <hr class="dashed-hr">
            <h3 id="ticket-titre">Client : {{ $client->nom_prenom }}</h3>
            <h3 id="ticket-titre">Versement : {{ number_format($versement->montant, 2, ',', ' ') }} </h3> <!-- Formatage du montant -->
            <h3 id="ticket-titre">Reste Crédit : {{ number_format($credit->total_credit, 2, ',', ' ') }} </h3> <!-- Formatage du montant -->
            <hr class="dashed-hr">
        </div>

        <!-- Message de remerciement -->
        <div class="message part">
            <h5>Merci pour votre visite<br>À bientôt</h5>
        </div>
    </div>

    <style>
        html {
            margin: 0;
            padding: 0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-size: 14px;
            line-height: 1.5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            margin: 0;
            padding: 0;
        }

        .part {
            margin: 0;
        }

        .resume {
            text-align: right;
            font-size: 16px;
        }

        .facture {
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

        table {
            padding: 0;
            margin: 0;
            width: 100%;
        }

        td {
            padding: 2px;
        }

        th {
            font-size: 13px;
            text-align: left;
        }

        tr {
            width: 100%;
        }

        .designation {
            margin-left: 0;
            padding-left: 0;
        }

        .prix {
        }

        .prix_total {
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

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .message h5 {
            font-size: 16px;
            margin-top: 20px;
        }
    </style>
</body>

</html>

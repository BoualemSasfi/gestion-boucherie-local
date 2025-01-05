facture

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>facteur de paiement</title>

    <!-- icon -->
    <link href="{{ asset('ifma_icon.ico') }}" rel="icon" type="image/x-icon">

    <style>
        /* appel aux fonts locals  */

        @font-face {
            font-family: 'Poppins';
            src: url('{{ public_path(' /fonts/Poppins/Poppins-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins-Bold';
            src: url('{{ public_path(' /fonts/Poppins/Poppins-ExtraBold.ttf') }}') format('truetype');
            font-weight: bold;
            font-style: bold;
        }


        @font-face {
            font-family: 'Cairo';
            src: url('{{ public_path(' fonts/Cairo/Cairo-Bold.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }


        @font-face {
            font-family: 'Alexandria';
            src: url('{{ public_path(' fonts/Alexandria/Alexandria-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            direction: rtl;
        }

        @font-face {
            font-family: 'Alice';
            src: url('{{ public_path(' fonts/Alice/Alice-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            direction: rtl;
        }

        @font-face {
            font-family: 'Great-Vibes';
            src: url('{{ public_path(' fonts/great-vibes/GreatVibes-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            direction: rtl;
        }


        @font-face {
            font-family: 'Roboto';
            src: url('{{ public_path(' fonts/Roboto/Roboto-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            direction: rtl;
        }

        /* fin d'appel aux fonts locals  */
    </style>

    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {}

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            /* padding: 4px; */
        }

        th {
            background-color: #f2f2f2;
        }

        tr {
            padding: 0;

        }

        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        .logo {
            width: 120px;
            height: 100px;
            margin-right: 20px;
            display: inline-block;
            /* background-color: rgb(59, 59, 59); */
        }

        .title {
            font-size: 21px;
            font-weight: bold;
            color: #333;
            margin-top: 0px;
            text-align: center;
        }

        .sous_titre {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .date {
            text-align: right;
            margin-top: 1px;
            margin-right: 10px;
            font-size: 14px;
            color: #555;
        }

        .info {
            padding: 5px;
            margin-top: 20px;
        }

        .infocontact {
            text-align: center;
            font-size: 8px;
            color: rgb(23, 23, 109);
        }

        .info label {
            font-weight: bold;
            display: block;
            font-size: 14px;
        }

        .amount-container {
            text-align: right;
            margin-top: 1px;
        }

        .amount {
            font-size: 24px;
            font-weight: bold;
            /* background-color: #333; */
            color: #333;
            padding: 10px 20px;
            /* display: inline-block; */
        }

        .footer {
            /* position: absolute; */
            bottom: 1cm;
            width: 100%;
        }

        .contact-info {
            font-size: 14px;
            color: #555;
            text-align: center;
            margin-top: 10px;
        }

        .okok {
            font-family: Arial, sans-serif;
            width: 19cm;
            height: auto;
            margin: 0.5cm;
            padding: 0.4cm;
            /* box-sizing: border-box; */
            /* background-color: #cdefd887; */
            border: 2px solid #ccc;
        }

        .container {
            width: 100%;
            height: 10%;
            overflow: auto;
       
        }
        .t{
         font-size: 12px;
        }


        div.container div {
            width: 33%;
            float: left;
        }



        .alig {
            display: flex;
            justify-content: space-between;
        }

        .container01 {
            width: 100%;
            height: 5%;
            overflow: auto;
            margin-bottom: 5px;

        }


        div.container01 div {
            width: 60%;
            float: left;
        }

        .div2 {
            padding-left: 10px;
        }
    </style>





</head>


<body>
    <div class="okok">
        <div class="container">
            <div>
                <img class="logo" src="{{ public_path('storage/' . $informations->logo) }}" alt="Logo okok">
            </div>
            <div style=" padding-top: 20px; padding-bottom: 0; margin-bottom: 0;  text-align: center;">
                <label class="title">
                    <!-- Boucherie Djurdjura -->
                    <!-- {{$informations->nom_entr}} -->
                </label>
                <br>
                <label class="title">
                       Bon de paiement
                </label>
                <br>
            </div>
            <div class="date" style="float: right; width: auto;">
                <span id="date-valeur">{{ $date }}</span>

                <h4>
                    <img src="{{ $barcodePath }}" alt="">
                    <br>
                   N° 00001/2024
                    <!-- {{$facture->code_facture}} -->

                </h4>

            </div>
        </div>


        <div class="container01">

            <div class="div2">
                <h5 class="">
                    @foreach ($clients as $client)
                        @if ($client->id == $facture->id_client)
                            Client : {{$client->nom_prenom}}
                            <br>

                        @endif
                    @endforeach

                    @php
                        $totalCredit = 0;
                    @endphp
                    @foreach ($credits as $credit)
                                    @if ($credit->id_client == $facture->id_client)
                                                    @php
                                                        $totalCredit += $credit->credit;
                                                    @endphp
                                    @endif
                    @endforeach

                    @if ($totalCredit != 0)
                        Total crédit client : {{ $totalCredit }}.00 DA

                    @endif
                </h5>
                <h5>
                </h5>
            </div>
        </div>

        <div class="container-fluid" style="padding-top:2px;padding-bottom:2px;">
            <div class="row">
                <div class="col-md-12">
                    <table id="example" class="table table-bordered" style="width:100%">
                        
                        <thead>
                            <tr class="t" >
                                <th>Categorie</th>
                                <th>Produit</th>
                                <th>PU</th>
                                <th>Q</th>
                                <th>TOTAL </th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($listes as $liste)
                                <tr class="t" >
                                    <td class=" align-middle">{{ $liste->categorie}}</td>
                                    <td class=" align-middle">{{ $liste->produit}}</td>
                                    <td class=" align-middle">{{ $liste->PU}} DA</td>
                                    <td class=" align-middle">{{ $liste->Q}}</td>
                                    <td class=" align-middle">{{ $liste->total}} DA</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <div class="row">
                    <div class="col-8 ">

                    </div>
                    <!-- <div class="col-4 ">
                        <H4>TOTAL HT : <span style="float: right;">{{$facture->total_facture}} DA </span> </H4>
                        <H4>TOTAL TVA :<span style="float: right;">0.00 DA</span> </H4>
                        <H4>TOTAL TTC :<span style="float: right;">{{$facture->total_facture}} DA </span></H4>
                    </div> -->
                    <!-- <H3>Total facteur : <span style="float: right;"> {{$facture->total_facture}} DA </span> </H3> -->
                </div>
            </div>
        </div>

        <div class="alig">

            <div class="amount-container">
                <h5>
                    Total : {{$facture->total_facture}} DA
                    <br>
                    Versement : {{$facture->versement}} DA
                    <br>
                    Credit facture: {{$facture->credit}} DA

                </h5>

                <!-- <h5>Versement : <span class="amount">{{$facture->versement}} DA </span></h5>
                <h5>credit : <span class="amount">{{$facture->credit}} DA </span></h5> -->
            </div>

        </div>

        <div style="margin-top: 2px; left: -10;">
        </div>
</body>

</html>
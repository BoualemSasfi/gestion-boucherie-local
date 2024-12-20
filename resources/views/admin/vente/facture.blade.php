<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factur de paiement</title>
</head>

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
        height: 60px;
        margin-right: 20px;
        display: inline-block;
        /* background-color: rgb(59, 59, 59); */
    }
</style>

<body>
    <div class="okok">
        <div class="container">
            <div class="section section1">
                <p>
                    <img class="logo" src="{{ asset('storage/' . $informations->logo) }}" alt="Logo">
                </p>
            </div>
            <div class="section section2">
                <p>
                    <label class="title">
                        EURL {{$informations->nom_entr}}
                    </label>
                    <br>
                    <label class="title">
                        Facture de paiement
                    </label>
                    <br>
                </p>
            </div>
            <div class="section section3">
                le : <span id="date-valeur">{{ $date }}</span>
                <p>

                <h4 style="text-align: center;">
                    Facture N° 00001/2024
                    <!-- {{$facture->code_facture}} -->
                    <br>
                    <span style="display: block; text-align: right; font-size: 14px;">
                        |||||||||||||||||||||||||||||||||||||||||||||||||||||||
                    </span>
                    <!-- {{$facture->code_barrres}} -->
                </h4>

                </p>
            </div>

        </div>




        <div class="contant">
            <div class="div01">
                <p>
                    @foreach ($magasins as $magasin)
                        @if ($magasin->id == $facture->id_magasin)
                            Nom : {{$magasin->nom}}
                            <br>
                            NRC : {{$magasin->N_reg}}
                            <br>
                            NIF : {{$magasin->N_reg}}
                            <br>
                            NIS : {{$magasin->N_reg}}
                            <br>
                            Adresse : {{$magasin->adresse}}
                            <br>
                            tel : {{$magasin->tel}}
                            <br>
                        @endif
                    @endforeach
                </p>
            </div>
            <div class="div02">
                <p>
                    @foreach ($clients as $client)
                        @if ($client->id == $facture->id_client)
                            Nom : {{$client->nom_prenom}}
                            <br>
                            NRC : {{$client->n_rc}}
                            <br>
                            NIF : {{$client->NIF}}
                            <br>
                            NIS : {{$client->NIS}}
                            <br>
                            Adresse : {{$client->adresse}}
                            <br>
                            Tel : {{$client->fix}}
                        @endif
                    @endforeach
                </p>
            </div>
        </div>



        <!--  -->

        <div class="container-fluid" style="padding-top:2px;padding-bottom:2px;">
            <div class="row">
                <div class="col-md-12">
                    <table id="example" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Categorie</th>
                                <th>Produit</th>
                                <th>PU</th>
                                <th>Q</th>
                                <th>TOTAL </th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($listes as $liste)
                                <tr>
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
                </div>
            </div>
        </div>

        <div class="alig">

            <div class="amount-container">
                <h4>Montant totale : <span class="amount">{{$facture->total_facture}} DA </span></h4>
            </div>

        </div>

        <div style="margin-top: 2px; left: -10;">
        </div>

</body>

</html>
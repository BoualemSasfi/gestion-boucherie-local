<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>IMAD EDDINE</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Inclure jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Custom fonts for this template-->
    <!-- <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">


    <!-- Inclure SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Inclure SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Custom styles for this template-->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">








    <!-- Styles -->
    <style>
        /* From Uiverse.io by alexruix */
        .card {
            width: 250px;
            height: 254px;
            border-radius: 20px;
            background: #f5f5f5;
            position: relative;
            padding: 1.8rem;
            border: 2px solid #c3c6ce;
            transition: 0.5s ease-out;
            overflow: visible;
        }

        .card-details {
            color: black;
            height: 100%;
            gap: .5em;
            display: grid;
            place-content: center;
        }

        .card-button {
            transform: translate(-50%, 125%);
            width: 60%;
            border-radius: 1rem;
            border: none;
            background-color: #008bf8;
            color: #fff;
            font-size: 1rem;
            padding: .5rem 1rem;
            position: absolute;
            left: 50%;
            bottom: 0;
            opacity: 0;
            transition: 0.3s ease-out;
        }

        .text-body {
            color: rgb(134, 134, 134);
        }

        /*Text*/
        .text-title {
            font-size: 1.5em;
            font-weight: bold;
        }

        /*Hover*/
        .card:hover {
            border-color: #008bf8;
            box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.25);
        }

        .card:hover .card-button {
            transform: translate(-50%, 50%);
            opacity: 1;
        }

        .clove:hover {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="container">

            <div class="row">
                @foreach ($caisses as $caisse)
                    <div class="col-3">
                        <form class="affiche-form" action="{{'/magasin/'. $id_magasin . '/caisse/' . $caisse->id }}" method="GET">
                            @csrf

                            <div class="card clove" onclick="this.closest('form').submit();">
                                <div class="card-details">
                                    <p class="text-title">{{$caisse->code_caisse}}</p>

                                </div>

                            </div>

                    </form>
                    </div>
                @endforeach

            </div>


        </div>


    </div>
</body>

</html>
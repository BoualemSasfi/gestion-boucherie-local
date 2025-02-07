<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    


    <title>{{ config('app.name', 'Laravel') }}</title>


    {{-- fontawesome css --}}
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom fonts for this template-->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    {{-- local  --}}
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/caisse.css') }}" rel="stylesheet">
    <link href="{{ asset('css/paccino.css') }}" rel="stylesheet">



    {{-- bootstrap css --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- bootstrap js  --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>



    {{-- AOS animations css --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    {{-- AOS animations js --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>



    <!-- Inclure SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Inclure SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- data tables  --}}
    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/searchpanes/2.3.3/css/searchPanes.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/staterestore/1.4.1/css/stateRestore.bootstrap5.min.css" rel="stylesheet">
     
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.3.3/js/dataTables.searchPanes.min.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.3.3/js/searchPanes.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/staterestore/1.4.1/js/dataTables.stateRestore.min.js"></script>
    <script src="https://cdn.datatables.net/staterestore/1.4.1/js/stateRestore.bootstrap5.min.js"></script>


</head>

<body id="page-top">

    <script>
        AOS.init();
    </script>


    <!-- Page Wrapper -->
    <div id="wrapper">



        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-1 static-top shadow">


                    {{-- <div class="nav-item" style="">
                        <button class="btn btn-success" onclick="OpenCashDrawer()"
                            style="height: 100%;margin-left:20px;">Ouvrir la Caisse</button>
                    </div> --}}

                    {{-- <div class="nav-item" style="margin-left:20px;">
                        <button class="btn btn-primary" id="connectButton">Connecter la Balance</button>
                    </div> --}}



                    {{-- <div class="topbar-divider d-none d-sm-block"></div> --}}

                    <ul class="navbar-nav ms-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow mr-4">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="me-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                {{-- <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                                    Mon Profil
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>
                                    Settings
                                </a> --}}
                                {{-- <div class="dropdown-divider"></div> --}}
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>
                                    Déconnecter
                                </a>
                            </div>
                        </li>
                    </ul>


                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row m-0 p-0">

                        {{-- Contenu de la page --}}

                        {{-- @include('sweetalert::alert') --}}

                        @yield('content')


                        {{-- Contenu de la page --}}

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Voulez-vous vraiments quitter ?</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                    </button>

                </div>
                <div class="modal-body">Selectionner "Quitter" si vous voulez fermer votre session et quitter
                    l'application. <br> Si vous vouler rester clickez sur "Annuler".</div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" data-bs-dismiss="modal">Annuler</button>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="btn btn-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();">Quitter</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ---------------------------------------------------------- --}}

    {{-- Styles Bootstrap 5 --}}
    {{-- <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdn.datatables.net/scroller/2.0.4/css/scroller.dataTables.min.css" rel="stylesheet"> --}}


    {{-- Datatables --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/scroller/2.0.4/js/dataTables.scroller.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/plug-ins/1.11.5/i18n/French.json"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script> --}}

    {{-- Bootstrap JS --}}
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script> --}}



    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Slick JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>



    {{-- <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}

    <script>
        function OpenCashDrawer() {
            $.ajax({
                url: '/open-cash-drawer',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.message) {
                        console.log(response.message);
                    } else {
                        console.error("Erreur : Réponse inattendue.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Erreur lors de l'ouverture de la caisse :", xhr.responseText);
                }
            });
        }
    </script>
    

</body>

</html>

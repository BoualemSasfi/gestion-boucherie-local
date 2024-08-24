@extends('layouts.admin')
@section('content')
    {{-- retour en arrière  --}}
    <div class="container" id="titre-page">
        <div class="row">
            <div class="col-2 d-flex align-items-center">
                <a href="{{ url('/home') }}" class="btn btn-dark"><i class="fas fa-arrow-left pr-1"></i><span
                        class="btn-description">Retour</span></a>
            </div>
            <div class="col-10 d-flex align-items-center">
                <h2>Informations Générales</h2>
            </div>
        </div>
    </div>




    {{-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --}}

    <div class="container" style="margin-top: 10px;">

        <div class="row animate__animated animate__backInLeft">

            <div class="card shadow col-12">


                <div class="card-body">

                    <form class="edit-form" action="{{ url('/admin/information/' . $information->id . '/update') }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 droite">
                                <div class="row">
                                    <!-- nom de l'entreprise  -->
                                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <label for="">Nom de L'entreprise :</label>
                                        <input type="text" name="nom_entr" class="form-control"
                                            placeholder="Nom de l'entreprise" value="{{ $information->nom_entr }}">
                                    </div>
                                    <!-- fin   -->


                                    {{-- numérod de registre --}}
                                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <label for="">Numéro de registre :</label>
                                        <input type="text" name="N_registre" class="form-control"
                                            placeholder="numero de registre de commerce "
                                            value="{{ $information->N_registre }}">
                                    </div>
                                    {{-- fin --}}

                                    <!-- date de registre  -->
                                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <label for="">Date de registre :</label>
                                        <input type="date" name="date_registre" class="form-control"
                                            value="{{ $information->date_registre }}">
                                    </div>
                                    <!-- fin   -->
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 gauche">
                                <label for="">Logo :</label>
                                <div class="row">
                                    <!-- Afficher l'image -->
                                    @if (!empty($information->logo) && Storage::exists('public/' . $information->logo))
                                        <div class="col-8 mx-auto text-center">
                                            <img src="{{ asset('storage/' . $information->logo) }}"
                                                class="img-fluid rounded" alt=""
                                                style="height:auto; width:200px; margin-top: 5px;" id="preview2"
                                                onclick="triggerFileInput();">
                                        </div>
                                    @else
                                        <div class="col-8 mx-auto text-center">
                                            <img src="{{ asset('img/logo_vide/your_logo_here.JPG') }}"
                                                class="img-fluid rounded" alt=""
                                                style="height:auto; width:200px; margin-top: 5px;" id="preview2"
                                                onclick="triggerFileInput();">
                                        </div>
                                    @endif
                                    <input type="file" name="logo" id="validationLogoCouleurs" accept="image/*"
                                        style="display: none;" onchange="previewImage2();">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <!-- telephone  -->
                            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="">N° téléphone :</label>
                                <input type="text" name="tel" class="form-control " placeholder="N° telephone"
                                    value="{{ $information->tel }}">

                            </div>
                            <!-- fin  -->

                            <!-- email  -->
                            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="">E-Mail :</label>
                                <input type="text" name="email" class="form-control " placeholder="E-Mail"
                                    value="{{ $information->email }}">

                            </div>
                            <!-- fin  -->




                            <!-- adresse   -->
                            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="">Adresse :</label>
                                <input type="text" name="adresse" class="form-control" placeholder="Adresse"
                                    value="{{ $information->adresse }}">
                            </div>
                            <!-- fin  -->

                            <!-- map  -->
                            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                style="border: 1px solid #ccc; padding: 10px;">
                                <label for="">Localisation :</label>
                                <input type="text" name="map" class="form-control mb-2" placeholder="Localisation"
                                    value="{{ $information->map }}">

                                    <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12" data-aos="flip-right">
                                        <iframe style="border:0; width: 100%; height: 350px;" src="{{ $information->map }}"
                                            frameborder="0" allowfullscreen></iframe>
                                    </div>
                            </div>

                            <!-- fin  -->
                        </div>



                        <br>


                        <!-- boutton de sauvegarder  -->
                        <div class="form-group row justify-content-center text-center m-3">
                            <div class="col-6">
                                <button type="button" onclick="sauvegarder(this)"
                                    class="btn btn-success alpa p-2">
                                    <i class="fas fa-check fa-lg mr-2"></i><span
                                        class="btn-description">Enregistrer</span></button>
                            </div>
                            <div class="col-6">
                                <a class="btn btn-danger alpa p-2" href="{{ url('/home') }}">
                                    <i class="fas fa-times fa-lg mr-2"></i><span
                                        class="btn-description">Annuler</span></a>
                            </div>
                        </div>

                        <!-- fin -->
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- pour affiche le logo  -->
    <script>
        function previewImage2() {
            var file = document.getElementById("validationLogoCouleurs").files;
            if (file.length > 0) {
                var fileReader = new FileReader();

                fileReader.onload = function(event) {
                    document.getElementById("preview2").setAttribute("src", event.target.result)
                };
                fileReader.readAsDataURL(file[0]);
            }
        };

        function triggerFileInput() {
            document.getElementById("validationLogoCouleurs").click();
        };
    </script>
    <!-- fin  -->

    {{-- script sauvegarder --}}
    <script>
        function sauvegarder(button) {
            // Utilisez le bouton pour obtenir le formulaire parent
            const form = button.closest('.edit-form');

            // Vérifiez si le formulaire a été trouvé
            if (form) {

                Swal.fire({
                    title: "Voulez- vous sauvegarder les modifications ? ",
                    // text: name,
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#198754",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Oui",
                    cancelButtonText: "Non",
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            } else {
                console.error("Le formulaire n'a pas été trouvé.");
            }
        }
    </script>
    <!-- fin -->
@endsection

@extends('layouts.admin')
@section('content')


<div class="container" id="titre-page">

    <div class="row justify-content-center">


        <div class="col-8  text-center">
            <h2>Informations </h2>
        </div>

        <div class="card-body">

            <form class="edit-form" action="{{ url('/admin/information/' . $information->id . '/update') }}"
                method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">

                    <!-- nom de l'entreprise  -->
                    <div class="form-group  col-12 col-md-6">
                        <label for="">Nom de L'entreprise:</label>
                        <input type="text" name="nom_entr" class="form-control" placeholder="Nom de l'entreprise"
                            value="{{ $information->nom_entr }}"></input>
                    </div>
                    <!-- fin   -->

                    {{-- numérod de registre --}}
                    <div class="form-group  col-12 col-md-4">
                        <label for="">Numéro de registre</label>
                        <input type="text" name="N_registre" class="form-control"
                            placeholder="numero de registre de commerce " value="{{ $information->N_registre}}"></input>
                    </div>
                    {{-- fin --}}

                    <!-- date de registre  -->
                    <div class="form-group  col-md-2">
                        <label for="">Date de registre </label>
                        <input type="date" name="date_registre" class="form-control"
                            value="{{ $information->date_registre }}"></input>
                    </div>
                    <!-- fin   -->

                    <!-- telephone  -->
                    <div class="col-md-3 col-12  form-group">
                        <label for="">N° telephone :</label>
                        <input type="text" name="tel" class="form-control " placeholder="N° telephone"
                            value="{{ $information->tel }}"></input>

                    </div>
                    <!-- fin  -->

                    <!-- email  -->
                    <div class="col-12 col-md-3 form-group">
                        <label for="">E-Mail:</label>
                        <input type="text" name="email" class="form-control " placeholder="E-Mail"
                            value="{{ $information->email }}"></input>

                    </div>
                    <!-- fin  -->




                    <!-- adresse   -->
                    <div class="form-group col-12 col-md-6">
                        <label for="">Adresse:</label>
                        <input type="text" name="adresse" class="form-control" placeholder="Adresse"
                            value="{{ $information->adresse }}"></input>
                    </div>
                    <!-- fin  -->

                    <!-- map  -->
                    <div class="col-12 form-group" style="border: 1px solid #ccc; padding: 10px;">
                        <label for="">Localisation:</label>
                        <input type="text" name="map" class="form-control " placeholder="Localisation"
                            value="{{ $information->map }}"></input>
                    </div>

                    <div class="col-12 " data-aos="flip-right">
                        <iframe style="border:0; width: 100%; height: 350px;" src="{{ $information->map }}"
                            frameborder="0" allowfullscreen></iframe>
                    </div>
                    <!-- fin  -->

                    <!-- logo  -->
                    <div class="row justify-content-center">

                        <input type="file" name="logo" id="validationLogoCouleurs" accept="image/*"
                            style="display: none;" onchange="previewImage2();">

                        <!-- Afficher l'image -->
                        <div class="col-6 justify-content-center">

                            @if(!empty($information->logo) && Storage::exists('public/' . $information->logo))
                                <img src="{{ asset('storage/' . $information->logo) }}" class="img-fluid rounded" alt=""
                                    style="height:auto; width:350px; margin-top: 15px; margin-bottom: 15px;" id="preview2"
                                    onclick="triggerFileInput();">
                            @else
                                <img src="{{ asset('img/logo_vide/your_logo_here.JPG') }}" class="img-fluid rounded" alt=""
                                    style="height:auto; width:350px; margin-top: 15px; margin-bottom: 15px;" id="preview2"
                                    onclick="triggerFileInput();">
                            @endif
                        </div>
                    </div>

                    <!-- fin -->

                </div>
                <br>


                <!-- boutton de sauvegarder  -->
                <div class="form-group row justify-content-center text-center">
                    <div class="col-6">
                        <button type="button" onclick="sauvegarder(this)" class="btn btn-outline-success alpa shadow"><i
                                class="bi bi-check2"></i><span class="btn-description">Enregistrer</span></button>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-outline-danger alpa shadow" href="{{ '/home' }}"><i class="bi bi-x"></i><span
                                class="btn-description">Annuler</span></a>
                    </div>
                </div>

                <!-- fin -->
            </form>

        </div>
    </div>
</div>

<!-- pour affiche le logo  -->
<script>

    function previewImage2() {
        var file = document.getElementById("validationLogoCouleurs").files;
        if (file.length > 0) {
            var fileReader = new FileReader();

            fileReader.onload = function (event) {
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
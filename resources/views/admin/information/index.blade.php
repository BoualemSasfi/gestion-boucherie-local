@extends('layouts.admin')
@section('content')




<div class="container" id="titre-page">

    <div class="row">
        <div class="col-2 d-flex align-items-center">
            <a href="{{ url('/home') }}" class="btn btn-dark"><i class="bi bi-arrow-left"></i><span
                    class="btn-description">Retour</span></a>
        </div>

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
                    <div class="col-3 form-group">
                        <label for="">N° telephone :</label>
                        <input type="text" name="tel" class="form-control " placeholder="N° telephone"
                            value="{{ $information->tel }}"></input>

                    </div>
                    <!-- fin  -->

                    <!-- email  -->
                    <div class="col-3 form-group">
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
                    <div class="col-12 form-group">
                        <label for="">Localisation:</label>
                        <input type="text" name="map" class="form-control " placeholder="Localisation"
                            value="{{ $information->map }}"></input>
                    </div>
                    <!-- fin  -->




                    <!-- logo  -->
                    <div class="col-3 form-group">
                        <label for="">Logo </label>
                        <input type="file" name="logo" class="form-control " id="validationLogoCouleurs"
                            accept="image/*" onchange="previewImage2();" value="{{ $information->logo }}">
                        </input>


                    </div>
                    <!-- logo  -->

                    <div class="row">


                        <div class="col-6" style="text-align: center;">
                            <p>LOGO </p>
                            <!-- <img src="{{ asset('storage/' . $information->logo) }}"
                                class="img-fluid rounded" alt=""
                                style="height:auto; width:350px; margin-top: 15px;margin-bottom: 15px;" id="preview2"> -->
                       <img src="img/animal/jaja_cuisses.png"  style="height:auto; width:350px; margin-top: 15px;margin-bottom: 15px;" id="preview2" alt="">
                            </div>

                    </div>


                </div>
                <br>



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
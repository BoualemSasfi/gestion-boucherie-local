@extends('layouts.admin')
@section('content')

{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row d-flex justify-content-between align-items-center">
        <div class="col-2">
            <a href="{{ url('/admin/magasin') }}" class="btn btn-dark">
                <i class="fas fa-arrow-left pr-1"></i>
                <span class="btn-description"></span>
            </a>
        </div>
        <div class="col-8 text-center">
            <h2>Ajouter un nouveau magasin</h2>
        </div>
        <div class="col-2 text-right">

        </div>
    </div>

</div>


<div class="container" style="margin-top: 10px;">

    <div class="row animate__animated animate__backInLeft">

        <div class="card shadow col-12">

            <div class="card-body">

                <form class="edit-form" action="{{ url('/admin/magasin/add/save') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- @method('PUT') -->
                    <div class="row">
                        <div class="col-6">

                            <!-- nom de magasin  -->
                            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="">Nom de magasin :</label>
                                <input type="text" name="nom" class="form-control" placeholder="Nom de magasin"
                                    value="">
                            </div>
                            <!-- fin   -->

                            <!-- numero de registre de magasin  -->
                            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="">N° registre :</label>
                                <input type="text" name="N_reg" class="form-control" placeholder="Numero de registre"
                                    value="">
                            </div>
                            <!-- fin   -->

                            <!-- telephone de magasin  -->
                            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="">N° Telephone :</label>
                                <input type="number" name="tel" class="form-control" placeholder="Numéro telephone"
                                    value="">
                            </div>
                            <!-- fin   -->

                            <!-- Type de magasin  -->
                            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <select id="" name="type" class="form-control">
                                    <option value=""> selectionez le type </option>
                                    
                                    <option value="Magasin">magasin</option>
                                    <option value="Atelier">Atelier</option>
                                    <!-- <option value="Boucherier">boucherier </option>
                                    <option value="Volaillerie">volaillerie </option> -->
                                </select>
                            </div>
                            <!-- fin   -->
                        </div>

                        <!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 gauche"> -->


                        <!-- new code  -->

                     
                            <div class="col-6  text-center">
                                <!-- <label for="">Photo :</label> -->
                                <img src="{{ asset('img/logo_vide/your_photo.jpg') }}" class="img-fluid rounded" alt=""
                                    style="height:80%; width:100%; margin-top: 5px; cursor: pointer;" id="preview2"
                                    onclick="triggerFileInput();">
                            </div>
                        <!-- end  -->
                        <input type="file" name="photo" id="validationLogoCouleurs" accept="image/*"
                            style="display: none;" onchange="previewImage2();">
                    </div>
                    <div class="row">
                     <!-- adresse   -->
                     <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="">Adresse :</label>
                                <input type="text" name="adresse" class="form-control" placeholder="Adresse"
                                    value="">
                            </div>
                            <!-- fin  -->

                        <!-- map  -->

                        <!-- <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12"
                            style="border: 1px solid #ccc; padding: 10px;">
                            <label for="">Localisation :</label>
                            <input type="text" name="loca" class="form-control mb-2" placeholder="Localisation"
                                value="">



                     
                        
                                <div class=" col-xs-6 col-sm-6 col-md-6 col-lg-6" data-aos="flip-right">
                                    <iframe style="border:0; width: 100%; height: 350px;"
                                        src="{{ asset('img/logo_vide/map.png') }}" frameborder="0" allowfullscreen></iframe>
                                </div>
                          
                    
 
                        </div> -->

                        <!-- fin  -->
                    </div>



                    <br>


                    <!-- boutton de sauvegarder  -->
                    <div class="form-group row justify-content-center text-center m-3">
                        <div class="col-6">
                            <button type="button" onclick="sauvegarder(this)" class="btn btn-success p-2">
                                <i class="fas fa-check fa-lg mr-2"></i><span
                                    class="btn-description">Enregistrer</span></button>
                        </div>
                        <div class="col-6">
                            <a class="btn btn-danger p-2" href="{{ url('/admin/magasin') }}">
                                <i class="fas fa-times fa-lg mr-2"></i><span class="btn-description">Annuler</span></a>
                        </div>
                    </div>

                    <!-- fin -->
                </form>

            </div>
        </div>
    </div>
</div>

<!-- pour affiche la photo   -->
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
                title: "Voulez- vous les modification sauvegarder  .. ? ",
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
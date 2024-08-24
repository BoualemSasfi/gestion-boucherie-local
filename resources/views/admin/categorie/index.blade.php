@extends('layouts.admin')
@section('content')
<section class="my-1">
    <div class="container" id="titre-page">
        <div class="row">
            <div class="col-2 d-flex align-items-center">
                <a href="{{ url('/home') }}" class="btn btn-dark"><i class="bi bi-house"></i><span
                        class="btn-description">Acceuil</span></a>
            </div>
            <div class="col-8  text-center">
                <h2>Catégories</h2>
            </div>
            <div class="col-2 d-flex align-items-center">
                <a href="{{ url('/admin/category/add') }}" class="btn btn-success"><i
                        class="fa-solid fa-plus fa-beat-fade"></i><span class="btn-description">Ajouter </span></a>

            </div>
        </div>
    </div>





    <div class="container">

        <div class="row">
            @foreach ($categorys as $category)


                <div class="col-m-3 col12 m-2">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="{{asset('storage/' . $category->photo)}}" alt="Card image cap">
                        <div class="card-body">
                            <h3 class="text-center">{{$category->nom}}</h3>
                        </div>


                        <div class="form-group row justify-content-center text-center">

                            <!-- button modifier -->
                            <div class="col-6">
                                <form class="edit-form" action="" data-id="{{ $category->id }}"
                                    data-name="{{ $category->nom }}" method="put">
                                    @csrf
                                    <button type="button" onclick="edit_confirmation(this)"
                                        class="btn btn-outline-warning alpa shadow" style="margin-bottom: 5px;"><i
                                            class="bi bi-pen"></i> <span class="btn-description">Modifier</span></button>
                                </form>
                            </div>
                            <!-- fin -->

                            <!-- bouton supprimer  -->
                            <div class="col-6">

                                {{-- delete button --}}
                                <form class="delete-form" action="" data-id="{{ $category->id }}"
                                    data-name="{{ $category->titre }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="supprimer_confirmation(this)"
                                        class="btn btn-outline-danger alpa shadow"><i class="bi bi-trash3"></i> <span
                                            class="btn-description">Supprimer</span></button>
                                </form>

                            </div>
                            <!-- fin -->

                        </div>


                    </div>
                </div>

            @endforeach


        </div>
    </div>





</section>



        {{-- script suppression  --}}
        <script>
          function supprimer_confirmation(button) {
              // Utilisez le bouton pour obtenir le formulaire parent
              const form = button.closest('.delete-form');

              // Vérifiez si le formulaire a été trouvé
              if (form) {
                  // Utilisez le formulaire pour extraire l'ID
                  const id = form.dataset.id;
                  const name = form.dataset.name;

                  Swal.fire({
                      title: "Êtes-vous sûr(e) de vouloir supprimer cette catégorie ..?",
                      text: name,
                      icon: "question",
                      showCancelButton: true,
                      confirmButtonColor: "#198754",
                      cancelButtonColor: "#d33",
                      confirmButtonText: "Oui, Supprime-le",
                      cancelButtonText: "Non, Annuler",
                  }).then((result) => {
                      if (result.isConfirmed) {
                          // Mettez à jour l'action du formulaire avec l'ID et soumettez-le
                          form.action = `/admin/category/${id}/delete`;
                          form.submit();

                          Swal.fire({
                              title: "Catégorie supprimée !",
                              icon: "success"
                          });
                      }
                  });
              } else {
                  console.error("Le formulaire n'a pas été trouvé.");
              }
          }
      </script>



      {{-- script modifier  --}}
      <script>
          function edit_confirmation(button) {
              // Utilisez le bouton pour obtenir le formulaire parent
              const form = button.closest('.edit-form');

              // Vérifiez si le formulaire a été trouvé
              if (form) {
                  // Utilisez le formulaire pour extraire l'ID
                  const id = form.dataset.id;
                  const name = form.dataset.name;

                  Swal.fire({
                      title: "Êtes-vous sûr(e) de vouloir modifier cette categorie ..?",
                      text: name,
                      icon: "question",
                      showCancelButton: true,
                      confirmButtonColor: "#198754",
                      cancelButtonColor: "#d33",
                      confirmButtonText: "Oui",
                      cancelButtonText: "Non",
                  }).then((result) => {
                      if (result.isConfirmed) {
                          // Mettez à jour l'action du formulaire avec l'ID et soumettez-le
                          form.action = `/admin/category/${id}/edit`;
                          form.submit();
                      }
                  });
              } else {
                  console.error("Le formulaire n'a pas été trouvé.");
              }
          }
      </script>

@endsection
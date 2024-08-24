@foreach ($produits as $produit)
    <div class="col-2 p-2">
        <div class="card scat">
            <img src="{{ asset('storage/' . $produit->photo_pr) }}" class="card-img-top" alt="...">
            <div class="card-body p-1 m-0 text-center">
                <h5 class="card-title"> {{$produit->nom_pr}} </h5>
                <p class="card-text"> {{$produit->prix_vent}} DA</p>
            </div>
        </div>
    </div>
@endforeach

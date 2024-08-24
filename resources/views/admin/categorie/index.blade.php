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
       
        <div class="row" >
            @foreach ($catgorys as $catgory)
                
           
            <div class="col-m-3 col12 m-2">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="{{asset('storage/'.$catgory->photo)}}" alt="Card image cap">
                    <div class="card-body">
                        <h3 class="text-center">{{$catgory->nom}}</h3>
                    </div>
                    <div class="form-group row justify-content-center text-center">
                    <div class="col-6">
                        <button type="button" onclick="sauvegarder(this)" class="btn btn-outline-success alpa shadow"><i
                                class="bi bi-check2"></i><span class="btn-description">Modifer</span></button>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-outline-danger alpa shadow" href="{{ '/home' }}"><i class="bi bi-x"></i><span
                                class="btn-description">Supprimer</span></a>
                    </div>
                </div>
                </div>
            </div>

            @endforeach
            
            
        </div>
    </div>


  


</section>

@endsection
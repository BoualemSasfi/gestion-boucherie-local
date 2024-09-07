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
            <h2> transfert  de {{$magasins2->nom}}  vert {{$magasins1->nom}} </h2>
        
        </div>
        <div class="col-2 text-right">

        </div>
    </div>

</div>




        @endsection
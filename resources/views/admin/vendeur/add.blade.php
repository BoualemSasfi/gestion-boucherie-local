@extends('layouts.admin')
@section('content')


<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>




{{-- retour en arrière --}}
<div class="container" id="titre-page">
    <div class="row">
        <div class="col-2 d-flex align-items-center">
            <a href="{{ url('/admin/vendeur') }}" class="btn btn-dark"><i class="fas fa-arrow-left pr-1"></i><span
                    class="btn-description">Retour</span></a>
        </div>
        <div class="col-10 d-flex align-items-center">
            <h2>Ajouter un nouveau vendeur</h2>
        </div>
    </div>
</div>

{{-- Formulaire d'ajout d'un vendeur --}}
<div class="container" style="margin-top: 10px;">
    <div class="row animate__animated animate__backInLeft">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-12 mx-auto">
            <div class="card shadow m-1">
                <form class="edit-form" action="{{ url('/admin/vendeur/add/save') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="text-center form-group col-12">
                                <h3>Information personnelle</h3>
                            </div>

                            <div class="form-group col-6">
                                <h5> N° pièce identité </h5>
                                <input type="number" name="n_p" class="form-control" placeholder="numéro pièce identité">
                            </div>
                            <div class="form-group col-6">
                                <h5> N° Tel </h5>
                                <input type="number" name="tel" class="form-control" placeholder="Numéro de téléphone">
                            </div>
                            <div class="form-group col-6">
                                <h5> Nom </h5>
                                <input type="text" name="nom" class="form-control" placeholder="nom">
                            </div>
                            <div class="form-group col-6">
                                <h5> Prénom </h5>
                                <input type="text" name="prenom" class="form-control" placeholder="prénom">
                            </div>

                            <div class="form-group col-12">
                                <h5> Détails </h5>
                                <input type="text" name="details" class="form-control" placeholder="Détails">
                            </div>
                        </div>
                    </div>

                    <div class="card shadow m-1 pt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="text-center form-group col-12">
                                    <h3>Information application</h3>
                                </div>
                                <div class="form-group col-6">
                                    <h5> Username </h5>
                                    <input type="text" name="user_name" class="form-control" placeholder="username">
                                </div>
                                <div class="form-group col-6">
                                    <h5> Mot de passe </h5>
                                    <input type="password" name="password" class="form-control" placeholder="mot de passe">
                                </div>
          

                                <div class="form-group col-6">
                                    <label for="magasin_id">Intégrer à un magasin</label>
                                    <select id="category" name="magasin_id" class="form-control">
                                        <option value="">Sélectionnez un magasin</option>
                                        @foreach ($magasins as $magasin)
                                            <option value="{{ $magasin->id }}">
                                                {{ $magasin->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-12">
                                    <div class="form-group row justify-content-center text-center">
                                        <div class="col-6">
                                            <button type="button" onclick="sauvegarder(this)" class="btn btn-success p-2">
                                                <i class="fas fa-check fa-lg mr-2"></i><span class="btn-description">Enregistrer</span>
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <a class="btn btn-danger p-2" href="{{ url('/home') }}">
                                                <i class="fas fa-times fa-lg mr-2"></i><span class="btn-description">Annuler</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Script pour la sauvegarde avec SweetAlert --}}
<script>
    function sauvegarder(button) {
        const form = button.closest('.edit-form');

        if (form) {
            Swal.fire({
                title: "Voulez-vous sauvegarder?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui",
                cancelButtonText: "Non"
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
@endsection

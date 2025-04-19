@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Bienvenido, {{ Auth::user()->name }}</h2>
    
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Mis Cócteles Favoritos Recientes</h4>
                    <a href="{{ route('favorites.index') }}" class="btn btn-sm btn-outline-primary">
                        Ver todos mis favoritos
                    </a>
                </div>
                <div class="card-body">
                    @if(auth()->user()->favoriteCocktails->isEmpty())
                        <div class="alert alert-info">
                            No tienes cócteles favoritos. 
                            <a href="{{ route('cocktails.index') }}" class="alert-link">Explora cócteles</a> para agregar algunos.
                        </div>
                    @else
                        <div class="row">
                            @foreach(auth()->user()->favoriteCocktails()->latest()->take(3)->get() as $favorite)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 favorite-card">
                                        <img src="{{ $favorite->image_url }}" class="card-img-top" alt="{{ $favorite->name }}" style="height: 150px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $favorite->name }}</h5>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#favoriteModal-{{ $favorite->id }}">
                                                Ver Detalles
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @include('favorites.modal', ['favorite' => $favorite])
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .favorite-card {
        transition: transform 0.3s ease;
    }
    .favorite-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
</style>
@endpush
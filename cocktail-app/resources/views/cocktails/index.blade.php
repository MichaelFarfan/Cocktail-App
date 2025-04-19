@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/cocktails/card.style.css') }}">
@endsection

@section('title', 'Cócteles')

@section('content')

<div class="container">
    <form method="GET" action="{{ route('cocktails.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar cócteles..." value="{{ request('search', '') }}">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>

    <h1 class="my-4">🍸 {{ $randomView ? "Descubre tu nuevo cóctel" : "Lista de cócteles" }}</h1>

    @if($cocktails->isEmpty())
    <div class="alert alert-info">No se encontraron cócteles con ese nombre.</div>
    @else
    <div class="row">
        @foreach($cocktails as $cocktail)
        <div class="col-md-4 mb-4">
            <div class="card card-cocktail h-100">
                <img src="{{ $cocktail['image'] }}" class="card-img-top" alt="{{ $cocktail['name'] }}" style="height: 200px; object-fit: cover;">
                <form action="{{ route('cocktails.favorite') }}" method="POST" class="favorite-form">
                    @csrf
                    <input type="hidden" name="cocktail_id" value="{{ $cocktail['id'] }}">
                    <input type="hidden" name="name" value="{{ $cocktail['name'] }}">
                    <input type="hidden" name="category" value="{{ $cocktail['category'] }}">
                    <input type="hidden" name="glass_type" value="{{ $cocktail['glass'] }}">
                    <input type="hidden" name="instructions" value="{{ $cocktail['instructions'] }}">
                    <input type="hidden" name="image_url" value="{{ $cocktail['image'] }}">

                    @foreach($cocktail['ingredients'] as $ingredient)
                    <input type="hidden" name="ingredients[]" value="{{ $ingredient }}">
                    @endforeach

                    <button class="float-button-favorite">
                        <i class="fas fa-bookmark"></i>
                    </button>
                </form>

                <div class="card-body">
                    <h5 class="card-title">{{ $cocktail['name'] }}</h5>
                    <p class="card-text"><strong>Categoría:</strong> {{ $cocktail['category'] }}</p>

                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cocktailModal-{{ $cocktail['id'] }}">
                        Ver Detalles Completos
                    </button>
                </div>
            </div>
        </div>
        <div class="modal fade" id="cocktailModal-{{ $cocktail['id'] }}" tabindex="-1" aria-labelledby="cocktailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="cocktailModalLabel">
                            <i class="fas fa-cocktail me-2"></i>{{ $cocktail['name'] }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="sticky-top" style="top: 20px;">
                                    <img src="{{ $cocktail['image'] }}" class="img-fluid rounded mb-3 shadow" alt="{{ $cocktail['name'] }}" style="max-height: 300px; width: 100%; object-fit: cover;">

                                    <div class="card mb-3">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Información Básica</h6>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span><i class="fas fa-tag me-2"></i><strong>Categoría:</strong></span>
                                                    <span class="badge bg-primary rounded-pill">{{ $cocktail['category'] }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span><i class="fas fa-glass-whiskey me-2"></i><strong>Tipo de Vaso:</strong></span>
                                                    <span class="badge bg-success rounded-pill">{{ $cocktail['glass'] }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span><i class="fas fa-wine-bottle me-2"></i><strong>Tipo de Bebida:</strong></span>
                                                    <span class="badge bg-info rounded-pill">{{ $cocktail['type'] }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-list-ul me-2"></i>Ingredientes</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="60%">Ingrediente</th>
                                                        <th width="40%">Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($cocktail['ingredients'] as $ingredient)
                                                    @php
                                                    $parts = explode(' - ', $ingredient, 2);
                                                    $ingredientName = $parts[0] ?? '';
                                                    $measure = $parts[1] ?? 'Al gusto';
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $ingredientName }}</td>
                                                        <td>{{ $measure }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-list-ol me-2"></i>Preparación</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="preparation-steps">
                                            @php
                                            $steps = preg_split('/(?<=\d\.)\s+ /', $cocktail['instructions']);
                                            @endphp

                                            @if(count($steps)> 1)
                                            <ol>
                                                @foreach($steps as $step)
                                                @if(trim($step))
                                                <li>{{ $step }}</li>
                                                @endif
                                                @endforeach
                                            </ol>
                                            @else
                                            <p>{{ $cocktail['instructions'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cerrar
                        </button>
                        <form action="{{ route('cocktails.favorite') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cocktail_id" value="{{ $cocktail['id'] }}">
                            <input type="hidden" name="name" value="{{ $cocktail['name'] }}">
                            <input type="hidden" name="category" value="{{ $cocktail['category'] }}">
                            <input type="hidden" name="glass_type" value="{{ $cocktail['glass'] }}">
                            <input type="hidden" name="instructions" value="{{ $cocktail['instructions'] }}">
                            <input type="hidden" name="image_url" value="{{ $cocktail['image'] }}">

                            @foreach($cocktail['ingredients'] as $ingredient)
                            <input type="hidden" name="ingredients[]" value="{{ $ingredient }}">
                            @endforeach

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-bookmark me-2"></i>Guardar como favorito
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Cóctel agregado a favoritos',
        text: '¡El cóctel se ha añadido a tu lista de favoritos!',
        confirmButtonText: '¡Genial!'
    });
    @endif
</script>
@endpush

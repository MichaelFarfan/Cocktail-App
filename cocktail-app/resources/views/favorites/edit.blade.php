@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Editar Cóctel Favorito</h4>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('favorites.update', $favorite->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name', $favorite->name) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category" class="form-label">Categoría</label>
                            <input type="text" class="form-control" id="category" name="category" 
                                   value="{{ old('category', $favorite->category) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="glass_type" class="form-label">Tipo de Vaso</label>
                            <input type="text" class="form-control" id="glass_type" name="glass_type" 
                                   value="{{ old('glass_type', $favorite->glass_type) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="instructions" class="form-label">Instrucciones</label>
                            <textarea class="form-control" id="instructions" name="instructions" 
                                      rows="4" required>{{ old('instructions', $favorite->instructions) }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Ingredientes</label>
                            <div id="ingredients-container">
                                @foreach($ingredients as $index => $ingredient)
                                    <div class="input-group mb-2 ingredient-group">
                                        <input type="text" class="form-control" name="ingredients[]" 
                                               value="{{ is_array($ingredient) ? $ingredient['name'].' - '.$ingredient['measure'] : $ingredient }}" required>
                                        <button type="button" class="btn btn-outline-danger remove-ingredient">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-ingredient" class="btn btn-sm btn-outline-primary mt-2">
                                <i class="fas fa-plus"></i> Agregar Ingrediente
                            </button>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('favorites.index') }}" class="btn btn-secondary me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(function () {
        $('#add-ingredient').on('click', function () {
            $('#ingredients-container').append(`
                <div class="input-group mb-2 ingredient-group">
                    <input type="text" class="form-control" name="ingredients[]" required>
                    <button type="button" class="btn btn-outline-danger remove-ingredient">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `);
        });
        $('#ingredients-container').on('click', '.remove-ingredient', function () {
            $(this).closest('.ingredient-group').remove();
        });
    });
</script>
@endpush

@endsection
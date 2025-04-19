<div class="modal fade" id="favoriteModal-{{ $favorite->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="favoriteModalLabel">
                    <i class="fas fa-cocktail me-2"></i>{{ $favorite->name }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="sticky-top" style="top: 20px;">
                            <img src="{{ $favorite->image_url }}" class="img-fluid rounded mb-3 shadow" alt="{{ $favorite->name }}" style="max-height: 300px; width: 100%; object-fit: cover;">
                            
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Información Básica</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-tag me-2"></i><strong>Categoría:</strong></span>
                                            <span class="badge bg-primary rounded-pill">{{ $favorite->category }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-glass-whiskey me-2"></i><strong>Tipo de Vaso:</strong></span>
                                            <span class="badge bg-success rounded-pill">{{ $favorite->glass_type }}</span>
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
                                            @foreach($favorite->getFormattedIngredients() as $ingredient)
                                            @if(is_array($ingredient))
                                            <tr>
                                                <td>{{ $ingredient['name'] ?? 'Ingrediente' }}</td>
                                                <td>{{ $ingredient['measure'] ?? 'Cantidad no especificada' }}</td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td>{{ $ingredient }}</td>
                                                <td>---</td>
                                            </tr>
                                            @endif
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
                                    <p>{{ $favorite->instructions }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form action="{{ route('favorites.destroy', $favorite->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Eliminar
                    </button>
                </form>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

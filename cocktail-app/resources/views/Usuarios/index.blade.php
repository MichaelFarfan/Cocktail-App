@extends('layouts.app')
@section('title', 'Usuarios')
@section('content')
<div class="container mt-4">
    <h2>Usuarios</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary mb-3">Crear Usuario</a>
    <table id="users-table" class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Rol</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->role->name }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-sm btn-primary">
                        Editar
                    </a>

                    <form action="{{ route('usuarios.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este usuario?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('styles')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#users-table').DataTable({
            responsive: true, 
            searching: false, 
            paging: false, 
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/Spanish.json' 
            },
            columnDefs: [
                {
                    targets: [0, 1, 2], 
                    responsivePriority: 1, 
                    visible: true 
                },
                {
                    targets: [3, 4], 
                    responsivePriority: 2, 
                    visible: true 
                }
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    className: 'btn btn-success'
                },
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    className: 'btn btn-danger'
                }
            ],
            initComplete: function () {
                var api = this.api();
                api.columns.adjust().responsive.recalc();
            }
        });
    });
</script>
@endpush

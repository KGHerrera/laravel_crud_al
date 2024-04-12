<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Alumnos</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

@include('navbar')

    <!-- Modal de éxito -->
    @if(session('success'))
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">¡Éxito!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="container mt-2">
        <h1>Listado de Alumnos</h1>

        <div class="col-12 d-flex gap-3 mb-3 justify-content-end">
            <!-- Caja de filtrado -->
            <div class="col-5">
                <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
            </div>
            <a class="btn btn-primary btn-sm" href="{{ route('alumnos.create') }}">Agregar</a>
        </div>

        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Número de Control</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Semestre</th>
                    <th scope="col">Fecha de Creación</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody id="alumnosTableBody">
                @foreach($alumnos as $alumno)
                <tr>
                    <td>{{ $alumno->Num_Control }}</td>
                    <td>{{ $alumno->Nombre }}</td>
                    <td>{{ $alumno->Semestre }}</td>
                    <td>{{ $alumno->created_at }}</td>
                    <td>
                        <a href="{{ route('alumnos.edit', $alumno->Num_Control) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('alumnos.destroy', $alumno->Num_Control) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form> 
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Incluir Bootstrap JS (incluye Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Script para filtrado de la tabla -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const alumnosTableBody = document.getElementById('alumnosTableBody');
            const alumnosRows = alumnosTableBody.getElementsByTagName('tr');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.trim().toLowerCase();

                for (const row of alumnosRows) {
                    const numControl = row.cells[0].textContent.trim().toLowerCase();
                    const nombre = row.cells[1].textContent.trim().toLowerCase();
                    const semestre = row.cells[2].textContent.trim().toLowerCase();

                    if (numControl.includes(searchTerm) || nombre.includes(searchTerm) || semestre.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    </script>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            });
        </script>
    @endif

</body>
</html>


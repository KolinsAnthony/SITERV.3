<div class="mt-3">
    @if (session('success'))
        <script>
            Swal.fire({
                icon: "success",
                title: "¡Éxito!",
                text: "{{ session('success') }}"
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}"
            })
        </script>
    
    @endif
    <!-- formulario -->
    <div class="card card-navy">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit mr-2"></i>
                Registrar Estudiante
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.estudiante.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dni">DNI</label>
                            <input type="text" class="form-control" name="dni" placeholder="Escriba el dni del estudiante" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Escriba el nombre del estudiante" required oninput="this.value = this.value.toUpperCase()">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input type="text" class="form-control" name="apellido" placeholder="Escriba el apellido del estudiante" required oninput="this.value = this.value.toUpperCase()">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>Programa</label>
                        <select class="form-control" name="id_programa" required>
                            <option selected disabled>Seleccione un programa</option>
                            @foreach($programas as $programa)
                                <option value="{{ $programa->id }}">{{ $programa->nombre_programa }}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>

                    
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- tabla de programa--}}
    <div class="card card-outline card-navy">
        <div class="card-header">
            <h3 class="card-title text-center">
                <i class="fas fa-table mr-2"></i>
                Tabla de estudiantes
            </h3>
            <div class="text-right">
                <form action="{{ route('estudiantes.importar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" required>
                    <button type="submit" class="btn btn-success">Importar</button>
                </form>
            </div>
            
            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            {{-- Mensaje de error --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        <div class="card-body">
            <table id="estudiante" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Dni</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Nombre de programa</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estudiante as $estudiantes)
                    <tr>
                        <td>{{ $estudiantes->id}}</td>
                        <td>{{ $estudiantes->dni}}</td>
                        <td>{{ $estudiantes->nombre}}</td>
                        <td>{{ $estudiantes->apellido}}</td>
                        <td>{{ $estudiantes->programa ? $estudiantes->programa->nombre_programa : 'No asignado' }}</td>
                        <td width="10px">
                            <a href="" class="btn btn-warning" data-toggle="modal" data-target="#editModal{{ $estudiantes->id }}"><i class="fas fa-edit"></i></a>
                        </td>
                        <td width="10px">
                            <form id="delete-form-{{ $estudiantes->id }}" action="{{ route('admin.estudiante.destroy', $estudiantes->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" onclick="showConfirmation({{ $estudiantes->id }})"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                        
                        <!-- Formulario de confirmación en pantalla -->
                        <div id="confirmation-dialog" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #f8f9fa; border: 1px solid #ddd; padding: 60px; box-shadow: 0 0 25px rgba(0,0,0,0.3); z-index: 1000; width: 500px; text-align: center;">
                            <i class="fas fa-exclamation-triangle" style="font-size: 80px; color: red; display: block; margin-bottom: 30px;"></i>
                            <p style="font-size: 24px; margin-bottom: 30px;">¿Estás seguro de que deseas eliminar este registro? Esta acción no se puede deshacer.</p>
                            <button id="confirm-delete" class="btn btn-danger" style="margin: 10px; padding: 10px 20px;">Sí, eliminar</button>
                            <button id="cancel-delete" class="btn btn-secondary" style="margin: 10px; padding: 10px 20px; background-color: #003366; border-color: #003366;">Cancelar</button>
                        </div>
                        
                        
                    </tr>
                    <!-- Modal de edición -->
                    <div class="modal fade" id="editModal{{ $estudiantes->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $estudiantes->id }}Label" aria-hidden="true">                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModal{{ $estudiantes->id }}Label">Editar estudiante</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('admin.estudiante.update', $estudiantes->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <!-- Campos del formulario de edición -->
                                        <div class="form-group">
                                            <label for="dni{{ $estudiantes->id }}">Dni</label>
                                            <input type="text" class="form-control" name="dni" id="dni{{ $estudiantes->id}}" value="{{ $estudiantes->dni}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="nombre{{ $estudiantes->id }}">Nombre</label>
                                            <input type="text" class="form-control" name="nombre" id="nombre{{ $estudiantes->id}}" value="{{ $estudiantes->nombre }}" oninput="this.value = this.value.toUpperCase()">
                                        </div>
                                        <div class="form-group">
                                            <label for="apellido{{ $estudiantes->id }}">Apellido</label>
                                            <input type="text" class="form-control" name="apellido" id="apellido{{ $estudiantes->id}}" value="{{ $estudiantes->apellido }}" oninput="this.value = this.value.toUpperCase()">
                                        </div>
                                        <div class="form-group">
                                            <label>Programa</label>
                                            <select class="form-control" name="id_programa">
                                                <option disabled>Seleccione un programa</option>
                                                    @foreach($programas as $programa)
                                                        <option value="{{ $programa->id }}" {{ $estudiantes->id_programa == $programa->id ? 'selected' : '' }}>{{ $programa->nombre_programa }}</option>
                                                    @endforeach
                                            </select>
                                        </div>


                                        <!-- Otros campos del formulario -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    let formToSubmit;
    
    function showConfirmation(id) {
        formToSubmit = document.getElementById('delete-form-' + id);
        document.getElementById('confirmation-dialog').style.display = 'block';
    }
    
    document.getElementById('confirm-delete').addEventListener('click', function() {
        formToSubmit.submit();
    });
    
    document.getElementById('cancel-delete').addEventListener('click', function() {
        document.getElementById('confirmation-dialog').style.display = 'none';
    });
</script>
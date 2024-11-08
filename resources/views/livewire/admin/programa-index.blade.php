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
                Registrar Programa
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cod_programa">Código de programa</label>
                            <input type="text" class="form-control" name="cod_programa" id="cod_programa" placeholder="Escriba el código de programa" required oninput="this.value = this.value.toUpperCase()">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre_programa">Nombre de programa</label>
                            <input type="text" class="form-control" name="nombre_programa" id="nombre_programa" placeholder="Escriba el nombre del programa" required oninput="this.value = this.value.toUpperCase()">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="area">Área</label>
                            <select class="form-control" name="area" id="area" required>
                                <option value="" disabled selected>Seleccione el área</option>
                                <option value="TECNOLÓGICO">TECNOLÓGICO</option>
                                <option value="PEDAGÓGICO">PEDAGÓGICO</option>
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
                Tabla de programas
            </h3>
        </div>
        <div class="card-body">
            <table id="programa" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Código de programa</th>
                        <th>Nombre de programa</th>
                        <th>Área</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($programa as $programas)
                    <tr>
                        <td>{{ $programas->id}}</td>
                        <td>{{ $programas->cod_programa}}</td>
                        <td>{{ $programas->nombre_programa}}</td>
                        <td>{{ $programas->area}}</td>
                        <td width="10px">
                            <a href="" class="btn btn-warning" data-toggle="modal" data-target="#editModal{{ $programas->id }}"><i class="fas fa-edit"></i></a>
                        </td>
                        <td width="10px">
                            <form id="delete-form-{{ $programas->id }}" action="{{ route('admin.programa.destroy', $programas->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" onclick="showConfirmation({{ $programas->id }})"><i class="fas fa-trash"></i></button>
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
                    <div class="modal fade" id="editModal{{ $programas->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $programas->id }}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModal{{ $programas->id }}Label">Editar programa</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('admin.programa.update', $programas->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <!-- Campos del formulario de edición -->
                                        <div class="form-group">
                                            <label for="cod_programa{{ $programas->id }}">Código de programa</label>
                                            <input type="text" class="form-control" name="cod_programa" id="cod_programa{{ $programas->id}}" value="{{ $programas->cod_programa}}" oninput="this.value = this.value.toUpperCase()">
                                        </div>
                                        <div class="form-group">
                                            <label for="nombre_programa{{ $programas->id }}">Nombre de programa</label>
                                            <input type="text" class="form-control" name="nombre_programa" id="nombre_programa{{ $programas->id}}" value="{{ $programas->nombre_programa}}" oninput="this.value = this.value.toUpperCase()">
                                        </div>
                                        <div class="form-group">
                                            <label for="area{{ $programas->id }}">Área</label>
                                            <select class="form-control" name="area" id="area{{ $programas->id}}">
                                                <option value="TECNOLÓGICO" {{ $programas->area == 'TECNOLÓGICO' ? 'selected' : '' }}>TECNOLÓGICO</option>
                                                <option value="PEDAGÓGICO" {{ $programas->area == 'PEDAGÓGICO' ? 'selected' : '' }}>PEDAGÓGICO</option>
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
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
                Registrar Comprobante
            </h3>
        </div>
        <div class="card-body">


            <form method="POST" action="{{ route('admin.comprobante.store')}}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group input-group">
                            <label for="dniEstudiante">DNI del Estudiante</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="dniEstudiante" name="dniEstudiante"
                                    placeholder="Ingrese el DNI del estudiante" required>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" id="buscarEstudiante">Buscar</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="idEstudiante" name="id_estudiante">
                        <div class="form-group">
                            <label for="nombrePrograma">Nombre Programa</label>
                            <input type="text" class="form-control" id="nombrePrograma" name="nombrePrograma"
                                placeholder="Programa" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombreCompleto">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto"
                                placeholder="Nombre completo" disabled>
                        </div>



                        <div class="form-group">
                            <label>Rubro</label>
                            <select class="form-control" name="id_rubro" id="rubroSelect" required>
                                <option selected disabled>Seleccione un rubro</option>
                                @foreach ($rubros as $rubro)
                                    <option value="{{ $rubro->id }}">
                                        {{ $rubro->nombre_rubro . ' ' . $rubro->monto }}
                                    </option>
                                @endforeach
                            </select>
                        </div>     
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="precionuevo">Precio nuevo</label>
                            <input type="text" class="form-control" name="precionuevo" id="precioNuevo"
                                   placeholder="Escriba el nuevo precio">
                        </div>
                        
                        <div class="col-md-6 form-group">
                            <label for="comentario">Comentario</label>
                            <input type="text" class="form-control" name="comentario" id="comentario"
                                   placeholder="Escriba la razón del comprobante" style="text-transform: uppercase;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select class="form-control" name="estado" required>
                                <option value="PAGADO">PAGADO</option>
                                <option value="NO PAGADO">NO PAGADO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="date" class="form-control" name="fecha" value="<?php echo date('Y-m-d'); ?>"
                                placeholder="Escriba la fecha del comprobante" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="semestre">Semestre</label>
                            <select class="form-control" name="semestre" required>
                                <option value="" disabled selected>Seleccione el semestre</option>
                                <option value="I">1</option>
                                <option value="II">2</option>
                                <option value="III">3</option>
                                <option value="IV">4</option>
                                <option value="V">5</option>
                                <option value="VI">6</option>
                                <option value="VII">7</option>
                                <option value="VIII">8</option>
                                <option value="IX">9</option>
                                <option value="X">10</option>
                                <option value="EGRESADO">EGRESADO</option>
                            </select>
                        </div>
                    </div>
                </div>
                
 <div class="modal-footer">
    
    <button type="submit" name="action" value="register_and_generate_pdf" class="btn btn-primary" formtarget="_blank" onclick="refreshAfterPDF()">Registrar</button>
</div>

                
                
            </form>
        </div>
    </div>

    {{-- tabla de comprobantes --}}
    <div class="card card-outline card-navy">
        <div class="card-header">
            <h3 class="card-title text-center">
                <i class="fas fa-table mr-2"></i>
                Tabla de Comprobantes
            </h3>
            <div class="text-right mb-3">
                <a href="#filtrarModal" class="btn btn-warning" data-toggle="modal">Filtrar</a>
            </div>
        </div>
        <div class="card-body">
            <table id="comprobante" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Estudiante</th>
                        <th>Programa</th>
                        <th>Dni</th>
                        <th>Monto</th>
                        <th>Rubro</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Semestre</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        <th>Exportar PDF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comprobante as $comprobantes)
                        <tr>
                            <td>{{ $comprobantes->id }}</td>
                            <td>{{ $comprobantes->estudiante ? $comprobantes->estudiante->nombre . ' ' . $comprobantes->estudiante->apellido : 'No asignado' }}
                            </td>
                            <td>{{ $comprobantes->estudiante ? $comprobantes->estudiante->programa->nombre_programa : 'No asignado' }}
                            </td>
                            <td>{{ $comprobantes->estudiante ? $comprobantes->estudiante->dni : 'No asignado' }}</td>
                            <td>{{ $comprobantes->estudiante ? $comprobantes->rubro->monto : 'No asignado' }} {{ $comprobantes->precionuevo }}</td>
                            <td>{{ $comprobantes->rubro ? $comprobantes->rubro->nombre_rubro : 'No asignado' }} {{ $comprobantes->comentario }}</td>
                            <td>{{ $comprobantes->estado }}</td>
                            <td>{{ $comprobantes->fecha }}</td>
                            <td>{{ $comprobantes->semestre }}</td>
                           

                            <td width="10px">
                                <a href="" class="btn btn-warning" data-toggle="modal"
                                    data-target="#editModal{{ $comprobantes->id }}"><i class="fas fa-edit"></i></a>
                            </td>
                            
                            <td width="10px">
                                <form id="delete-form-{{ $comprobantes->id }}" action="{{ route('admin.comprobante.destroy', $comprobantes->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger" onclick="showConfirmation({{ $comprobantes->id }})"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                            
                            <!-- Formulario de confirmación en pantalla -->
                            <div id="confirmation-dialog" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #f8f9fa; border: 1px solid #ddd; padding: 60px; box-shadow: 0 0 25px rgba(0,0,0,0.3); z-index: 1000; width: 500px; text-align: center;">
                                <i class="fas fa-exclamation-triangle" style="font-size: 80px; color: red; display: block; margin-bottom: 30px;"></i>
                                <p style="font-size: 24px; margin-bottom: 30px;">¿Estás seguro de que deseas eliminar este comprobante? Esta acción no se puede deshacer.</p>
                                <button id="confirm-delete" class="btn btn-danger" style="margin: 10px; padding: 10px 20px;">Sí, eliminar</button>
                                <button id="cancel-delete" class="btn btn-secondary" style="margin: 10px; padding: 10px 20px; background-color: #003366; border-color: #003366;">Cancelar</button>
                            </div>
                            
                            
                            
                            <td>
                                <div class="container">
                                    <a href="{{ route('admin.reports.print', $comprobantes->id) }}" target="_blank" class="btn btn-primary">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>

                        </tr>
                        <!-- Modal de edición -->
                        <div class="modal fade" id="editModal{{ $comprobantes->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="editModal{{ $comprobantes->id }}Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModal{{ $comprobantes->id }}Label">Editar
                                            comprobante</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.comprobante.update', $comprobantes->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <!-- Campos del formulario de edición -->
                                            <div class="form-group">
                                                <label>Estudiante</label>
                                                <select class="form-control" name="id_estudiante" disabled>
                                                    <option disabled>Edite los datos del estudiante</option>
                                                    @foreach ($estudiantes as $estudiante)
                                                        <option value="{{ $estudiante->id }}"
                                                            {{ $estudiante->id_estudiante == $estudiante->id ? 'selected' : '' }}>
                                                            {{ $estudiante->nombre . ' ' . $estudiante->apellido }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label>Rubro</label>
                                                <select class="form-control" name="id_rubro">
                                                    <option disabled>Seleccione un rubro</option>
                                                    @foreach ($rubros as $rubro)
                                                        <option value="{{ $rubro->id }}"
                                                            {{ $rubro->id_rubro == $rubro->id ? 'selected' : '' }}>
                                                            {{ $rubro->nombre_rubro }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="estado{{ $comprobantes->id }}">Estado</label>
                                                <select class="form-control" name="estado"
                                                    id="estado{{ $comprobantes->id }}">
                                                    <option value="PAGADO"
                                                        {{ $comprobantes->estado == 'PAGADO' ? 'selected' : '' }}>
                                                        PAGADO</option>
                                                    <option value="NO PAGADO"
                                                        {{ $comprobantes->estado == 'NO PAGADO' ? 'selected' : '' }}>NO
                                                        PAGADO</option>
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label for="fecha{{ $comprobantes->id }}">Fecha</label>
                                                <input type="text" class="form-control" name="fecha"
                                                    id="fecha{{ $comprobantes->id }}" value="{{ $comprobantes->fecha }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="semestre{{ $comprobantes->id }}">Semestre</label>
                                                <select class="form-control" name="semestre"
                                                    id="semestre{{ $comprobantes->id }}">
                                                    <option value="I"
                                                        {{ $comprobantes->semestre == 'I' ? 'selected' : '' }}>I
                                                    </option>
                                                    <option value="II"
                                                        {{ $comprobantes->semestre == 'II' ? 'selected' : '' }}>II
                                                    </option>
                                                    <option value="III"
                                                        {{ $comprobantes->semestre == 'III' ? 'selected' : '' }}>III
                                                    </option>
                                                    <option value="IV"
                                                        {{ $comprobantes->semestre == 'IV' ? 'selected' : '' }}>IV
                                                    </option>
                                                    <option value="V"
                                                        {{ $comprobantes->semestre == 'V' ? 'selected' : '' }}>V
                                                    </option>
                                                    <option value="VI"
                                                        {{ $comprobantes->semestre == 'VI' ? 'selected' : '' }}>VI
                                                    </option>
                                                    <option value="VII"
                                                        {{ $comprobantes->semestre == 'VII' ? 'selected' : '' }}>VII
                                                    </option>
                                                    <option value="VIII"
                                                        {{ $comprobantes->semestre == 'VIII' ? 'selected' : '' }}>VIII
                                                    </option>
                                                    <option value="IX"
                                                        {{ $comprobantes->semestre == 'IX' ? 'selected' : '' }}>IX
                                                    </option>
                                                    <option value="X"
                                                        {{ $comprobantes->semestre == 'X' ? 'selected' : '' }}>X
                                                    </option>
                                                </select>
                                            </div>
                                            <!-- Otros campos del formulario -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="filtrarModal" tabindex="-1" role="dialog" aria-labelledby="filtrarModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="filtrarModalLabel">Filtrar comprobantes</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST" action="{{ route('filtro.buscar') }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <!-- Primera columna de checkboxes -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <!-- Checkboxes I al X -->
                                                        <div class="form-check" style="margin-top: 20px;">
                                                            <input class="form-check-input" type="checkbox" id="selectAllLevels" onclick="toggleLevelCheckboxes(this)" style="width: 20px; height: 20px;">
                                                            <label class="form-check-label" for="selectAllLevels" style="font-size: 16px; font-weight: bold; color: #001f3f;">
                                                                Marcar todos los niveles
                                                            </label>
                                                        </div>
                                                        
                                                        <!-- Checkbox I -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="I" name="filtros[]" value="I">
                                                            <label class="form-check-label" for="I">I</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox II -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="II" name="filtros[]" value="II">
                                                            <label class="form-check-label" for="II">II</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox III -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="III" name="filtros[]" value="III">
                                                            <label class="form-check-label" for="III">III</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox IV -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="IV" name="filtros[]" value="IV">
                                                            <label class="form-check-label" for="IV">IV</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox V -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="V" name="filtros[]" value="V">
                                                            <label class="form-check-label" for="V">V</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox VI -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="VI" name="filtros[]" value="VI">
                                                            <label class="form-check-label" for="VI">VI</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox VIII -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="VIII" name="filtros[]" value="VIII">
                                                            <label class="form-check-label" for="VIII">VIII</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox IX -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="IX" name="filtros[]" value="IX">
                                                            <label class="form-check-label" for="IX">IX</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox X -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="X" name="filtros[]" value="X">
                                                            <label class="form-check-label" for="X">X</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox EGRESADO -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="EGRESADO" name="filtros[]" value="EGRESADO">
                                                            <label class="form-check-label" for="EGRESADO">EGRESADO</label>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="fecha_inicio">Fecha de Inicio</label>
                                                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo date('Y-m-d'); ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="fecha_fin">Fecha de Fin</label>
                                                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo date('Y-m-d'); ?>">
                                                            </div>
                                                        </div>
                                                        
                                                       
                                                    </div>
                                                    
                                                    
                                                </div>
                                    
                                                <!-- Segunda columna de checkboxes -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <!-- Checkbox Pagado -->
                                                        <div class="form-check" style="margin-top: 20px;">
                                                            <input class="form-check-input" type="checkbox" id="selectPaid" onclick="toggleSpecificCheckboxes(this)" style="width: 20px; height: 20px;">
                                                            <label class="form-check-label" for="selectPaid" style="font-size: 16px; font-weight: bold; color:#001f3f;">
                                                                Marcar Todo
                                                            </label>
                                                        </div>
                                                        
                                                        
                                                        <!-- Checkbox PAGADO -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="PAGADO" name="filtros[]" value="PAGADO">
                                                            <label class="form-check-label" for="PAGADO">PAGADO</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox NO PAGADO -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="NO_PAGADO" name="filtros[]" value="NO PAGADO">
                                                            <label class="form-check-label" for="NO_PAGADO">NO PAGADO</label>
                                                        </div>
                                                        
                
                                                        
                                                    
                                    
                                                        <!-- Checkboxes adicionales -->
                                                        <div class="form-check" style="margin-top: 20px;">
                                                            <input class="form-check-input" type="checkbox" id="selectAllCategories" onclick="toggleCategoryCheckboxes(this)" style="width: 20px; height: 20px;">
                                                            <label class="form-check-label" for="selectAllCategories" style="font-size: 16px; font-weight: bold; color: #001f3f;">
                                                                Marcar todas las categorías
                                                            </label>
                                                        </div>
                                                        <!-- Checkbox MATRÍCULA -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="MATRÍCULA" name="filtros[]" value="MATRÍCULA">
                                                            <label class="form-check-label" for="MATRÍCULA">MATRÍCULA</label>
                                                        </div>
                                                        <!-- Checkbox MATRÍCULA -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="MATRÍCULA TARDÍA" name="filtros[]" value="MATRÍCULA TARDÍA">
                                                            <label class="form-check-label" for="MATRÍCULA TARDÍA">MATRÍCULA TARDÍA</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox INSCRIPCIÓN DE POSTULANTES -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="INSCRIPCIÓN DE POSTULANTES" name="filtros[]" value="INSCRIPCIÓN DE POSTULANTES">
                                                            <label class="form-check-label" for="INSCRIPCIÓN DE POSTULANTES">INSCRIPCIÓN DE POSTULANTES</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox NIVELACIÓN ACADÉMICA -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="NIVELACIÓN ACADÉMICA" name="filtros[]" value="NIVELACIÓN ACADÉMICA">
                                                            <label class="form-check-label" for="NIVELACIÓN ACADÉMICA">NIVELACIÓN ACADÉMICA</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox CERTIFICADO DE ESTUDIOS -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="CERTIFICADO DE ESTUDIOS" name="filtros[]" value="CERTIFICADO DE ESTUDIOS">
                                                            <label class="form-check-label" for="CERTIFICADO DE ESTUDIOS">CERTIFICADO DE ESTUDIOS</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox CONSTANCIA/CERTIFICADO -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="CONSTANCIA/CERTIFICADO" name="filtros[]" value="CONSTANCIA/CERTIFICADO">
                                                            <label class="form-check-label" for="CONSTANCIA/CERTIFICADO">CONSTANCIA/CERTIFICADO</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox TITULACIÓN -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="TITULACIÓN" name="filtros[]" value="TITULACIÓN">
                                                            <label class="form-check-label" for="TITULACIÓN">TITULACIÓN</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox CURSOS DE SUBSANACIÓN -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="CURSOS DE SUBSANACIÓN" name="filtros[]" value="CURSOS DE SUBSANACIÓN">
                                                            <label class="form-check-label" for="CURSOS DE SUBSANACIÓN">CURSOS DE SUBSANACIÓN</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox TRASLADOS INTERNOS O EXTERNOS -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="TRASLADOS INTERNOS O EXTERNOS" name="filtros[]" value="TRASLADOS INTERNOS O EXTERNOS">
                                                            <label class="form-check-label" for="TRASLADOS INTERNOS O EXTERNOS">TRASLADOS INTERNOS O EXTERNOS</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox ALQUILERES -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="ALQUILERES" name="filtros[]" value="ALQUILERES">
                                                            <label class="form-check-label" for="ALQUILERES">ALQUILERES</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox PRÁCTICAS PROFESIONALES -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="PRÁCTICAS PROFESIONALES" name="filtros[]" value="PRÁCTICAS PROFESIONALES">
                                                            <label class="form-check-label" for="PRÁCTICAS PROFESIONALES">PRÁCTICAS PROFESIONALES</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox SÍLABUS -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="SÍLABUS" name="filtros[]" value="SÍLABUS">
                                                            <label class="form-check-label" for="SÍLABUS">SÍLABUS</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox AUTENTICAR TÍTULO / CERT. EST. -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="AUTENTICAR TÍTULO / CERT. EST." name="filtros[]" value="AUTENTICAR TÍTULO / CERT. EST.">
                                                            <label class="form-check-label" for="AUTENTICAR TÍTULO / CERT. EST.">AUTENTICAR TÍTULO / CERT. EST.</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox FOTOCOPIA/IMPRESIONES -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="FOTOCOPIA/IMPRESIONES" name="filtros[]" value="FOTOCOPIA/IMPRESIONES">
                                                            <label class="form-check-label" for="FOTOCOPIA/IMPRESIONES">FOTOCOPIA / IMPRESIONES</label>
                                                        </div>
                                                        
                                                        <!-- Checkbox OTROS -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="OTROS" name="filtros[]" value="OTROS">
                                                            <label class="form-check-label" for="OTROS">OTROS</label>
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary" formtarget="_blank" onclick="refreshAfterPDF()">Generar PDF</button>

                                        </div>
                                    </form>                                    
                                </div>
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
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('buscarEstudiante').addEventListener('click', function () {
            var dni = document.getElementById('dniEstudiante').value;
            fetch(`/admin/buscar-estudiante/${dni}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        document.getElementById('nombreCompleto').value = data.nombreCompleto;
                        document.getElementById('nombrePrograma').value = data.nombrePrograma;
                        document.getElementById('idEstudiante').value = data.id;
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            const rubroSelect = document.getElementById('rubroSelect');
            const otrosRubroContainer = document.getElementById('otrosRubroContainer');

            rubroSelect.addEventListener('change', function () {
        if (rubroSelect.value === 'OTROS') {
            // Limpiar cualquier contenido previo en el contenedor
            otrosRubroContainer.innerHTML = '';

            // Crear campo para el rubro si no existe
            if (!document.getElementById('otrosRubroInput')) {
                const rubroInput = document.createElement('input');
                rubroInput.type = 'text';
                rubroInput.id = 'otrosRubroInput';
                rubroInput.name = 'otros_rubro';
                rubroInput.className = 'form-control';
                rubroInput.placeholder = 'Escriba el rubro';
                otrosRubroContainer.appendChild(rubroInput);
            }

            // Crear campo para el monto si no existe
            if (!document.getElementById('otrosMontoInput')) {
                const montoInput = document.createElement('input');
                montoInput.type = 'number';
                montoInput.id = 'otrosMontoInput';
                montoInput.name = 'otros_monto';
                montoInput.className = 'form-control mt-2'; // Añadir margen superior
                montoInput.placeholder = 'Escriba el monto';
                otrosRubroContainer.appendChild(montoInput);
            }
        } else {
            // Eliminar los campos si no se selecciona "OTROS"
            otrosRubroContainer.innerHTML = '';
        }
    });

});
</script>
<script>
    document.getElementById('rubroSelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex].text;
        var precioNuevo = document.getElementById('precioNuevo');
        var comentario = document.getElementById('comentario');
        
        if (selectedOption.includes('OTROS')) {
            precioNuevo.disabled = false;
            comentario.disabled = false;
        } else {
            precioNuevo.disabled = true;
            comentario.disabled = true;
        }
    });
</script>
<script>
    function refreshAfterPDF() {
        // Añade un retraso de 2 segundos antes de refrescar la página
        setTimeout(function() {
            window.location.reload(); // Recarga la página actual
        }, 2000); // Ajusta el tiempo según sea necesario
    }
</script>
<script>
    document.getElementById('precioNuevo').addEventListener('blur', function() {
        let value = parseFloat(this.value);
        if (!isNaN(value)) {
            this.value = value.toFixed(2);  // Añadir dos decimales
        }
    });
</script>
<script>
    function toggleCategoryCheckboxes(source) {
        // IDs de los checkboxes que queremos marcar o desmarcar
        const checkboxes = [
            'MATRÍCULA', 
            'INSCRIPCIÓN DE POSTULANTES', 
            'NIVELACIÓN ACADÉMICA', 
            'CERTIFICADO DE ESTUDIOS', 
            'CONSTANCIA/CERTIFICADO', 
            'TITULACIÓN', 
            'CURSOS DE SUBSANACIÓN', 
            'TRASLADOS INTERNOS O EXTERNOS', 
            'ALQUILERES', 
            'PRÁCTICAS PROFESIONALES', 
            'SÍLABUS', 
            'AUTENTICAR TÍTULO / CERT. EST.', 
            'FOTOCOPIA/IMPRESIONES', 
            'OTROS'
        ];
    
        // Marcar o desmarcar los checkboxes
        checkboxes.forEach(id => {
            document.getElementById(id).checked = source.checked;
        });
    }
    </script>
     <script>
        function toggleSpecificCheckboxes(source) {
            // Solo afecta los checkboxes con los IDs PAGADO y NO_PAGADO
            document.getElementById('PAGADO').checked = source.checked;
            document.getElementById('NO_PAGADO').checked = source.checked;
        }
        </script>
     <script>
        function toggleLevelCheckboxes(source) {
            // Seleccionar o deseleccionar solo los checkboxes especificados
            const checkboxes = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VIII', 'IX', 'X', 'EGRESADO'];
            checkboxes.forEach(id => {
                document.getElementById(id).checked = source.checked;
            });
        }
        </script>
        <script>
            function refreshAfterPDF() {
                // Añade un retraso de 2 segundos antes de refrescar la página
                setTimeout(function() {
                    window.location.reload(); // Recarga la página actual
                }, 2000); // Ajusta el tiempo según sea necesario
            }
        </script>
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
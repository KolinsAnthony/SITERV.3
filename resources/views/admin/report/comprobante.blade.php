<!DOCTYPE html> 
<html lang="es"> 
 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Comprobantes</title> 
    <style> 
        @page { 
            size: A4; 
        } 
 
        body { 
            font-family: 'Arial', sans-serif; 
            margin: 0; 
            padding: 0; 
            font-size: 10px; 
        } 
 
        .red-section { 
            color: red; /* Cambia el color del texto a rojo */ 
        } 
 
        .blue-section { 
            color: blue; /* Cambia el color del texto a azul */ 
        } 
 
        .container { 
            border: 2px solid #0000FF; 
            border-radius: 10px; 
            padding: 5px; 
            margin-top: 10px; /* Ajusta el margen superior según tus necesidades */ 
        }
        
        .container2 { 
            border: 2px solid #f70000; 
            border-radius: 10px; 
            padding: 5px; 
            margin-top: 10px; /* Ajusta el margen superior según tus necesidades */ 
        } 
 
        .marco { 
            border: 2px solid #0000FF; 
            border-radius: 10px; 
            padding: 3px; 
            margin-bottom: 3px; 
            width: calc(50% - 20px); /* 50% del ancho con el espacio entre columnas */ 
        } 

        .marco2 { 
            border: 2px solid #f70000; 
            border-radius: 10px; 
            padding: 3px; 
            margin-bottom: 3px; 
            width: calc(50% - 20px); /* 50% del ancho con el espacio entre columnas */ 
        } 
 
        table { 
            width: 100%; 
            border-collapse: separate; 
            border-spacing: 5px; /* Puedes ajustar este valor según tus preferencias */ 
        } 

        .dashed-line {
            border-top: 1px dashed #000; /* Línea punteada de 1px de grosor y color negro */
            width: 100%; /* Ocupa el 100% del ancho del contenedor */
            margin: 20px 0 0 0; /* Ajusta el margen superior según sea necesario */
            padding: 0; /* Elimina el padding por defecto del párrafo */
            text-align: center; /* Centra la línea dentro del párrafo */
        }

    </style> 
</head> 
 
<body> 
    <div class="red-section"> 
        <div class="container2"> 
            <header> 
                <table> 
                    <tr> 
                        <td><img src="vendor/adminlte/dist/img/logosalle.png" width="90px" height="60px"></td> 
                        <td> 
                            <h3 style="text-align: center; font-size: 12px;">INSTITUTO DE EDUCACIÓN SUPERIOR TECNOLÓGICO PÚBLICO "LA SALLE"</h3> 
                            <h3 style="text-align: center;">AV.Los Incas s/n Telf.201061 - URUBAMBA</h3> 
                            <h3 style="text-align: center;"> RUC. NO20189908220</h3> 
                        </td> 
                        <td class="marco2">NRO:&nbsp;{{ $comprobante->id }}</td> 
                    </tr> 
                    <tr> 
                        <td class="marco2"> 
                            <div style="display: block;">AÑO/DÍA/MES</div> 
                            <div style="display: block;">{{ $comprobante->fecha }}</div> 
                        </td> 
                        <td> 
                            <h2 style="text-align: center;">COMPROBANTE DE INGRESOS</h2> 
                        </td> 
                        <td class="marco2">S/.{{ $comprobante->rubro ? $comprobante->rubro->monto : 'No asignado'}} {{ $comprobante->precionuevo }}</td> 
                    </tr> 
                </table> 
                <table> 
                    <tr> 
                        <td class="marco2">RECIBÍ DE:&nbsp;{{ $comprobante->estudiante ? $comprobante->estudiante->dni : 'No asignado' }}</td> 
                        <td class="marco2">{{ $comprobante->estudiante ? $comprobante->estudiante->nombre . ' ' . $comprobante->estudiante->apellido : 'No asignado'}}</td> 
                    </tr> 
                    <tr> 
                        <td class="marco2">ÁREA: {{ $comprobante->estudiante ? $comprobante->estudiante->programa->area : 'No asignado' }}</td> 
                        <td class="marco2">CARRERA PROF: {{ $comprobante->estudiante ? $comprobante->estudiante->programa->nombre_programa : 'No asignado' }}</td> 
                        <td class="marco2">CICLO/SEM: {{ $comprobante->semestre }}</td> 
                    </tr> 
                    <tr> 
                        <td class="marco2">LA SUMA DE:&nbsp;{{ $comprobante->rubro ? $comprobante->rubro->monto : 'No asignado'}}{{ $comprobante->precionuevo }}&nbsp;SOLES.</td> 
                        @if (!empty($comprobante->comentario))
                            <td class="marco2">COMENTARIOS:&nbsp;{{ $comprobante->comentario }}&nbsp;.</td>
                        @endif
                    </tr>
                </table> 
            </header> 
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                <div style="text-align: center; flex: 1;">
                    <table style="width: 100%;">
                        <tr>
                            <td>POR CONCEPTO DE: {{ $comprobante->rubro ? $comprobante->rubro->nombre_rubro : 'No asignado' }}</td>
                        </tr>
                    </table>
                    <p style="margin: 0;">_____________________</p>
                    <p style="margin: 0;">TESORERIA</p>
                </div>
                <div style="text-align: right; flex: 1;">
                    <p style="margin: 0;">Tesorería</p>
                </div>
            </div>
        </div> 
    </div> 
    
    <p class="dashed-line"></p>

    <div class="blue-section"> 
        <div class="container"> 
            <header> 
                <table> 
                    <tr> 
                        <td><img src="vendor/adminlte/dist/img/logosalle.png" width="90px" height="60px"></td> 
                        <td> 
                            <h3 style="text-align: center; font-size: 12px;">INSTITUTO DE EDUCACIÓN SUPERIOR TECNOLÓGICO PÚBLICO "LA SALLE"</h3> 
                            <h3 style="text-align: center;">AV.Los Incas s/n Telf.201061 - URUBAMBA</h3> 
                            <h3 style="text-align: center;"> RUC. NO20189908220</h3> 
                        </td> 
                        <td class="marco">NRO:&nbsp;{{ $comprobante->id }}</td> 
                    </tr> 
                    <tr> 
                        <td class="marco"> 
                            <div style="display: block;">AÑO/DÍA/MES</div> 
                            <div style="display: block;">{{ $comprobante->fecha }}</div> 
                        </td> 
                        <td> 
                            <h2 style="text-align: center;">COMPROBANTE DE INGRESOS</h2> 
                        </td> 
                        <td class="marco">S/.{{ $comprobante->rubro ? $comprobante->rubro->monto : 'No asignado'}} {{ $comprobante->precionuevo }}</td> 
                    </tr> 
                </table> 
                <table> 
                    <tr> 
                        <td class="marco">RECIBÍ DE:&nbsp;{{ $comprobante->estudiante ? $comprobante->estudiante->dni : 'No asignado' }}</td> 
                        <td class="marco">{{ $comprobante->estudiante ? $comprobante->estudiante->nombre . ' ' . $comprobante->estudiante->apellido : 'No asignado'}}</td> 
                    </tr> 
                    <tr> 
                        <td class="marco">ÁREA: {{ $comprobante->estudiante ? $comprobante->estudiante->programa->area : 'No asignado' }}</td> 
                        <td class="marco">CARRERA PROF: {{ $comprobante->estudiante ? $comprobante->estudiante->programa->nombre_programa : 'No asignado' }}</td> 
                        <td class="marco">CICLO/SEM: {{ $comprobante->semestre }}</td> 
                    </tr> 
                    <tr> 
                        <td class="marco">LA SUMA DE:&nbsp;{{ $comprobante->rubro ? $comprobante->rubro->monto : 'No asignado'}}{{ $comprobante->precionuevo }}&nbsp;SOLES.</td> 
                        @if (!empty($comprobante->comentario))
                            <td class="marco">COMENTARIOS:&nbsp;{{ $comprobante->comentario }}&nbsp;.</td>
                        @endif
                    </tr>
                </table> 
            </header> 
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                <div style="text-align: center; flex: 1;">
                    <table style="width: 100%;">
                        <tr>
                            <td>POR CONCEPTO DE: {{ $comprobante->rubro ? $comprobante->rubro->nombre_rubro : 'No asignado' }}</td>
                        </tr>
                    </table>
                    <p style="margin: 0;">_____________________</p>
                    <p style="margin: 0;">TESORERIA</p>
                </div>
                <div style="text-align: right; flex: 1;">
                    <p style="margin: 0;">Secretaría académica</p>
                </div>
            </div>
        </div> 
    </div>
    <p class="dashed-line"></p>
    <div class="blue-section"> 
        <div class="container"> 
            <header> 
                <table> 
                    <tr> 
                        <td><img src="vendor/adminlte/dist/img/logosalle.png" width="90px" height="60px"></td> 
                        <td> 
                            <h3 style="text-align: center; font-size: 12px;">INSTITUTO DE EDUCACIÓN SUPERIOR TECNOLÓGICO PÚBLICO "LA SALLE"</h3> 
                            <h3 style="text-align: center;">AV.Los Incas s/n Telf.201061 - URUBAMBA</h3> 
                            <h3 style="text-align: center;"> RUC. NO20189908220</h3> 
                        </td> 
                        <td class="marco">NRO:&nbsp;{{ $comprobante->id }}</td> 
                    </tr> 
                    <tr> 
                        <td class="marco"> 
                            <div style="display: block;">AÑO/DÍA/MES</div> 
                            <div style="display: block;">{{ $comprobante->fecha }}</div> 
                        </td> 
                        <td> 
                            <h2 style="text-align: center;">COMPROBANTE DE INGRESOS</h2> 
                        </td> 
                        <td class="marco">S/.{{ $comprobante->rubro ? $comprobante->rubro->monto : 'No asignado'}} {{ $comprobante->precionuevo }}</td> 
                    </tr> 
                </table> 
                <table> 
                    <tr> 
                        <td class="marco">RECIBÍ DE:&nbsp;{{ $comprobante->estudiante ? $comprobante->estudiante->dni : 'No asignado' }}</td> 
                        <td class="marco">{{ $comprobante->estudiante ? $comprobante->estudiante->nombre . ' ' . $comprobante->estudiante->apellido : 'No asignado'}}</td> 
                    </tr> 
                    <tr> 
                        <td class="marco">ÁREA: {{ $comprobante->estudiante ? $comprobante->estudiante->programa->area : 'No asignado' }}</td> 
                        <td class="marco">CARRERA PROF: {{ $comprobante->estudiante ? $comprobante->estudiante->programa->nombre_programa : 'No asignado' }}</td> 
                        <td class="marco">CICLO/SEM: {{ $comprobante->semestre }}</td> 
                    </tr> 
                    <tr> 
                        <td class="marco">LA SUMA DE:&nbsp;{{ $comprobante->rubro ? $comprobante->rubro->monto : 'No asignado'}}{{ $comprobante->precionuevo }}&nbsp;SOLES.</td> 
                        @if (!empty($comprobante->comentario))
                            <td class="marco">COMENTARIOS:&nbsp;{{ $comprobante->comentario }}&nbsp;.</td>
                        @endif
                    </tr>
                </table> 
            </header> 
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                <div style="text-align: center; flex: 1;">
                    <table style="width: 100%;">
                        <tr>
                            <td>POR CONCEPTO DE: {{ $comprobante->rubro ? $comprobante->rubro->nombre_rubro : 'No asignado' }}</td>
                        </tr>
                    </table>
                    <p style="margin: 0;">_____________________</p>
                    <p style="margin: 0;">TESORERIA</p>
                </div>
                <div style="text-align: right; flex: 1;">
                    <p style="margin: 0;">Estudiante</p>
                </div>
            </div>
        </div> 
    </div>
</body> 
 
</html>
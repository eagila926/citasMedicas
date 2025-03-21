<?php
include 'layout/config.php'; 
$cedula = isset($_GET['cedula']) ? $_GET['cedula'] : '';

if (empty($cedula)) {
    die("<p>Error: No se proporcionó la cédula del paciente.</p>");
}


// Consultar la información del paciente
$query_paciente = "SELECT * FROM pacientes WHERE cedula = :cedula";
$stmt = $pdo->prepare($query_paciente);
$stmt->bindParam(":cedula", $cedula, PDO::PARAM_STR);
$stmt->execute();
$paciente = $stmt->fetch();

// Consultar las consultas del paciente
$query_consultas = "SELECT * FROM motivo_consulta WHERE idpaciente = :cedula ORDER BY fecha DESC";
$stmt = $pdo->prepare($query_consultas);
$stmt->bindParam(":cedula", $cedula, PDO::PARAM_STR);
$stmt->execute();
$result_consultas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Paciente</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <link href="assets/plugins/animate/animate.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Mostrar 'contenedor-consultas' y ocultar 'contenedor-info' al cargar la página
            $("#contenedor-consultas").show();
            $("#contenedor-info").hide();

            // Cuando se hace clic en 'btn-consultas', mostrar 'contenedor-consultas' y ocultar 'contenedor-info'
            $("#btn-consultas").click(function() {
                $("#contenedor-info").hide();
                $("#contenedor-consultas").show();
            });

            // Cuando se hace clic en 'btn-info', mostrar 'contenedor-info' y ocultar 'contenedor-consultas'
            $("#btn-info").click(function() {
                $("#contenedor-consultas").hide();
                $("#contenedor-info").show();
            });
        });
    </script>

    <!-- Table css -->
    <link href="assets/plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css" rel="stylesheet" type="text/css" media="screen">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include 'layout/nav_consulta.php'; ?>

<div class="content">
    <button class="btn btn-success" id="btn-consultas" onclick="">Consultas Previas</button>
    <button class="btn btn-warning" id="btn-info" onclick="">Información del Paciente</button>

    <div id="contenedor-consultas">
        <h2>Consultas anteriores</h2>
        <button class="btn btn-secondary" id="btn-nueva-consulta" data-bs-toggle="modal" data-bs-target="#modalNuevaConsulta">
            Continuar con la consulta
        </button>

        <h2>Detalle de consultas</h2>
        <div class="table-rep-plugin">
            <div class="table-responsive b-0" data-pattern="priority-columns">
            <table id="agenda-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th data-priority="1">Fecha</th>
                        <th data-priority="2">Motivo</th>
                        <th data-priority="2">Esquema</th>
                        <th data-priority="3">Signos Vitales</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (!empty($result_consultas)) {
                        $contador = 1;
                        foreach ($result_consultas as $consulta) {
                            echo "<tr>";
                            echo "<td>" . $contador++ . "</td>";
                            echo "<td>" . htmlspecialchars($consulta['fecha']) . "</td>";
                            echo "<td>" . htmlspecialchars($consulta['motivo']) . "</td>";
                            echo "<td><a href='archivos/" . htmlspecialchars($consulta['archivo']) . "' target='_blank'>Ver Archivo</a></td>";
                            echo "<td>
                                    <strong>Talla:</strong> " . htmlspecialchars($consulta['talla']) . " cm<br>
                                    <strong>Peso:</strong> " . htmlspecialchars($consulta['peso']) . " kg<br>
                                    <strong>IMC:</strong> " . htmlspecialchars($consulta['imc']) . "<br>
                                    <strong>Frecuencia Respiratoria:</strong> " . htmlspecialchars($consulta['frespiratoria']) . " rpm<br>
                                    <strong>Temperatura:</strong> " . htmlspecialchars($consulta['temperatura']) . " °C<br>
                                    <strong>Frecuencia Cardiaca:</strong> " . htmlspecialchars($consulta['fcardiaca']) . " bpm
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No hay consultas previas registradas.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            </div>
        </div>        
    </div>
        
    <div id="contenedor-info" style="display: none;">
        <h2>Información del Paciente</h2>
        
        <div>
            <h3>Datos Básicos</h3>
            <p><strong>Nombre:</strong> <?php echo $paciente['nombres'] . " " . $paciente['apellidos']; ?></p>
            <p><strong>Tipo de Documento:</strong> <?php echo $paciente['tipo_documento']; ?></p>
            <p><strong>Cédula:</strong> <?php echo $paciente['cedula']; ?></p>
            <p><strong>Correo:</strong> <?php echo $paciente['correo']; ?></p>
            <p><strong>Celular:</strong> <?php echo $paciente['celular']; ?></p>
            <p><strong>Dirección:</strong> <?php echo $paciente['direccion']; ?></p>
            <p><strong>Fecha de Nacimiento:</strong> <?php echo $paciente['fecha_nacimiento']; ?></p>
            <p><strong>Sexo:</strong> <?php echo $paciente['sexo']; ?></p>
            <p><strong>Ocupación:</strong> <?php echo $paciente['ocupacion']; ?></p>
            <p><strong>Estado Civil:</strong> <?php echo $paciente['estado_civil']; ?></p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditarBasico">Editar</button>
        </div>
        
        <div>
            <h3>Información Médica</h3>
            <p><strong>Hijos:</strong> <?php echo $paciente['hijos']; ?></p>
            <p><strong>Religion:</strong> <?php echo $paciente['religion']; ?></p>
            <p><strong>Contacto de Emergencia:</strong> <?php echo $paciente['contacto_emergencia']; ?></p>
            <p><strong>Número de Emergencia:</strong> <?php echo $paciente['numero_emergencia']; ?></p>
            <p><strong>Antecedentes Personales:</strong> <?php echo $paciente['antecedentes_personales']; ?></p>
            <p><strong>Antecedentes Familiares:</strong> <?php echo $paciente['antecedentes_familiares']; ?></p>
            <p><strong>Relaciones familiares  e interpersonales:</strong> <?php echo $paciente['relaciones_familiares']; ?></p>
            <p><strong>Enfermedad Actual:</strong> <?php echo $paciente['enfermedad_actual']; ?></p>
            <p><strong>Ciclo de Sueño:</strong> <?php echo $paciente['ciclo_sueno']; ?></p>
            <p><strong>Ciclo Digestivo:</strong> <?php echo $paciente['ciclo_digestivo']; ?></p>
            <p><strong>Día de alimentacion:</strong> <?php echo $paciente['dia_alimentacion']; ?></p>
            <p><strong>Plan de Tratamiento:</strong> <?php echo $paciente['plan_tratamiento']; ?></p>   
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditarMedico">Editar</button>
        </div>
    </div>
</div>

<!-- Modal Editar Datos Básicos -->
<div id="modalEditarBasico" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Datos Generales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            <form action="update_datosg.php" method="POST">
            <div class="row">
                        <div class="col-md-6">
                            <label>Nombres:</label>
                            <input type="text" name="nombres" class="form-control" value="<?php echo $paciente['nombres']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label>Apellidos:</label>
                            <input type="text" name="apellidos" class="form-control"  value="<?php echo $paciente['apellidos']; ?>" required>
                        </div>                       
                        
                    </div>
                    <div class="row">
                        
                        <div class="col-md-6">
                        
                            <label>Tipo de Documento</label>
                            <div>
                            <select name="tipo_documento" class="form-control" required>
                                    <option>Seleecione una opcion</option>
                                    <option>Cedula</option>
                                    <option>Cedula Extranjera</option>
                                    <option>Pasaporte</option>
                                    <option>Tarjeta de identidad</option>
                                    <option>Registro Civil</option>
                                </select>
                            </div>
                                
                        </div>
                        <div class="col-md-6">
                            <label>Numero de identificacion:</label>
                            <input type="number" name="cedula" class="form-control" value="<?php echo $paciente['cedula']; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Correo:</label>
                            <input type="email" name="correo" class="form-control" value="<?php echo $paciente['correo']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label>Celular:</label>
                            <input type="number" name="celular" class="form-control" value="<?php echo $paciente['celular']; ?>">
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-md-12">
                            <label>Dirección:</label>
                            <input type="text" name="direccion" class="form-control" value="<?php echo $paciente['direccion']; ?>">
                        </div>
                    </div>
                        
                    <div class="row">
                        <div class="col-md-6">
                            <label>Fecha de Nacimiento:</label>
                            <input type="datetime-local" name="fecha_nacimiento" class="form-control" value="<?php echo $paciente['fecha_nacimiento']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label>Sexo:</label>
                            <select name="sexo" class="form-control">
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Ocupación:</label>
                            <input type="text" name="ocupacion" class="form-control" value="<?php echo $paciente['ocupacion']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label>Estado Civil:</label>
                            <input type="text" name="estadocivil" class="form-control" value="<?php echo $paciente['estado_civil']; ?>">
                        </div>
                    </div>                  
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
            </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal Editar Información Médica -->
<div id="modalEditarMedico" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Datos Médicos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            <form action="update_datosm.php" method="POST">
                            <!-- Campo oculto para la cédula -->
                <input type="hidden" name="cedula" value="<?php echo $paciente['cedula']; ?>">
                <div class="row">
                        <div class="col-md-12">
                            <label>Hijos:</label>
                            <textarea name="hijos" class="form-control"><?php echo htmlspecialchars($paciente['hijos']); ?></textarea>

                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label>Religión:</label>
                            <select name="religion" class="form-control">
                                <option value="Catolicismo">Catolicismo</option>
                                <option value="Protestantismo">Protestantismo / Evangelismo</option>
                                <option value="Sin afiliación">Sin afiliación religiosa</option>
                                <option value="Testigos de Jehová">Testigos de Jehová</option>
                                <option value="Mormón">Mormón</option>
                                <option value="Islam">Islam</option>
                                <option value="Judaísmo">Judaísmo</option>
                                <option value="Espiritualidad indígena">Espiritualidad indígena</option>
                                <option value="Budismo">Budismo</option>
                                <option value="Otras">Otras</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Contacto de Emergencia:</label>
                            <input type="text" name="contactoemergencia" class="form-control" value="<?php echo $paciente['contacto_emergencia']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label>Número de Emergencia:</label>
                            <input type="number" name="numeroemergencia" class="form-control" value="<?php echo $paciente['numero_emergencia']; ?>">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <label>Antecedentes Personales:</label>
                            <textarea name="antecedentespersonales" class="form-control"><?php echo htmlspecialchars($paciente['antecedentes_personales']); ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Antecedentes Familiares:</label>
                            <textarea name="antfamiliares" class="form-control"> <?php echo htmlspecialchars($paciente['antecedentes_familiares']); ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Relaciones familiares  e interpersonales:</label>
                            <textarea name="familiainterpersonal" class="form-control"><?php echo htmlspecialchars($paciente['relaciones_familiares']); ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Enfermedad Actual:</label>
                            <textarea name="enfermedadactual" class="form-control"><?php echo htmlspecialchars($paciente['enfermedad_actual']); ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Ciclo de sueño:</label>
                            <textarea name="ciclosueño" class="form-control"><?php echo htmlspecialchars($paciente['ciclo_sueno']); ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Ciclo Digestivo:</label>
                            <textarea name="ciclodigestivo" class="form-control"><?php echo htmlspecialchars($paciente['ciclo_digestivo']); ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Día de alimentación:</label>
                            <textarea name="diaalimentacion" class="form-control"><?php echo htmlspecialchars($paciente['dia_alimentacion']); ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Plan de tratamiento:</label>
                            <textarea name="plantratamiento" class="form-control"><?php echo htmlspecialchars($paciente['plan_tratamiento']); ?></textarea>
                        </div>
                    </div>                 
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
            </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal para Nueva Consulta -->
<div id="modalNuevaConsulta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabelNuevaConsulta" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelNuevaConsulta">Registrar Nueva Consulta</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="guardar_consulta.php" method="POST">
                    <!-- ID Paciente (se obtiene de la cédula del paciente automáticamente) -->
                    <input type="hidden" name="idpaciente" value="<?php echo $cedula; ?>">

                    <!-- ID Médico (valor fijo) -->
                    <input type="hidden" name="idmedico" value="12223456">

                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo de la consulta:</label>
                        <input type="text" name="motivo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="talla" class="form-label">Talla (cm):</label>
                        <input type="number" step="0.01" name="talla" id="talla" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="peso" class="form-label">Peso (kg):</label>
                        <input type="number" step="0.01" name="peso" id="peso" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="imc" class="form-label">IMC:</label>
                        <input type="text" name="imc" id="imc" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="frespiratoria" class="form-label">Frecuencia Respiratoria (rpm):</label>
                        <input type="number" name="frespiratoria" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="temperatura" class="form-label">Temperatura (°C):</label>
                        <input type="number" step="0.1" name="temperatura" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="fcardiaca" class="form-label">Frecuencia Cardiaca (bpm):</label>
                        <input type="number" name="fcardiaca" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="archivo" class="form-label">Ruta del Archivo:</label>
                        <input type="text" name="archivo" id="archivo" class="form-control" readonly>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar Consulta</button>
                </form>
            </div>
        </div>
    </div>
</div>


<footer class="footer">&copy; 2025 SmartSalud.</footer>


<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/modernizr.min.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/jquery.nicescroll.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>
<script>
    $('.btn-animation').on('click', function(br) {
    //adding animation
    $('.modal .modal-dialog').attr('class', 'modal-dialog  ' + $(this).data("animation") + '  animated');
    });
</script>

<script>
    $(document).ready(function() {
        // Calcular IMC automáticamente al llenar talla y peso
        $("#talla, #peso").on("input", function() {
            var talla = parseFloat($("#talla").val()) / 100; // Convertir cm a metros
            var peso = parseFloat($("#peso").val());
            if (!isNaN(talla) && !isNaN(peso) && talla > 0) {
                var imc = (peso / (talla * talla)).toFixed(2);
                $("#imc").val(imc);
            } else {
                $("#imc").val("");
            }
        });

        // Generar la ruta del archivo automáticamente
        $("input[name='motivo'], #talla, #peso").on("input", function() {
            var cedula = "<?php echo $cedula; ?>";
            var fecha = new Date().toISOString().split('T')[0]; // Fecha en formato YYYY-MM-DD
            var archivoRuta = "uploads/esquema/" + cedula + "_" + fecha + ".pdf";
            $("#archivo").val(archivoRuta);
        });
    });
</script>

</body>
</html>

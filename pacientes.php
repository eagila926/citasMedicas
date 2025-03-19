<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas Médicas</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".user-menu").click(function() {
                $(".dropdown-menu").toggle();
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

<?php 
include 'layout/nav-up.php'; 
include 'layout/config.php'; // Archivo de conexión usando PDO

try {
    // Consulta a la base de datos con PDO
    $sql = "SELECT nombres, apellidos, cedula, correo, celular FROM pacientes";
    $stmt = $pdo->query($sql);
    $pacientes = $stmt->fetchAll();
} catch (PDOException $e) {
    die("ERROR: No se pudo ejecutar la consulta. " . $e->getMessage());
}
?>

<div class="content">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mt-0 header-title">Lista de Pacientes</h4>
                <p class="text-muted m-b-30 font-14">Aquí puedes gestionar las citas de los pacientes.</p>
            </div>
            <a href="registrar_paciente.php" class="btn btn-success">Registrar nuevo paciente</a>
        </div>
        <div class="table-rep-plugin">
            <div class="table-responsive b-0" data-pattern="priority-columns">
                <table id="tech-companies-1" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th data-priority="1">Nombre Completo</th>
                            <th data-priority="3">Cedula</th>
                            <th data-priority="3">Correo</th>
                            <th data-priority="3">Celular</th>
                            <th data-priority="3">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $contador = 1;
                        foreach ($pacientes as $paciente) { 
                        ?>
                        <tr>
                            <td><?php echo $contador++; ?></td>
                            <td><?php echo htmlspecialchars($paciente['nombres'] . " " . $paciente['apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($paciente['cedula']); ?></td>
                            <td><?php echo htmlspecialchars($paciente['correo']); ?></td>
                            <td><?php echo htmlspecialchars($paciente['celular']); ?></td>
                            <td>
                                <button class="btn btn-primary" onclick="agendarCita('<?php echo htmlspecialchars($paciente['nombres'] . ' ' . $paciente['apellidos']); ?>', '<?php echo htmlspecialchars($paciente['cedula']); ?>')">
                                    Agendar Cita
                                </button>
                            </td>
                        </tr>
                        <?php 
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Agendar Cita -->
<div id="modalAgendarCita" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalCitaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCitaLabel">Agendar Cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAgendarCita" action="guardar_cita.php" method="POST">
                    <div class="form-group">
                        <label for="idpaciente">Cédula del Paciente</label>
                        <input type="text" class="form-control" id="idpaciente" name="idpaciente" readonly>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha de la Cita</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required>
                    </div>
                    <div class="form-group">
                        <label for="hora">Hora de la Cita</label>
                        <input type="time" class="form-control" id="hora" name="hora" required>
                    </div>
                    <input type="hidden" name="idmedico" value="111122234"> <!-- Valor fijo -->
                    <input type="hidden" name="estado" value="0"> <!-- Estado por defecto -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Agendar Cita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<footer class="footer">
    &copy; 2025 SmartSalud.
</footer>

<script>
    function agendarCita(nombrePaciente, cedula) {
        $('#idpaciente').val(cedula);
        $('#modalCitaLabel').text("Agendar Cita para " + nombrePaciente);
        $('#modalAgendarCita').modal('show');
    }
</script>

<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/modernizr.min.js"></script>
<script src="assets/js/detect.js"></script>
<script src="assets/js/fastclick.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/jquery.blockUI.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/jquery.nicescroll.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>

<!-- Responsive-table-->
<script src="assets/plugins/RWD-Table-Patterns/dist/js/rwd-table.min.js" type="text/javascript"></script>

<script>
    $(function() {
        $('.table-responsive').responsiveTable({
            addDisplayAllBtn: 'btn btn-secondary'
        });
    });

</script>

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>
</html>




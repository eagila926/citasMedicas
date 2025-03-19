<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Citas</title>
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
include 'layout/config.php'; // Conexión a la base de datos

try {
    // Consulta para obtener las citas con los datos del paciente
    $sql = "SELECT c.idcitas, p.nombres, p.apellidos, p.cedula, p.correo, p.celular, c.fecha, c.hora, c.estado 
        FROM citas c
        JOIN pacientes p ON c.idpaciente = p.cedula
        WHERE c.fecha >= CURDATE()  
        ORDER BY c.fecha ASC, c.hora ASC";
    $stmt = $pdo->query($sql);
    $citas = $stmt->fetchAll();
} catch (PDOException $e) {
    die("ERROR: No se pudo ejecutar la consulta. " . $e->getMessage());
}
?>

<div class="content">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mt-0 header-title">Agenda de Citas</h4>
                <p class="text-muted m-b-30 font-14">Aquí puedes ver y gestionar las citas agendadas.</p>
            </div>
        </div>
        <div class="table-rep-plugin">
            <div class="table-responsive b-0" data-pattern="priority-columns">
                <table id="agenda-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th data-priority="1">Paciente</th>
                        <th data-priority="2">Cédula</th>
                        <th data-priority="3">Correo</th>
                        <th data-priority="3">Celular</th>
                        <th data-priority="3">Fecha de la Cita</th>
                        <th data-priority="3">Hora</th>
                        <th data-priority="3">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $contador = 1;
                    foreach ($citas as $cita) { 
                    ?>
                    <tr>
                        <td><?php echo $contador++; ?></td>
                        <td><?php echo htmlspecialchars($cita['nombres'] . " " . $cita['apellidos']); ?></td>
                        <td><?php echo htmlspecialchars($cita['cedula']); ?></td> 
                        <td><?php echo htmlspecialchars($cita['correo']); ?></td>
                        <td><?php echo htmlspecialchars($cita['celular']); ?></td>
                        <td><?php echo htmlspecialchars($cita['fecha']); ?></td>
                        <td><?php echo htmlspecialchars($cita['hora']); ?></td>
                        <td>
                            <button class="btn btn-warning" onclick="abrirModalReagendar('<?php echo $cita['idcitas']; ?>')">Reagendar Cita</button>
                            <a href="info-paciente.php?cedula=<?php echo $cita['cedula']; ?>" class="btn btn-success">Ir a Consulta</a>
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


<!-- Modal para Reagendar Cita -->
<div id="modalReagendar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalReagendarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReagendarLabel">Reagendar Cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formReagendar" action="actualizar_cita.php" method="POST">
                    <input type="hidden" id="idcita" name="idcita">
                    <div class="form-group">
                        <label for="nueva_fecha">Nueva Fecha</label>
                        <input type="date" class="form-control" id="nueva_fecha" name="nueva_fecha" required>
                    </div>
                    <div class="form-group">
                        <label for="nueva_hora">Nueva Hora</label>
                        <input type="time" class="form-control" id="nueva_hora" name="nueva_hora" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<footer class="footer">
    &copy; 2025 SmartSalud.
</footer>

<!-- Scripts -->
<script>

    function abrirModalReagendar(idCita) {
        $('#idcita').val(idCita);
        $('#modalReagendar').modal('show');
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

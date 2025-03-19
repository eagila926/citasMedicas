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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#btn-consultas").click(function() {
                $("#contenedor-info").hide();
                $("#contenedor-consultas").show();
            });

            $("#btn-info").click(function() {
                $("#contenedor-consultas").hide();
                $("#contenedor-info").show();
            });

            $("#btn-editar-basico").click(function() {
                $("#form-editar-basico").toggle();
            });

            $("#btn-editar-medico").click(function() {
                $("#form-editar-medico").toggle();
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
    <button id="btn-info">Información del Paciente</button>
    <button id="btn-consultas">Consultas</button>
    
    <div id="contenedor-info">
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
            <button id="btn-editar-basico">Editar</button>
            <form id="form-editar-basico" style="display:none;" action="editar_paciente.php" method="POST">
                <!-- Campos del formulario para datos básicos -->
                <input type="hidden" name="cedula" value="<?php echo $paciente['cedula']; ?>">
                <input type="text" name="nombres" value="<?php echo $paciente['nombres']; ?>">
                <input type="text" name="apellidos" value="<?php echo $paciente['apellidos']; ?>">
                <input type="date" name="fecha_nacimiento" value="<?php echo $paciente['fecha_nacimiento']; ?>">
                <button type="submit">Guardar</button>
            </form>
        </div>
        
        <div>
            <h3>Información Médica</h3>
            <p><strong>Peso:</strong> <?php echo $paciente['peso']; ?></p>
            <p><strong>Estatura:</strong> <?php echo $paciente['estatura']; ?></p>
            <p><strong>IMC:</strong> <?php echo $paciente['imc']; ?></p>
            <p><strong>Enfermedad Actual:</strong> <?php echo $paciente['enfermedad_actual']; ?></p>
            <button id="btn-editar-medico">Editar</button>
            <form id="form-editar-medico" style="display:none;" action="editar_paciente.php" method="POST">
                <!-- Campos del formulario para información médica -->
                <input type="hidden" name="cedula" value="<?php echo $paciente['cedula']; ?>">
                <input type="text" name="peso" value="<?php echo $paciente['peso']; ?>">
                <input type="text" name="estatura" value="<?php echo $paciente['estatura']; ?>">
                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>
</div>

<footer class="footer">&copy; 2025 SmartSalud.</footer>
</body>
</html>

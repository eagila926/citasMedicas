<?php
include 'layout/config.php'; // Conexión a la base de datos

// Obtener la fecha actual
$fecha_actual = date("_d F Y_");

// Verificar si la cédula está en la URL
if (!isset($_GET['cedula'])) {
    die("Error: No se proporcionó una cédula.");
}

$cedula_paciente = $_GET['cedula'];

// Obtener datos del paciente usando la cédula
$query = "SELECT nombres, apellidos, celular, cedula FROM pacientes WHERE cedula = :cedula";
$stmt = $pdo->prepare($query);
$stmt->execute(['cedula' => $cedula_paciente]);
$paciente = $stmt->fetch();

if (!$paciente) {
    die("Error: No se encontró un paciente con esa cédula.");
}

$nombre_completo = "_" . $paciente['nombres'] . " " . $paciente['apellidos'] . "_";
$telefono = "_" . $paciente['celular'] . "_";
$cedula = "_" . $paciente['cedula'] . "_";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esquema</title>
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
<?php include 'layout/nav_consulta.php'; ?>
    <div class="content">
    
    <div class="row">
        <div class="col-5">

        </div>
        <div class="col-7">
            <h2 style="color:#1E90FF; font-style:italic; font-weight:bold; text-align:center;">Dra. Clara Arciniegas Vergara</h2>
            <h4 style="color:#1E90FF; text-align:center; font-style:italic;">*Esp. TAFV *Medicina Funcional/Biorreguladora *Neuralterapia</h4>
            <p style="text-align:center;">R.M. 54396-08</p>

            <p><strong>Fecha:</strong> <?php echo $fecha_actual; ?> <strong>Teléfono:</strong> <?php echo $telefono; ?></p>
            <p><strong>Nombre:</strong> <?php echo $nombre_completo; ?> <strong>CC:</strong> <?php echo $cedula; ?></p>
            
            <p><strong>R/.</strong> Buen día <?php echo $paciente['nombres']; ?>, espero que se encuentre bien, va a iniciar con este esquema que 
            le explico a continuación; el cual se realizará por fases, está individualizado de acuerdo a la consulta inicial; como le expliqué en 
            consulta para que pueda mejorar de manera integral se deben abarcar varias aristas que intervienen en la recuperación física, metabólica y emocional.
            En la medida de lo posible realizar las siguientes recomendaciones, con la consciencia y la constancia que requiere el proceso para que sea efectivo, 
            en caso de alguna duda me informa.</p>
            
            <h5>Plan:</h5>
        </div>
    </div>
    
          

    
    </div>
    <footer class="footer">
        &copy; 2025 SmartSalud.
    </footer>
</body>
</html>

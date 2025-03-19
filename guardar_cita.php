<?php
include 'layout/config.php'; // Incluir la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idpaciente = $_POST['idpaciente'];  // Cédula del paciente
    $fecha = $_POST['fecha'];            // Fecha de la cita
    $hora = $_POST['hora'];              // Hora de la cita
    $idmedico = $_POST['idmedico'];      // ID del médico (valor por defecto)
    $estado = $_POST['estado'];          // Estado (por defecto 0)

    try {
        // Preparar la consulta SQL para insertar la cita en la base de datos
        $sql = "INSERT INTO citas (idpaciente, fecha, hora, idmedico, estado, fecha_agendamiento) 
                VALUES (:idpaciente, :fecha, :hora, :idmedico, :estado, NOW())";
        $stmt = $pdo->prepare($sql);

        // Ejecutar la consulta con los valores del formulario
        $stmt->execute([
            ':idpaciente' => $idpaciente,
            ':fecha' => $fecha,
            ':hora' => $hora,
            ':idmedico' => $idmedico,
            ':estado' => $estado
        ]);

        // Redireccionar con un mensaje de éxito
        echo "<script>
                alert('Cita agendada con éxito');
                window.location.href='agenda.php';
              </script>";
    } catch (PDOException $e) {
        // Capturar cualquier error de base de datos
        die("Error al guardar la cita: " . $e->getMessage());
    }
} else {
    // Redirigir si se accede al archivo sin enviar datos por POST
    header("Location: agenda.php");
    exit();
}
?>

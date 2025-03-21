<?php
include 'layout/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = $_POST['cedula']; // Capturar la cédula correctamente

    // Capturar datos médicos
    $hijos = $_POST['hijos'];
    $religion = $_POST['religion'];
    $contacto_emergencia = $_POST['contactoemergencia'];
    $numero_emergencia = $_POST['numeroemergencia'];
    $antecedentes_personales = $_POST['antecedentespersonales'];
    $plan_tratamiento = $_POST['plantratamiento'];

    // Actualizar en la base de datos
    $query = "UPDATE pacientes SET 
                hijos = :hijos, 
                religion = :religion, 
                contacto_emergencia = :contacto_emergencia, 
                numero_emergencia = :numero_emergencia, 
                antecedentes_personales = :antecedentes_personales, 
                plan_tratamiento = :plan_tratamiento
              WHERE cedula = :cedula";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":hijos", $hijos, PDO::PARAM_STR);
        $stmt->bindParam(":religion", $religion, PDO::PARAM_STR);
        $stmt->bindParam(":contacto_emergencia", $contacto_emergencia, PDO::PARAM_STR);
        $stmt->bindParam(":numero_emergencia", $numero_emergencia, PDO::PARAM_STR);
        $stmt->bindParam(":antecedentes_personales", $antecedentes_personales, PDO::PARAM_STR);
        $stmt->bindParam(":plan_tratamiento", $plan_tratamiento, PDO::PARAM_STR);
        $stmt->bindParam(":cedula", $cedula, PDO::PARAM_STR);
        
        $stmt->execute();

        // Redireccionar después de la actualización
        header("Location: info-paciente.php?cedula=" . $cedula);
        exit();
    } catch (PDOException $e) {
        echo "Error al actualizar los datos médicos: " . $e->getMessage();
    }
} else {
    echo "Acceso denegado.";
}
?>

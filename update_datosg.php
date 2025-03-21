<?php
include 'layout/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = $_POST['cedula'];

    // Datos básicos
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $tipo_documento = $_POST['tipo_documento'];
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];
    $direccion = $_POST['direccion'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $sexo = $_POST['sexo'];
    $ocupacion = $_POST['ocupacion'];
    $estado_civil = $_POST['estadocivil'];

    // Convertir la fecha al formato correcto para MySQL
    if (!empty($_POST["fecha_nacimiento"])) {
        $fecha_nacimiento = DateTime::createFromFormat('Y-m-d\TH:i', $_POST["fecha_nacimiento"]);
        if ($fecha_nacimiento) {
            $fecha_nacimiento = $fecha_nacimiento->format('Y-m-d H:i:s');
        } else {
            $fecha_nacimiento = null; // En caso de error, asigna NULL
        }
    } else {
        $fecha_nacimiento = null;
    }

    // **CORRECCIÓN: Eliminé la coma extra después de `estado_civil = :estado_civil`**
    $query = "UPDATE pacientes SET 
                nombres = :nombres, 
                apellidos = :apellidos, 
                tipo_documento = :tipo_documento, 
                correo = :correo, 
                celular = :celular, 
                direccion = :direccion, 
                fecha_nacimiento = :fecha_nacimiento, 
                sexo = :sexo, 
                ocupacion = :ocupacion, 
                estado_civil = :estado_civil
              WHERE cedula = :cedula";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":nombres", $nombres, PDO::PARAM_STR);
        $stmt->bindParam(":apellidos", $apellidos, PDO::PARAM_STR);
        $stmt->bindParam(":tipo_documento", $tipo_documento, PDO::PARAM_STR);
        $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
        $stmt->bindParam(":celular", $celular, PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $direccion, PDO::PARAM_STR);
        $stmt->bindParam(":fecha_nacimiento", $fecha_nacimiento, PDO::PARAM_STR);
        $stmt->bindParam(":sexo", $sexo, PDO::PARAM_STR);
        $stmt->bindParam(":ocupacion", $ocupacion, PDO::PARAM_STR);
        $stmt->bindParam(":estado_civil", $estado_civil, PDO::PARAM_STR);
        $stmt->bindParam(":cedula", $cedula, PDO::PARAM_STR);
        
        $stmt->execute();

        // Redireccionar después de la actualización
        header("Location: info-paciente.php?cedula=" . $cedula);
        exit();
    } catch (PDOException $e) {
        echo "Error al actualizar los datos: " . $e->getMessage();
    }
} else {
    echo "Acceso denegado.";
}
?>

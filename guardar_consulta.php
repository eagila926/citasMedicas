<?php
include 'layout/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idpaciente = $_POST['idpaciente'];
    $idmedico = $_POST['idmedico'];
    $motivo = $_POST['motivo'];
    $talla = $_POST['talla'];
    $peso = $_POST['peso'];
    $imc = $_POST['imc'];
    $frespiratoria = $_POST['frespiratoria'];
    $temperatura = $_POST['temperatura'];
    $fcardiaca = $_POST['fcardiaca'];
    $archivo = $_POST['archivo'];

    // Insertar en la base de datos
    $query = "INSERT INTO motivo_consulta (idpaciente, idmedico, fecha, motivo, talla, peso, imc, frespiratoria, temperatura, fcardiaca, archivo) 
              VALUES (:idpaciente, :idmedico, NOW(), :motivo, :talla, :peso, :imc, :frespiratoria, :temperatura, :fcardiaca, :archivo)";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":idpaciente", $idpaciente, PDO::PARAM_STR);
        $stmt->bindParam(":idmedico", $idmedico, PDO::PARAM_STR);
        $stmt->bindParam(":motivo", $motivo, PDO::PARAM_STR);
        $stmt->bindParam(":talla", $talla, PDO::PARAM_STR);
        $stmt->bindParam(":peso", $peso, PDO::PARAM_STR);
        $stmt->bindParam(":imc", $imc, PDO::PARAM_STR);
        $stmt->bindParam(":frespiratoria", $frespiratoria, PDO::PARAM_STR);
        $stmt->bindParam(":temperatura", $temperatura, PDO::PARAM_STR);
        $stmt->bindParam(":fcardiaca", $fcardiaca, PDO::PARAM_STR);
        $stmt->bindParam(":archivo", $archivo, PDO::PARAM_STR);
        
        $stmt->execute();

        // Redirigir a esquema.php
        header("Location: esquema.php?cedula=" . $idpaciente);
        exit();
    } catch (PDOException $e) {
        echo "Error al guardar la consulta: " . $e->getMessage();
    }
} else {
    echo "Acceso denegado.";
}
?>

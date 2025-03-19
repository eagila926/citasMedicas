<?php
include 'layout/config.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idcita = $_POST['idcita'];
    $nueva_fecha = $_POST['nueva_fecha'];
    $nueva_hora = $_POST['nueva_hora'];

    try {
        $sql = "UPDATE citas SET fecha = :nueva_fecha, hora = :nueva_hora WHERE idcitas = :idcita";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nueva_fecha' => $nueva_fecha,
            ':nueva_hora' => $nueva_hora,
            ':idcita' => $idcita
        ]);

        echo "<script>
                alert('Cita reagendada con éxito');
                window.location.href='agenda.php';
              </script>";
    } catch (PDOException $e) {
        die("Error al actualizar la cita: " . $e->getMessage());
    }
} else {
    header("Location: agenda.php");
    exit();
}
?>

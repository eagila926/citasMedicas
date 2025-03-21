<?php
require 'layout/config.php'; // Asegúrate de que la ruta sea correcta

if (!isset($pdo)) {
    die("Error: No se pudo establecer la conexión a la base de datos.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
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

        $sql = "INSERT INTO pacientes (nombres, apellidos, tipo_documento, cedula, correo, celular, direccion, 
                                      fecha_nacimiento, sexo, ocupacion, estado_civil, hijos, religion, contacto_emergencia, 
                                      numero_emergencia, antecedentes_personales, antecedentes_familiares, 
                                      relaciones_familiares, enfermedad_actual, ciclo_sueno, ciclo_digestivo, dia_alimentacion, 
                                      plan_tratamiento) 
                VALUES (:nombres, :apellidos, :tipo_documento, :cedula, :correo, :celular, :direccion, 
                        :fecha_nacimiento, :sexo, :ocupacion, :estado_civil, :hijos, :religion, :contacto_emergencia, 
                        :numero_emergencia, :antecedentes_personales, :antecedentes_familiares, 
                        :relaciones_familiares, :enfermedad_actual, :ciclo_sueno, :ciclo_digestivo, :dia_alimentacion, 
                        :plan_tratamiento)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':nombres' => $_POST["nombres"],
            ':apellidos' => $_POST["apellidos"],
            ':tipo_documento' => $_POST["tipo_documento"],
            ':cedula' => $_POST["cedula"],
            ':correo' => $_POST["correo"],
            ':celular' => $_POST["celular"],
            ':direccion' => $_POST["direccion"],
            ':fecha_nacimiento' => $fecha_nacimiento,
            ':sexo' => $_POST["sexo"],
            ':ocupacion' => $_POST["ocupacion"],
            ':estado_civil' => $_POST["estadocivil"],
            ':hijos' => $_POST["hijos"],
            ':religion' => $_POST["religion"],
            ':contacto_emergencia' => $_POST["contactoemergencia"],
            ':numero_emergencia' => $_POST["numeroemergencia"],
            ':antecedentes_personales' => $_POST["antecedentespersonales"],
            ':antecedentes_familiares' => $_POST["antfamiliares"],
            ':relaciones_familiares' => $_POST["familiainterpersonal"],
            ':enfermedad_actual' => $_POST["enfermedadactual"],
            ':ciclo_sueno' => $_POST["ciclosueño"],
            ':ciclo_digestivo' => $_POST["ciclodigestivo"],
            ':dia_alimentacion' => $_POST["diaalimentacion"],
            ':plan_tratamiento' => $_POST["plantratamiento"]
        ]);

        header("Location: pacientes.php?mensaje=Paciente registrado con éxito");
        exit();
    } catch (PDOException $e) {
        die("ERROR: No se pudo ejecutar la consulta. " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas Médicas</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <meta content="Mannatthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".user-menu").click(function() {
                $(".dropdown-menu").toggle();
            });
        });
    </script>
</head>
<body>
<?php include 'layout/nav-up.php'; ?>

<div class="content">
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <h2>Registro de Paciente</h2>

            <!-- Mostrar mensaje si el paciente fue registrado con éxito -->
            <?php if(isset($_GET["mensaje"])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_GET["mensaje"]); ?>
                </div>
            <?php endif; ?>

                <form action="guardar_paciente.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nombres:</label>
                            <input type="text" name="nombres" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Apellidos:</label>
                            <input type="text" name="apellidos" class="form-control" required>
                        </div>                       
                        
                    </div>
                    <div class="row">
                        
                        <div class="col-md-6">
                        
                            <label>Tipo de Documento</label>
                            <div>
                            <select name="tipo_documento" class="form-control" required>
                                    <option>Seleecione una opcion</option>
                                    <option>Cedula</option>
                                    <option>Cedula Extranjera</option>
                                    <option>Pasaporte</option>
                                    <option>Tarjeta de identidad</option>
                                    <option>Registro Civil</option>
                                </select>
                            </div>
                                
                        </div>
                        <div class="col-md-6">
                            <label>Numero de identificacion:</label>
                            <input type="number" name="cedula" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Correo:</label>
                            <input type="email" name="correo" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Celular:</label>
                            <input type="number" name="celular" class="form-control">
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-md-12">
                            <label>Dirección:</label>
                            <input type="text" name="direccion" class="form-control">
                        </div>
                    </div>
                        
                    <div class="row">
                        <div class="col-md-6">
                            <label>Fecha de Nacimiento:</label>
                            <input type="datetime-local" name="fecha_nacimiento" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Sexo:</label>
                            <select name="sexo" class="form-control">
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Ocupación:</label>
                            <input type="text" name="ocupacion" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Estado Civil:</label>
                            <input type="text" name="estadocivil" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Hijos:</label>
                            <textarea name="hijos" class="form-control"></textarea>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label>Religión:</label>
                            <select name="religion" class="form-control">
                                <option value="Catolicismo">Catolicismo</option>
                                <option value="Protestantismo">Protestantismo / Evangelismo</option>
                                <option value="Sin afiliación">Sin afiliación religiosa</option>
                                <option value="Testigos de Jehová">Testigos de Jehová</option>
                                <option value="Mormón">Mormón</option>
                                <option value="Islam">Islam</option>
                                <option value="Judaísmo">Judaísmo</option>
                                <option value="Espiritualidad indígena">Espiritualidad indígena</option>
                                <option value="Budismo">Budismo</option>
                                <option value="Otras">Otras</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Contacto de Emergencia:</label>
                            <input type="text" name="contactoemergencia" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Número de Emergencia:</label>
                            <input type="number" name="numeroemergencia" class="form-control">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <label>Antecedentes Personales:</label>
                            <textarea name="antecedentespersonales" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Antecedentes Familiares:</label>
                            <textarea name="antfamiliares" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Relaciones familiares  e interpersonales:</label>
                            <textarea name="familiainterpersonal" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Enfermedad Actual:</label>
                            <textarea name="enfermedadactual" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Ciclo de sueño:</label>
                            <textarea name="ciclosueño" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Ciclo Digestivo:</label>
                            <textarea name="ciclodigestivo" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Día de alimentación:</label>
                            <textarea name="diaalimentacion" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Plan de tratamiento:</label>
                            <textarea name="plantratamiento" class="form-control"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Guardar Paciente</button>
                </form>
        </div>
    </div>
</div>

<footer class="footer">
    &copy; 2025 SmartSalud.
</footer>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>

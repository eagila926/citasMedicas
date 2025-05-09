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

<?php
// Obtener lista de archivos PDF en la carpeta uploads
$carpeta_libros = 'uploads/';
$libros = array_filter(scandir($carpeta_libros), function($file) use ($carpeta_libros) {
    return is_file($carpeta_libros . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
});
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

    <style>
    body, html {
        height: 100%;
        margin: 0;
        padding: 0;
        background: #ffffff;

    }

    .content {
        min-height: calc(100vh - 100px); /* Deja espacio para el footer */
        padding-bottom: 120px; /* Evita que el contenido quede debajo del footer */
    }

    .subopciones { margin-left: 20px; display: none; }
    
    .toggle-button {
        background: none;
        border: none;
        font-size: 60px;
        cursor: pointer;
        position: absolute;
        top: 10px;
        left: 10px;
    }

    .col-5, .col-7 {
        max-height: 75vh;
        overflow-y: auto;
        padding-right: 5px;
    }

    #lista-recomendaciones {
        list-style: none;
        padding-left: 2;
    }

    #lista-recomendaciones li::before {
        content: "✓ ";
        font-weight: bold;
        margin-right: 8px;
    }

    .lista-fase-personalizada {
    list-style: none;
    padding-left: 20px;
    margin-bottom: 15px;
}

    .lista-fase-personalizada li::before {
        font-weight: bold;
        margin-right: 8px;
    }

    .lista-fase-personalizada li::before {
        font-weight: bold;
        margin-right: 8px;
    }

    .fase-adaptativo li::before {
        content: "0.";
        color: #1E90FF; /* celeste */
    }

    .fase-detoxificacion li::before {
        content: "1.";
        color: #32CD32; /* verde */
    }

    .fase-recuperacion li::before {
        content: "2.";
        color: #8A2BE2; /* lila */
    }

    .fase-terreno li::before {
        content: "3.";
        color: #DC143C; /* rojo */
    }
    .text-adaptativo {
        color: #1E90FF; /* azul */
    }

    .text-detox {
        color: #32CD32; /* verde */
    }

    .text-recuperacion {
        color: #8A2BE2; /* morado */
    }

    .text-terreno {
        color: #DC143C; /* rojo */
    }

    .text-otro {
        color: #41464B; /* gris oscuro */
    }

    
</style>
    
</head>

<body>
<?php include 'layout/nav_consulta.php'; ?>
<div class="wrapper">    
    <div class="content">
    
    <div class="row">
        <div class="col-5"> 
            <!-- Botón para ocultar/mostrar "first" -->
            <button class="toggle-content btn btn-sm btn-outline-primary" data-target="#first">˄</button>
            <h5 style="margin-left: 30px">Laboratorio Funcional</h5>
            <div class="first" id="first">
                <div id="contenido-laboratorio"></div>
                <!-- AYUDAS DIAGNÓSTICAS -->
                <h5 class="mt-4">Ayudas Diagnósticas</h5>
                <div id="ayudas-diagnosticas" style="margin-bottom: 20px;"></div>

                <div class="d-flex justify-content-between mt-4">
                    <button class="btn btn-secondary" id="btn-retroceder">← Retroceder</button>
                    <a href="#" id="btn-continuar-item10" class="btn btn-success">Continuar →</a>
                </div>
            </div>
        </div>

        
        <div class="col-7">
            
            <div class="row">
                <div class="col-7">
                    <p><strong>Fecha:</strong> <?php echo $fecha_actual; ?>
                    <p><strong>Nombre:</strong> <?php echo $nombre_completo; ?>
                </div>
                <div class="col-5">
                    <strong>Teléfono:</strong> <?php echo $telefono; ?></p>
                    <strong>CC:</strong> <?php echo $cedula; ?></p>
                </div>
            </div>
            
            <p><strong>R/.</strong> Buen día <?php echo $paciente['nombres']; ?>, espero que se encuentre bien, va a iniciar con este esquema que 
            le explico a continuación; el cual se realizará por fases, está individualizado de acuerdo a la consulta inicial; como le expliqué en 
            consulta para que pueda mejorar de manera integral se deben abarcar varias aristas que intervienen en la recuperación física, metabólica y emocional.
            En la medida de lo posible realizar las siguientes recomendaciones, con la consciencia y la constancia que requiere el proceso para que sea efectivo, 
            en caso de alguna duda me informa.</p>

            <h5>Plan:</h5>
            <ol id="plan-lista"></ol>

            <p>A continuación, le explico las sugerencias e indicaciones médicas a seguir, la base del tratamiento será la alimentación que inicialmente estará 
            enfocada en retirar y mejorar lo siguiente:</p>

            <div class="alimentacion">
            </div>

            <div class="ejercicio-progre">
            </div>

            <div class="ejercicio-mental">
            </div>

            <div class="libros">
            </div>
            
            <div class="primerafase">
            </div>

            <div class="segundafase">
            </div>

            <div class="tercerafase">
            </div>

            <div class="terapian">
            </div>
            <div class="hipnosis">
            </div>
            <div class="laboratorio">
                <h4 id="titulo-laboratorio" style="margin-top:20px;"></h4>
                <div id="lista-laboratorio"></div>
                <p>(Opcional, si es posible que se los realicen por la EPS o póliza adicional lo hace si no, no se preocupe, 
                    son importantes, pero no indispensables; es para tener unos valores iniciales del estado de inflamación 
                    crónica y al finalizar evidenciar y evaluar los cambios, pero también se hacen con la clínica y la mejoría 
                    del paciente, solo si la EPS O POLIZA ADICIONAL O MEDICINA PREPAGADA los puede cubrir se los realiza)</p>        
            </div>

        </div>
    </div>
    
    </div>
    <script>

        const examenes = [
            "Hemograma Completo",
            "Ácido úrico",
            "Lonograma completo con Magnesio sérico",
            "Glucosa en ayunas y 2 horas post carga 75 grs",
            "Hemoglobina Glicosilada HbA1c",
            "Insulina Basal Pre y 2 horas Post carga 75 gramos",
            "Creatinina sérica",
            "Nitrógeno Ureico",
            "Proteína C Reactiva",
            "Lactato Deshidrogenasa (LDH)",
            "Velocidad de sedimentación globular",
            "Colesterol total",
            "Colesterol HDL",
            "Colesterol LDL",
            "Triglicéridos",
            "Hormona Estimulante de la Tiroides (TSH)",
            "T3-T4 Libre",
            "Anticuerpos anti tiroideos (TPO – ATG)",
            "Transaminasas ALT",
            "Transaminasa AST",
            "Fosfatasa Alcalina",
            "Bilirrubina total y directa",
            "Vitamina D3 (25-OH Calciferol)",
            "Niveles de Vitamina B12",
            "Niveles de Ferritina",
            "Saturación de Transferrina",
            "Niveles Hierro sérico",
            "Niveles de Homocisteina",
            "Niveles de Testosterona",
            "Coproscópico y sangre oculta en heces",
            "Uroanálisis",
            "Antígeno Prostático",
            "Niveles de Vitamina B12",
            "Perfil Lipídico completo (Colesterol total, HDL, LDL, Triglicéridos)"
        ];

        // ==== AYUDAS DIAGNÓSTICAS ====

        const ayudasDiagnosticas = [
            "Ecografía mamaria bilateral",
            "Ecografía De Hombro Bilateral (Manguito Rotador)",
            "Ecografía de Tiroides",
            "Endoscopia De Vías Digestivas Superiores",
            "Colonoscopia Bajo Sedación",
            "Rayos X De Tórax Pa Y Lateral"
        ];

        const contenedorAyudas = document.getElementById("ayudas-diagnosticas");

        // Crear grupo contenedor
        const divGrupo = document.createElement("div");
        divGrupo.classList.add("mb-3");

        // Botón para expandir/contraer
        const btnToggle = document.createElement("button");
        btnToggle.className = "btn btn-outline-secondary btn-sm mb-2";
        btnToggle.textContent = "Mostrar/Ocultar Ayudas Diagnósticas";
        btnToggle.onclick = () => {
            listaAyudas.style.display = (listaAyudas.style.display === "none") ? "block" : "none";
        };

        divGrupo.appendChild(btnToggle);

        // Lista de checkboxes
        const listaAyudas = document.createElement("div");
        listaAyudas.id = "lista-ayudas";
        listaAyudas.style.display = "none";

        ayudasDiagnosticas.forEach((ayuda, index) => {
            const div = document.createElement("div");
            div.className = "form-check";

            const checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.className = "form-check-input";
            checkbox.id = `ayuda-${index}`;
            checkbox.value = ayuda;

            const label = document.createElement("label");
            label.className = "form-check-label";
            label.htmlFor = checkbox.id;
            label.textContent = ayuda;

            checkbox.addEventListener("change", actualizarListaLaboratorio);

            div.appendChild(checkbox);
            div.appendChild(label);
            listaAyudas.appendChild(div);
        });

        // Campo personalizado
        const divPersonalizado = document.createElement("div");
        divPersonalizado.className = "input-group mt-3";

        const inputPersonalizado = document.createElement("input");
        inputPersonalizado.type = "text";
        inputPersonalizado.className = "form-control";
        inputPersonalizado.placeholder = "Agregar otra ayuda diagnóstica...";

        const btnAgregar = document.createElement("button");
        btnAgregar.className = "btn btn-primary";
        btnAgregar.textContent = "Agregar";

        btnAgregar.onclick = () => {
            const valor = inputPersonalizado.value.trim();
            if (valor) {
                const id = `personalizado-${Date.now()}`;
                const div = document.createElement("div");
                div.className = "form-check";

                const checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.className = "form-check-input";
                checkbox.id = id;
                checkbox.value = valor;
                checkbox.checked = true;

                const label = document.createElement("label");
                label.className = "form-check-label";
                label.htmlFor = id;
                label.textContent = valor;

                checkbox.addEventListener("change", actualizarListaLaboratorio);

                div.appendChild(checkbox);
                div.appendChild(label);
                listaAyudas.appendChild(div);

                actualizarListaLaboratorio();
                inputPersonalizado.value = "";
            }
        };

        divPersonalizado.appendChild(inputPersonalizado);
        divPersonalizado.appendChild(btnAgregar);

        // Armar estructura
        divGrupo.appendChild(listaAyudas);
        divGrupo.appendChild(divPersonalizado);
        contenedorAyudas.appendChild(divGrupo);


        const contenedorLaboratorio = document.getElementById("contenido-laboratorio");
        const listaLaboratorio = document.getElementById("lista-laboratorio");

        // Crear los checkboxes
        examenes.forEach((examen, index) => {
            const div = document.createElement("div");
            div.classList.add("form-check");

            const checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.className = "form-check-input";
            checkbox.id = `examen-${index}`;
            checkbox.value = examen;

            const label = document.createElement("label");
            label.className = "form-check-label";
            label.htmlFor = checkbox.id;
            label.textContent = examen;

            checkbox.addEventListener("change", function () {
                actualizarListaLaboratorio();
            });

            div.appendChild(checkbox);
            div.appendChild(label);
            contenedorLaboratorio.appendChild(div);
        });

        // Función para actualizar la lista al lado derecho
        function actualizarListaLaboratorio() {
            listaLaboratorio.innerHTML = "";

            const seleccionados = document.querySelectorAll("input[type='checkbox']:checked");

            const examenesSeleccionados = [];
            const ayudasSeleccionadas = [];

            seleccionados.forEach(chk => {
                const texto = chk.value;

                // Clasificamos por si pertenece al array de exámenes
                if (examenes.includes(texto)) {
                    examenesSeleccionados.push(texto);
                } else {
                    ayudasSeleccionadas.push(texto);
                }
            });

            // Crear y mostrar lista de exámenes
            if (examenesSeleccionados.length > 0) {
                const tituloExamenes = document.createElement("h5");
                tituloExamenes.textContent = "Laboratorio Funcional";
                listaLaboratorio.appendChild(tituloExamenes);

                const ul = document.createElement("ul");
                examenesSeleccionados.forEach(examen => {
                    const li = document.createElement("li");
                    li.textContent = examen;
                    ul.appendChild(li);
                });
                listaLaboratorio.appendChild(ul);
            }

            // Crear y mostrar lista de ayudas diagnósticas
            if (ayudasSeleccionadas.length > 0) {
                const tituloAyudas = document.createElement("h5");
                tituloAyudas.textContent = "Ayudas Diagnósticas";
                listaLaboratorio.appendChild(tituloAyudas);

                const ul = document.createElement("ul");
                ayudasSeleccionadas.forEach(ayuda => {
                    const li = document.createElement("li");
                    li.textContent = ayuda;
                    ul.appendChild(li);
                });
                listaLaboratorio.appendChild(ul);
            }
        }


        // Evento para ocultar/mostrar cada contenido de `col-5`
        $(document).on("click", ".toggle-content", function() {
            let target = $(this).data("target");
            $(target).toggle();
            $(this).text($(this).text() === "˄" ? "˅" : "˄"); // Cambiar el ícono
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Restaurar contenido del lado derecho
            if (localStorage.getItem("html_plan")) $('#plan-lista').html(localStorage.getItem("html_plan"));
            // Mostrar el título correspondiente al paso actual con índice incluido
            const pasos = parseInt(localStorage.getItem("pasos"));
            const htmlPlan = localStorage.getItem("html_plan");

            if (!isNaN(pasos) && htmlPlan) {
                const tempDiv = document.createElement("div");
                tempDiv.innerHTML = htmlPlan;
                const liItems = tempDiv.querySelectorAll("li");

                if (liItems[pasos]) {
                    const contenidoPaso = liItems[pasos].textContent.trim();
                    const numeroPaso = pasos + 1;
                    $("#titulo-laboratorio").text(`${numeroPaso}. ${contenidoPaso}`).show();
                } else {
                    $("#titulo-laboratorio").hide();
                }
            }
        });

        // Restaurar recomendaciones alimenticias previas si existen
        if (localStorage.getItem("html_alimentacion")) {
            const contenidoAlimentacion = localStorage.getItem("html_alimentacion");
            const divAlimentacion = document.querySelector(".alimentacion");

            if (divAlimentacion) {
                divAlimentacion.innerHTML = contenidoAlimentacion;
                divAlimentacion.style.marginTop = "20px";
            }
        }
        if (localStorage.getItem("html_ejercicio-progre")) {
            const contenidoEjercicio = localStorage.getItem("html_ejercicio-progre");
            const divEjercicio = document.querySelector(".ejercicio-progre");

            if (divEjercicio) {
                divEjercicio.innerHTML = contenidoEjercicio;
                divEjercicio.style.marginTop = "20px";
            }
        }
        if (localStorage.getItem("html_ejercicio-mental")) {
            const contenidoEjercicioMental = localStorage.getItem("html_ejercicio-mental");
            const divEjercicioMental = document.querySelector(".ejercicio-mental");

            if (divEjercicioMental) {
                divEjercicioMental.innerHTML = contenidoEjercicioMental;
                divEjercicioMental.style.marginTop = "20px";
            }
        }

        if (localStorage.getItem("html_libros")) {
            const contenidoLibros = localStorage.getItem("html_libros");
            const divLibros = document.querySelector(".libros");

            if (divLibros) {
                divLibros.innerHTML = contenidoLibros;
                divLibros.style.marginTop = "20px";
            }
        }

        if (localStorage.getItem("html_primerafase")) {
            const contenidoFasei = localStorage.getItem("html_primerafase");
            const divFasei = document.querySelector(".primerafase");

            if (divFasei) {
                divFasei.innerHTML = contenidoFasei;
                divFasei.style.marginTop = "20px";
            }
        }
        if (localStorage.getItem("html_segundafase")) {
            const contenidoFaseii = localStorage.getItem("html_segundafase");
            const divFaseii = document.querySelector(".segundafase");

            if (divFaseii) {
                divFaseii.innerHTML = contenidoFaseii;
                divFaseii.style.marginTop = "20px";
            }
        }
        if (localStorage.getItem("html_tercerafase")) {
            const contenidoFaseiii = localStorage.getItem("html_tercerafase");
            const divFaseiii = document.querySelector(".tercerafase");

            if (divFaseiii) {
                divFaseiii.innerHTML = contenidoFaseiii;
                divFaseiii.style.marginTop = "20px";
            }
        }
        if (localStorage.getItem("html_terapian")) {
            const contenidoTerapian = localStorage.getItem("html_terapian");
            const divTerapian = document.querySelector(".terapian");

            if (divTerapian) {
                divTerapian.innerHTML = contenidoTerapian;
                divTerapian.style.marginTop = "20px";
            }
        }
        if (localStorage.getItem("html_hipnosis")) {
            const contenidoHipnosis = localStorage.getItem("html_hipnosis");
            const divHipnosis = document.querySelector(".hipnosis");

            if (divHipnosis) {
                divHipnosis.innerHTML = contenidoHipnosis;
                divHipnosis.style.marginTop = "20px";
            }
        }

        //continuar flujo

        $(document).on("click", "#btn-continuar-item10", function (e) {
            e.preventDefault();
            continuarFlujo("laboratorio", "html_laboratorio");
        });

        function continuarFlujo(nombreClase, variableLocalStorage, alertaSiNo = true) {
            const pasos = parseInt(localStorage.getItem("pasos") || "0") + 1;
            localStorage.setItem("pasos", pasos);

            const htmlPlan = localStorage.getItem("html_plan");
            if (!htmlPlan) {
                alert("No hay plan cargado.");
                return;
            }

            const tempDiv = document.createElement("div");
            tempDiv.innerHTML = htmlPlan;
            const liItems = tempDiv.querySelectorAll("li");

            if (liItems[pasos]) {
                const textoItem = liItems[pasos].textContent.trim();
                const palabras = textoItem.split(" ");
                const claveBusqueda = palabras.slice(0, 2).join(" ").toUpperCase();

                const mapaRedireccion = {
                    "EJERCICIO PROGRESIVO": "ejercicio_progresivo.php",
                    "EJERCICIOS DE": "ejercicio_relajacion.php",
                    "LIBROS DE": "libros_metabolismo.php",
                    "FASE I": "fase_i.php",
                    "FASE II": "fase_ii.php",
                    "FASE III": "fase_iii.php",
                    "TERAPIA NEURAL": "terapia_neural.php",
                    "CANDIDATO A": "hipnosis.php",
                    "LABORATORIO FUNCIONAL": "laboratorio.php"
                };

                const archivo = mapaRedireccion[claveBusqueda];
                if (archivo) {
                    const cedula = "<?php echo $cedula_paciente; ?>";

                    // Guardar contenido dinámico
                    const contenido = document.querySelector(`.${nombreClase}`)?.innerHTML || "";
                    localStorage.setItem(variableLocalStorage, contenido);

                    // Redirigir
                    window.location.href = `${archivo}?cedula=${cedula}`;
                } else if (alertaSiNo) {
                    alert(`No se encontró una ruta para el ítem del paso ${pasos + 1}: "${claveBusqueda}"`);
                }
            } else if (alertaSiNo) {
                // Guardar todo el contenido de .col-7 en el localStorage
                const contenidoLab = document.querySelector(".laboratorio")?.innerHTML || "";
                localStorage.setItem("html_laboratorio", contenidoLab);

                const contenidoResumen = document.querySelector(".col-7")?.innerHTML || "";
                localStorage.setItem("html_resumen", contenidoResumen);

                alert("Ya no hay más pasos en el plan. Se ha guardado el esquema completo.");
                
                // Redireccionar a resumen-esquema.php si lo deseas automáticamente:
                const cedula = "<?php echo $cedula_paciente; ?>";
                window.location.href = `resumen-esquema.php?cedula=${cedula}`;
            }
        }


        $(document).on("click", "#btn-retroceder", function (e) {
            e.preventDefault();
            retrocederFlujo();
        });


        function retrocederFlujo(alertaSiNo = true) {
            let pasos = parseInt(localStorage.getItem("pasos") || "0");

            if (pasos <= 0) {
                if (alertaSiNo) alert("Ya estás en el primer paso del plan.");
                return;
            }

            pasos -= 1;
            localStorage.setItem("pasos", pasos);

            const htmlPlan = localStorage.getItem("html_plan");
            if (!htmlPlan) {
                alert("No hay plan cargado.");
                return;
            }

            const tempDiv = document.createElement("div");
            tempDiv.innerHTML = htmlPlan;
            const liItems = tempDiv.querySelectorAll("li");

            if (liItems[pasos]) {
                const textoItem = liItems[pasos].textContent.trim();
                const palabras = textoItem.split(" ");
                const claveBusqueda = palabras.slice(0, 2).join(" ").toUpperCase();

                const mapaRedireccion = {
                    "EJERCICIO PROGRESIVO": "ejercicio_progresivo.php",
                    "EJERCICIOS DE": "ejercicio_relajacion.php",
                    "LIBROS DE": "libros_metabolismo.php",
                    "FASE I": "fase_i.php",
                    "FASE II": "fase_ii.php",
                    "FASE III": "fase_iii.php",
                    "TERAPIA NEURAL": "terapia_neural.php",
                    "CANDIDATO A": "hipnosis.php",
                    "LABORATORIO FUNCIONAL": "laboratorio.php"
                };

                const archivo = mapaRedireccion[claveBusqueda];
                if (archivo) {
                    const cedula = "<?php echo $cedula_paciente; ?>";
                    window.location.href = `${archivo}?cedula=${cedula}`;
                } else if (alertaSiNo) {
                    alert(`No se encontró una ruta para el paso anterior: "${claveBusqueda}"`);
                }
            } else if (alertaSiNo) {
                alert("No se encontró el paso anterior en el plan.");
            }
        }

</script>

</div>
</body>
</html>

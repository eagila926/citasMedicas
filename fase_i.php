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

    .checkbox-color {
        padding: 8px;
        border-radius: 6px;
        display: inline-block;
        width: 100%;
        font-weight: bold;
    }

    .manejo-adaptativo {
        background-color: #E2E3E5; /* verde suave */
        color: #1E90FF;
    }

    .detox {
        background-color: #E2E3E5; /* amarillo suave */
        color: #32CD32;
    }

    .recuperacion {
        background-color: #E2E3E5; /* rosado claro */
        color: #8A2BE2;
    }

    .terreno {
        background-color: #E2E3E5; /* celeste */
        color: #DC143C;
    }

    .otro {
        background-color: #E2E3E5; /* gris claro */
        color: #41464B;
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
            <h5 style="margin-left: 30px">MANEJO DE MEDICAMENTOS</h5>
            <div class="first" id="first">
                <div id="contenido-quinto">
                <div id="checkboxes-manejo" class="mb-3">
                    <label class="checkbox-color manejo-adaptativo"><input type="checkbox" class="fase-checkbox" value="MANEJO ADAPTATIVO INICIAL"> MANEJO ADAPTATIVO INICIAL</label><br>
                    <label class="checkbox-color detox"><input type="checkbox" class="fase-checkbox" value="DETOXIFICACIÓN Y REMOCIÓN MICROBIOLÓGICA ORAL"> DETOXIFICACIÓN Y REMOCIÓN MICROBIOLÓGICA ORAL</label><br>
                    <label class="checkbox-color recuperacion"><input type="checkbox" class="fase-checkbox" value="RECUPERACIÓN DE LA MUCOSA Y BARRERA GASTROINTESTINAL"> RECUPERACIÓN DE LA MUCOSA Y BARRERA GASTROINTESTINAL</label><br>
                    <label class="checkbox-color terreno"><input type="checkbox" class="fase-checkbox" value="MANEJO DE TERRENO (D. I - VI)"> MANEJO DE TERRENO (D. I - VI)</label><br>
                    <label class="checkbox-color otro"><input type="checkbox" class="fase-checkbox" value="OTRO PRODUCTO"> OTRO PRODUCTO</label>
                </div>
                    <div id="buscadores-productos"></div>                    
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button class="btn btn-secondary" id="btn-retroceder">← Retroceder</button>
                    <a href="#" id="btn-continuar-item6" class="btn btn-success">Continuar →</a>
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
                <h4 id="titulo-primerafase" style="margin-top:20px;"></h4> <p style="font-size:25"><strong>Manejo con medicamentos indicados así:</strong></p>
                <div id="lista-primerafase" contenteditable="true" style="padding:10px; border-radius:8px;"></div>
            </div>

        </div>
    </div>
    
    </div>
    <script>
        function generarClaseDesdeTexto(texto) {
            return texto.replace(/[^a-zA-Z0-9]/g, "-");
        }

                    
        $(document).on("change", ".fase-checkbox", function () {
            const valor = $(this).val();
            const resumen = $("#lista-primerafase");
            const contenedorBuscadores = $("#buscadores-productos");

            if ($(this).is(":checked")) {
                // Agregar al resumen si no está ya
                if (!resumen.find(`.item-fase:contains("${valor}")`).length) {
                    const claseSanitizada = generarClaseDesdeTexto(valor);
                    let claseTema = ""; // clase extra para estilo por palabra clave
                    let claseColor = ""; // clase para el color del <strong>

                    const normalizado = valor.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();

                    if (normalizado.includes("adaptativo")) {
                        claseTema = "fase-adaptativo";
                        claseColor = "text-adaptativo";
                    } else if (normalizado.includes("detox")) {
                        claseTema = "fase-detoxificacion";
                        claseColor = "text-detox";
                    } else if (normalizado.includes("recuperacion")) {
                        claseTema = "fase-recuperacion";
                        claseColor = "text-recuperacion";
                    } else if (normalizado.includes("terreno")) {
                        claseTema = "fase-terreno";
                        claseColor = "text-terreno";
                    } else if (normalizado.includes("otro producto")) {
                        claseColor = "text-otro";
                    }

                    resumen.append(`
                        <div class="item-fase">
                            <strong class="${claseColor}">${valor}</strong>
                            <ul class="productos-${claseSanitizada} lista-fase-personalizada ${claseTema}"></ul>
                        </div>
                    `);
                }

                if (valor === "OTRO PRODUCTO") {
                    const customInputHTML = `
                        <div class="buscador-producto mt-2" data-key="${valor}">
                            <label><strong>Ingrese el nombre y descripción del producto personalizado:</strong></label>
                            <input type="text" class="form-control mt-1 otro-nombre" placeholder="Nombre del producto">
                            <textarea class="form-control mt-2 otro-descripcion" placeholder="Descripción del producto"></textarea>
                            <button class="btn btn-sm btn-primary mt-2 agregar-otro">Agregar</button>
                        </div>
                    `;
                    contenedorBuscadores.append(customInputHTML);

                    if (!resumen.find(`.item-fase:contains("${valor}")`).length) {
                        const claseSanitizada = generarClaseDesdeTexto(valor);
                        resumen.append(`<div class="item-fase"><strong>${valor}</strong><ul class="productos-${claseSanitizada}"></ul></div>`);
                    }
                    return;
                }

                // Agregar input de búsqueda
                const buscadorHTML = `
                    <div class="buscador-producto mt-2" data-key="${valor}">
                        <label>Buscar producto para <strong>${valor}</strong>:</label>
                        <input type="text" class="form-control buscador-input" data-fase="${valor}" placeholder="Escriba el nombre del producto...">
                        <ul class="sugerencias list-group mt-1"></ul>
                    </div>
                `;
                contenedorBuscadores.append(buscadorHTML);
            } else {
                // Eliminar del resumen
                resumen.find(`.item-fase:contains("${valor}")`).remove();
                // Eliminar input
                contenedorBuscadores.find(`.buscador-producto[data-key="${valor}"]`).remove();
            }
        });

        $(document).on("click", ".agregar-otro", function () {
            const contenedor = $(this).closest(".buscador-producto");
            const nombre = contenedor.find(".otro-nombre").val().trim();
            const descripcion = contenedor.find(".otro-descripcion").val().trim();

            if (nombre !== "" && descripcion !== "") {
                const fase = "OTRO PRODUCTO";
                const claseLista = `.productos-${generarClaseDesdeTexto(fase)}`;
                const lista = $(claseLista);

                if (!lista.find(`li:contains("${nombre}")`).length) {
                    lista.append(`<li><strong>${nombre}</strong>: ${descripcion}</li>`);
                    contenedor.find(".otro-nombre").val("");
                    contenedor.find(".otro-descripcion").val("");
                }
            } else {
                alert("Por favor completa el nombre y la descripción del producto.");
            }
        });


        // Búsqueda dinámica
        $(document).on("input", ".buscador-input", function () {
            const query = $(this).val();
            const ulSugerencias = $(this).siblings(".sugerencias");
            const fase = $(this).data("fase");
            
            if (query.length >= 2) {
                $.getJSON("buscar-producto.php?q=" + query, function (data) {
                    ulSugerencias.empty();
                    data.forEach(item => {
                        ulSugerencias.append(`<li class="list-group-item sugerencia-item" data-nombre="${item.nombre_producto}" data-desc="${item.descripcion}" data-fase="${fase}">${item.nombre_producto} - ${item.descripcion}</li>`);
                    });
                });
            } else {
                ulSugerencias.empty();
            }
        });

        // Al hacer clic en una sugerencia
        $(document).on("click", ".sugerencia-item", function () {
            const nombre = $(this).data("nombre");
            const descripcion = $(this).data("desc");
            const fase = $(this).data("fase");

            const claseLista = `.productos-${generarClaseDesdeTexto(fase)}`;
            const lista = $(claseLista);

            if (!lista.find(`li:contains("${nombre}")`).length) {
                lista.append(`<li><strong>${nombre}</strong>: ${descripcion}</li>`);
            }

            // Limpiar sugerencias
            $(this).closest(".sugerencias").empty();
        });

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
                    $("#titulo-primerafase").text(`${numeroPaso}. ${contenidoPaso}`).show();
                } else {
                    $("#titulo-primerafase").hide();
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

        //continuar flujo

        $(document).on("click", "#btn-continuar-item6", function (e) {
            e.preventDefault();
            continuarFlujo("primerafase", "html_primerafase");
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

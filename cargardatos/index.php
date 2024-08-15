<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Carga de Datos</title>
    <link rel="stylesheet" href="formulario.css">
</head>
<body>
    <div class="form-container">
        <h2>Formulario de Carga de Datos</h2>
        <form action="process.php" method="post" id="dataForm">
            <label for="tabla">Seleccionar tabla:</label>
            <select id="tabla" name="tabla" onchange="mostrarCampos()" required>
                <option value="">--Selecciona una tabla--</option>
                <option value="carrera">Carrera</option>
                <option value="contacto">Contacto</option>
                <option value="distrito">Distrito</option>
                <option value="establecimiento">Establecimiento</option>
                <option value="imagenes">Imágenes</option>
                <option value="planestudio">Plan de Estudio</option>
            </select>

            <!-- Contenedor para los campos dinámicos -->
            <div id="formFields"></div>

            <input type="submit" value="Enviar">
        </form>
    </div>

    <script>
        function mostrarCampos() {
            var tabla = document.getElementById("tabla").value;
            var formFields = document.getElementById("formFields");
            formFields.innerHTML = '';  // Limpiar campos anteriores

            if (tabla === "carrera") {
                formFields.innerHTML = `
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                    <label for="descripcion">Descripción:</label>
                    <input type="text" id="descripcion" name="descripcion" required>
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required>
                `;
            } else if (tabla === "contacto") {
                formFields.innerHTML = `
                    <label for="descripcion">Descripción:</label>
                    <input type="text" id="descripcion" name="descripcion" required>
                    <label for="tipo">Tipo:</label>
                    <input type="text" id="tipo" name="tipo" required>
                    <label for="contacto">Contacto:</label>
                    <input type="text" id="contacto" name="contacto" required>
                    <label for="fk_establecimiento">FK Establecimiento:</label>
                    <input type="text" id="fk_establecimiento" name="fk_establecimiento" required>
                `;
            } else if (tabla === "distrito") {
                formFields.innerHTML = `
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                `;
            } else if (tabla === "establecimiento") {
                formFields.innerHTML = `
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                    <label for="ubicacion">Ubicación:</label>
                    <input type="text" id="ubicacion" name="ubicacion" required>
                    <label for="descripcion">Descripción:</label>
                    <input type="text" id="descripcion" name="descripcion" required>
                    <label for="tipo_establecimiento">Tipo de Establecimiento:</label>
                    <input type="text" id="tipo_establecimiento" name="tipo_establecimiento" required>
                    <label for="servicios">Servicios:</label>
                    <input type="text" id="servicios" name="servicios" required>
                    <label for="fk_distrito">FK Distrito:</label>
                    <input type="text" id="fk_distrito" name="fk_distrito" required>
                `;
            } else if (tabla === "imagenes") {
                formFields.innerHTML = `
                    <label for="url">URL:</label>
                    <input type="text" id="url" name="url" required>
                    <label for="fk_establecimiento">FK Establecimiento:</label>
                    <input type="text" id="fk_establecimiento" name="fk_establecimiento" required>
                `;
            } else if (tabla === "planestudio") {
                formFields.innerHTML = `
                    <label for="pdf">PDF:</label>
                    <input type="text" id="pdf" name="pdf" required>
                    <label for="fk_carrera">FK Carrera:</label>
                    <input type="text" id="fk_carrera" name="fk_carrera" required>
                    <label for="fk_establecimiento">FK Establecimiento:</label>
                    <input type="text" id="fk_establecimiento" name="fk_establecimiento" required>
                `;
            }
        }
    </script>
</body>
</html>

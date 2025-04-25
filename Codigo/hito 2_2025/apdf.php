<?php
// Configuración de la conexión
$servername = "localhost"; // Ajusta el puerto si es necesario
$username = "root";
$password = "";
$dbname = "vigifia";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para insertar PDF
function insertarPDF($conn, $titulo, $descripcion, $parametros, $estado, $ruta_pdf) {
    // Preparar la consulta
    $sql = "INSERT INTO borradores (titulo, descripcion, pdf_url, parametros, estado) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Error al preparar la consulta: " . $conn->error;
        return false;
    }

    // Enlazar los parámetros
    $stmt->bind_param("sssss", $titulo, $descripcion, $ruta_pdf, $parametros, $estado);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Archivo PDF $titulo insertado correctamente.<br>";
    } else {
        echo "Error al insertar el archivo PDF $titulo: " . $stmt->error . "<br>";
    }

    $stmt->close();
}

// Insertar varios PDFs
insertarPDF($conn, "Adaptación y mitigación al cambio climático", "Este boletín presenta estrategias del Ministerio de Agricultura para enfrentar el cambio climático, incluyendo medidas de adaptación y acciones de mitigación sostenibles.", "Adaptación climática, Agricultura sostenible", "En revisión", "pdf/1.pdf");
insertarPDF($conn, "Modelos de IA capaces de predecir condiciones futuras de sequía", "Este boletín destaca el avance de científicos que han desarrollado modelos de inteligencia artificial para predecir condiciones futuras de sequía. Estas herramientas permiten mejorar la planificación agrícola y la gestión de recursos hídricos, contribuyendo a una mayor resiliencia frente al cambio climático.", "Sequías, Inteligencia artifical agrícola", "En revisión", "pdf/2.pdf");
insertarPDF($conn, "Gestión sostenible de recursos hídricos", "Este boletín explora estrategias para gestionar de manera sostenible los recursos hídricos en la agricultura. Se presentan iniciativas que promueven el uso eficiente del agua y la conservación de cuencas, adoptando tecnologías innovadoras para un acceso responsable.", "Uso eficiente del agua, Conservación hídrica", "En revisión", "pdf/3.pdf");
insertarPDF($conn, "La importancia de invertir en tecnologías para el uso eficiente del agua en la agricultura", "Este boletín resalta la inversión en tecnologías para el uso eficiente del agua en agricultura, optimizando recursos y mejorando la sostenibilidad del sector.", "Riego, Agricultura sostenible", "En revisión", "pdf/4.pdf");
insertarPDF($conn, "La papa cultivada en laboratorio resolvería un problema de almacenamiento", "Este boletín examina cómo la papa cultivada en laboratorio podría resolver problemas de almacenamiento, aumentando la resistencia y reduciendo pérdidas postcosecha.", "Papa, Postcosecha", "En revisión", "pdf/5.pdf");

// Cerrar la conexión
$conn->close();
?>
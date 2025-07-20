<?php
session_start();
if (!isset($_SESSION['estudiante'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['estudiante']['usuario_id'] ?? null;
if (!$usuario_id) {
    die("ID del estudiante no disponible");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Seguimiento de Reclamos</title>
    <link rel="stylesheet" href="Estilos/stylesGenerales.css">
    <link rel="stylesheet" href="Estilos/camposEstudiante_styles.css">
</head>

<body>

    <div class="sidebar">
        <h1 class="logo-title">UTP<span style="color:red;">+</span>notes</h1>
        <br>
        <div class="notificaciones">
            <h3>Menú Alumno</h3>
            <p><a href="dashboard.php" style="color:white;">← Volver al Panel</a></p>
        </div>
    </div>

    <div class="contenido-principal">
        <div class="titulo">🔎 Seguimiento de tus Reclamos</div>

        <table id="tabla-seguimiento">
            <thead>
                <tr>
                    <th>ID del Reclamo</th>
                    <th>Estado</th>
                    <th>Comentario</th>
                    <th>Fecha</th>
                    <th>Actualizado Por</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <script>
        const ESTUDIANTE_ID = <?= intval($usuario_id) ?>;
    </script>

    <script src="JavaFunciones/camposEstudiante_java.js"></script>

</body>

</html>
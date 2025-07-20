<?php
session_start();
if (!isset($_SESSION['estudiante'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['estudiante']['usuario'];
$nombre = $_SESSION['estudiante']['nombre'] ?? '';
$ver_todas = isset($_GET['ver_todas']) && $_GET['ver_todas'] === '1';

function obtenerNotificaciones($correo, $limite = 0) {
    $correoUrl = urlencode($correo);
    $url = "http://localhost:5000/notificaciones?usuario=$correoUrl";
    $respuesta = @file_get_contents($url);
    if ($respuesta === FALSE) return [];

    $datos = json_decode($respuesta, true);
    return ($limite > 0) ? array_slice($datos, 0, $limite) : $datos;
}

$notificaciones_totales = obtenerNotificaciones($usuario, 0);
$notificaciones = $ver_todas ? $notificaciones_totales : array_slice($notificaciones_totales, 0, 5);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Reclamos UTP - Estudiante</title>
    <link rel="stylesheet" href="Estilos/dashboards_styles.css">
    <link rel="stylesheet" href="Estilos/stylesGenerales.css">
</head>

<body>
    <div class="sidebar">
        <h1 class="logo-title">UTP<span style="color:red;">+</span>notes</h1>
        <br>
        <div class="notificaciones">
            <h3 class="noti-toggle">
                <span class="toggle-icon">▾</span> Notificaciones
            </h3>
            <div class="coordinador-noti-content">
                <?php if (count($notificaciones) === 0): ?>
                <p>No tienes notificaciones recientes.</p>
                <?php else: ?>
                <?php foreach ($notificaciones as $n): ?>
                <div class="noti-wrapper" id="noti-<?= htmlspecialchars($n['id']) ?>">
                    <button class="boton-eliminar"
                        onclick="eliminarNotificacion('<?= htmlspecialchars($n['id']) ?>')">✖</button>
                    <p>
                        <strong>
                            <?= htmlspecialchars($n['titulo']) ?>
                        </strong>:
                        <?= htmlspecialchars($n['mensaje']) ?><br>
                        <em>
                            <?= htmlspecialchars($n['fecha_envio']) ?>
                        </em> -
                        <?= htmlspecialchars($n['estado']) ?>
                    </p>
                </div>
                <?php endforeach; ?>

                <?php if (!$ver_todas && count($notificaciones_totales) > 5): ?>
                <a href="?ver_todas=1" class="btn-toggle">🔽 Ver todas las notificaciones</a>
                <?php elseif ($ver_todas): ?>
                <a href="dashboard_estudiante.php" class="btn-toggle">⬅ Ver más recientes</a>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="main">
        <div class="main-header">
            <h1>Panel de Estudiante</h1>
            <div class="user-info">
                <span>
                    <?= htmlspecialchars($nombre); ?> (
                    <?= htmlspecialchars($usuario); ?>) ▾
                </span>
                <div class="user-menu">
                    <a href="logout.php">Cerrar Sesión</a>
                </div>
            </div>
        </div>

        <div class="cards-container">
            <a href="registro.php" class="card">
                <h3>Registrar Reclamo</h3>
                <p>Envía un nuevo reclamo relacionado a tus cursos.</p>
            </a>
            <a href="seguimiento.php" class="card">
                <h3>Seguimiento de Reclamos</h3>
                <p>Consulta el estado de tus reclamos enviados.</p>
            </a>
            <a href="cursos.php" class="card">
                <h3>Ver Cursos y Notas</h3>
                <p>Consulta los cursos matriculados y tus calificaciones.</p>
            </a>
        </div>
        <div style="text-align:center; margin-top:30px;">
            <img src="img/lapiz.jpeg" alt="Imagen Dashboard" style="max-width:800px; border-radius:15px;">
        </div>
    </div>

    <script src="JavaFunciones/dashboards_java.js"></script>

</body>

</html>
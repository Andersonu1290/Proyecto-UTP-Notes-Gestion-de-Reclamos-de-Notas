<?php
session_start();
if (!isset($_SESSION['coordinador'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['coordinador']['usuario'];
$nombre = $_SESSION['coordinador']['nombre'] ?? '';

function obtenerNotificaciones($correo) {
    $correoUrl = urlencode($correo);
    $url = "http://localhost:5000/notificaciones?usuario=$correoUrl";
    $respuesta = @file_get_contents($url);
    if ($respuesta === FALSE) return [];
    $datos = json_decode($respuesta, true);
    return $datos ?: [];
}

$notificaciones = obtenerNotificaciones($usuario);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Reclamos UTP - Coordinador</title>
    <link rel="stylesheet" href="Estilos/stylesGenerales.css">
    <link rel="stylesheet" href="Estilos/dashboards_styles.css">
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
                <?php $estadoClase = strtolower($n['estado']); ?>
                <div class="noti-wrapper" id="noti-<?= htmlspecialchars($n['id']) ?>">
                    <button class="boton-eliminar"
                        onclick="eliminarNotificacion('<?= htmlspecialchars($n['id']) ?>')">✖</button>
                    <div class="noti coordinador-noti-<?= $estadoClase ?>">
                        <strong>
                            <?= htmlspecialchars($n['titulo']) ?>
                        </strong>:
                        <?= htmlspecialchars($n['mensaje']) ?><br>
                        <em>
                            <?= date('d/m/Y H:i', strtotime($n['fecha_envio'])) ?>
                        </em> -
                        <?= htmlspecialchars($n['estado']) ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="main">
        <div class="main-header">
            <h1>Panel de Coordinador</h1>
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
            <a href="revisar_reclamos_coordinador.php" class="card">
                <h3>Revisar Reclamos Estudiantes</h3>
                <p>Revisa los reclamos pendientes y asigna un profesor responsable.</p>
            </a>

            <a href="ver_registros_sesiones.php" class="card">
                <h3>Registro de Sesiones</h3>
                <p>Ver historial de inicios y cierres de sesión de todos los usuarios.</p>
            </a>

            <a href="ver_profesores.php" class="card">
                <h3>Profesores UTP</h3>
                <p>Consulta todos los datos de los docentes registrados.</p>
            </a>

            <a href="ver_estudiantes.php" class="card">
                <h3>Estudiantes UTP</h3>
                <p>Consulta todos los estudiantes registrados en la universidad.</p>
            </a>

        </div>
        <div style="text-align:center; margin-top:30px;">
            <img src="img/lapiz coor.jpeg" alt="Imagen Dashboard" style="max-width:800px; border-radius:15px;">
        </div>
    </div>

    <script src="JavaFunciones/dashboards_java.js"></script>

</body>

</html>
<?php
session_start();
if (!isset($_SESSION['profesor'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['profesor']['usuario'];
$nombre = $_SESSION['profesor']['nombre'] ?? '';
$ver_todas = isset($_GET['ver_todas']) && $_GET['ver_todas'] === '1';

function obtenerNotificaciones($correo, $limite = 5) {
    $correoUrl = urlencode($correo);
    $url = "http://localhost:5000/notificaciones?usuario=$correoUrl&limite=$limite";
    $respuesta = @file_get_contents($url);
    if ($respuesta === FALSE) return [];
    $datos = json_decode($respuesta, true);
    return $datos ?: [];
}

$notificaciones = obtenerNotificaciones($usuario, $ver_todas ? 999 : 5);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Reclamos UTP - Docente</title>
    <link rel="stylesheet" href="Estilos/stylesGenerales.css">
    <link rel="stylesheet" href="Estilos/dashboards_styles.css">

</head>

<body>
    <div class="sidebar">
        <h1 class="logo-title">UTP<span style="color:red;">+</span>notes</h1>
        <br>
        <div class="notificaciones">
            <h3 class="noti-toggle" style="cursor:pointer;">
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

                <?php if (!$ver_todas && count($notificaciones) === 5): ?>
                <a href="?ver_todas=1" class="btn-toggle">🔽 Ver todas las notificaciones</a>
                <?php elseif ($ver_todas): ?>
                <a href="dashboard_docente.php" class="btn-toggle">⬅ Ver más recientes</a>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="main">
        <div class="main-header">
            <h1>Panel de Control Docente</h1>
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
            <a href="revisar_reclamos.php" class="card">
                <h3>Revisar Reclamos</h3>
                <p>Consulta los reclamos asignados a ti por el coordinador.</p>
            </a>
            <a href="estudiantes_del_profesor.php" class="card">
                <h3>Estudiantes de Mis Cursos</h3>
                <p>Consulta la lista de estudiantes según los cursos que dictas.</p>
            </a>
        </div>
        <div style="text-align:center; margin-top:30px;">
            <img src="img/lapiz docen.jpeg" alt="Imagen Dashboard" style="max-width:800px; border-radius:15px;">
        </div>
    </div>

    <script src="JavaFunciones/dashboards_java.js"></script>
    
</body>

</html>
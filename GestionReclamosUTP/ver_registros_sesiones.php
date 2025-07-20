<?php
session_start();
if (!isset($_SESSION['coordinador'])) {
    header("Location: login.php");
    exit();
}

require_once 'redis.php';

$usuario = $_SESSION['coordinador']['usuario'];
$nombre = $_SESSION['coordinador']['nombre'] ?? '';
$eventos = $redis->lrange('registro_sesiones', 0, -1);
$registros = [];

foreach ($eventos as $eventoJson) {
    $data = json_decode($eventoJson, true);
    if ($data)
        $registros[] = $data;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Sesiones</title>
    <link rel="stylesheet" href="Estilos/stylesGenerales.css">
    <link rel="stylesheet" href="Estilos/camposCoordinador_styles.css">
</head>

<body>

    <div class="sidebar">
        <h1 class="logo-title">UTP<span style="color:red;">+</span>notes</h1>
        <br>
        <div class="notificaciones">
            <h3>Menú Coordinador</h3>
            <p><a href="dashboard_coordinador.php" style="color:white;">← Volver al Panel</a></p>
        </div>
    </div>

    <div class="main">
        <div class="main-header">
            <h1>🕓 Registro de Sesiones</h1>
        </div>

        <div class="card">
            <?php if (empty($registros)): ?>
            <p style="text-align:center; color:#555;">No hay registros recientes de inicio de sesión.</p>
            <?php else: ?>
            <table class="tabla-notas">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Evento</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = count($registros);
                        foreach ($registros as $registro): ?>
                    <tr>
                        <td>
                            <?= $i-- ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($registro['usuario'] ?? '-') ?>
                        </td>
                        <td>
                            <?= ucfirst(htmlspecialchars($registro['rol'] ?? '-')) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($registro['evento'] ?? '-') ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($registro['fecha'] ?? '-') ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>

            <a href="dashboard_coordinador.php" class="volver">← Volver al Panel</a>
        </div>
    </div>

</body>

</html>
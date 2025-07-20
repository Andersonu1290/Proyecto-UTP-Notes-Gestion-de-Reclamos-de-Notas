<?php
session_start();
if (!isset($_SESSION['coordinador'])) {
    header("Location: login.php");
    exit();
}

ob_start();
require_once 'mysql.php';
ob_end_clean();

$usuario = $_SESSION['coordinador']['usuario'];
$nombre = $_SESSION['coordinador']['nombre'] ?? '';

$resultado = $mysql->query("SELECT * FROM profesores ORDER BY id ASC");
$profesores = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Profesores UTP</title>
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
            <h1>👨‍🏫 Profesores Registrados</h1>
        </div>

        <div class="card">
            <?php if (empty($profesores)): ?>
            <p style="text-align:center; color:#555;">No se encontraron profesores registrados.</p>
            <?php else: ?>
            <table class="tabla-notas">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>DNI</th>
                        <th>Especialidad</th>
                        <th>Fecha Ingreso</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($profesores as $prof): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($prof['id']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($prof['nombre_completo']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($prof['correo']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($prof['dni']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($prof['especialidad']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($prof['fecha_ingreso']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($prof['telefono']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($prof['direccion']) ?>
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
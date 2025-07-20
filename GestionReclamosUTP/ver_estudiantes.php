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

$resultado = $mysql->query("SELECT * FROM estudiantes ORDER BY id ASC");
$estudiantes = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Estudiantes UTP</title>
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
            <h1>🎓 Estudiantes Registrados</h1>
        </div>

        <div class="card">
            <?php if (empty($estudiantes)): ?>
            <p style="text-align:center; color:#555;">No se encontraron estudiantes registrados.</p>
            <?php else: ?>
            <table class="tabla-notas">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>DNI</th>
                        <th>Carrera</th>
                        <th>Ciclo</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estudiantes as $est): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($est['id']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($est['nombre_completo']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($est['correo']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($est['dni']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($est['carrera']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($est['ciclo']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($est['telefono']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($est['direccion']) ?>
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
<?php
session_start();

if (!isset($_SESSION['estudiante'])) {
    header("Location: login.php");
    exit();
}

require_once 'postgresql.php';
require_once 'mysql.php';

$usuario = $_SESSION['estudiante']['usuario'];
$nombre = $_SESSION['estudiante']['nombre'] ?? '';
$estudiante_id = $_SESSION['estudiante']['usuario_id'] ?? null;

if (!$estudiante_id) {
    die("ID de usuario no encontrado en la sesión.");
}

$stmt = $pg_conn->prepare("
    SELECT 
        c.nombre AS nombre_curso, 
        c.codigo AS codigo_curso,
        n.nota, 
        n.tipo_evaluacion, 
        n.observacion,
        n.id_profesor
    FROM notas n
    JOIN cursos c ON c.id = n.curso_id
    WHERE n.estudiante_id = :estudiante_id
");
$stmt->bindParam(':estudiante_id', $estudiante_id, PDO::PARAM_INT);
$stmt->execute();
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($datos as &$fila) {
    $id_profesor = $fila['id_profesor'] ?? null;
    $nombre_docente = 'Desconocido';

    if ($id_profesor !== null) {
        $stmt_mysql = $mysql->prepare("SELECT nombre_completo FROM profesores WHERE id = ?");
        $stmt_mysql->bind_param("i", $id_profesor);
        $stmt_mysql->execute();
        $res = $stmt_mysql->get_result();
        if ($fila_prof = $res->fetch_assoc()) {
            $nombre_docente = $fila_prof['nombre_completo'];
        }
        $stmt_mysql->close();
    }

    $fila['nombre_docente'] = $nombre_docente;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mis Cursos y Notas</title>
    <link rel="stylesheet" href="Estilos/camposEstudiante_styles.css">
    <link rel="stylesheet" href="Estilos/stylesGenerales.css">
</head>

<body>

    <div class="sidebar">
        <h1 class="logo-title">UTP<span style="color:red;">+</span>notes</h1>
        <br>
        <div class="notificaciones">
            <h3>Menú Estudiante</h3>
            <p><a href="dashboard.php" style="color:white;">← Volver al Panel</a></p>
        </div>
    </div>

    <div class="main">
        <div class="main-header">
            <h1>📚 Mis Cursos y Notas</h1>
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

        <div class="cards-container" style="grid-template-columns: 1fr;">
            <div class="card" style="overflow-x: auto;">
                <?php if (empty($datos)): ?>
                <p style="text-align:center; color:#555;">No se encontraron notas registradas para ti.</p>
                <?php else: ?>
                <table class="tabla-notas">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Curso</th>
                            <th>Docente</th>
                            <th>Nota</th>
                            <th>Tipo Evaluación</th>
                            <th>Observación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($datos as $fila): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($fila['codigo_curso']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($fila['nombre_curso']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($fila['nombre_docente']) ?>
                            </td>
                            <td>
                                <?= $fila['nota'] ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($fila['tipo_evaluacion']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($fila['observacion'] ?? '—') ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="JavaFunciones/camposEstudiante_java.js"></script>

</body>

</html>
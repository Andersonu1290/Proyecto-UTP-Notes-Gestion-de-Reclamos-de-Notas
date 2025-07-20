<?php
session_start();
if (!isset($_SESSION['profesor'])) {
    header("Location: login.php");
    exit();
}

require_once 'postgresql.php';
require_once 'mysql.php';

$profesor_id = $_SESSION['profesor']['usuario_id'];
$nombre = $_SESSION['profesor']['nombre'] ?? '';

$stmt = $pg_conn->prepare("
    SELECT c.id AS curso_id, c.codigo, c.nombre AS curso_nombre
    FROM cursos c
    JOIN notas n ON c.id = n.curso_id
    WHERE n.id_profesor = :id_profesor
    GROUP BY c.id, c.codigo, c.nombre
");
$stmt->bindParam(':id_profesor', $profesor_id, PDO::PARAM_INT);
$stmt->execute();
$cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$estudiantes_por_curso = [];

foreach ($cursos as $curso) {
    $curso_id = $curso['curso_id'];

    $stmt2 = $pg_conn->prepare("
        SELECT DISTINCT n.estudiante_id
        FROM notas n
        WHERE n.curso_id = :curso_id AND n.id_profesor = :id_profesor
    ");
    $stmt2->bindParam(':curso_id', $curso_id, PDO::PARAM_INT);
    $stmt2->bindParam(':id_profesor', $profesor_id, PDO::PARAM_INT);
    $stmt2->execute();
    $estudiante_ids = $stmt2->fetchAll(PDO::FETCH_COLUMN);

    $estudiantes = [];
    foreach ($estudiante_ids as $id_estudiante) {
        $res = $mysql->query("SELECT nombre_completo, correo, carrera, ciclo FROM estudiantes WHERE id = " . intval($id_estudiante));
        if ($row = $res->fetch_assoc()) {
            $estudiantes[] = $row;
        }
    }

    $estudiantes_por_curso[$curso['curso_nombre']] = $estudiantes;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Estudiantes de Mis Cursos</title>
    <link rel="stylesheet" href="Estilos/stylesGenerales.css">
    <link rel="stylesheet" href="Estilos/camposDocente_styles.css">
</head>

<body>
    <div class="sidebar">
        <h1 class="logo-title">UTP<span style="color:red;">+</span>notes</h1>
        <br>
        <div class="notificaciones">
            <h3>Menú Docente</h3>
            <p><a href="dashboard_docente.php" style="color:white;">← Volver al Panel</a></p>
        </div>
    </div>

    <div class="main">
        <h1>Estudiantes de Mis Cursos</h1>

        <?php if (empty($estudiantes_por_curso)): ?>
        <p>No se encontraron estudiantes en tus cursos asignados.</p>
        <?php else: ?>
        <?php foreach ($estudiantes_por_curso as $curso_nombre => $estudiantes): ?>
        <div class="curso-box">
            <h3>
                <?= htmlspecialchars($curso_nombre) ?>
            </h3>
            <?php if (empty($estudiantes)): ?>
            <p>No hay estudiantes en este curso.</p>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Carrera</th>
                        <th>Ciclo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estudiantes as $e): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($e['nombre_completo']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($e['correo']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($e['carrera']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($e['ciclo']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>

</html>
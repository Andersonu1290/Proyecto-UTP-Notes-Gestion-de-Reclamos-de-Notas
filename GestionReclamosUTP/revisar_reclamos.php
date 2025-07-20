<?php
session_start();
if (!isset($_SESSION['profesor'])) {
    header("Location: login.php");
    exit();
}

require_once 'mysql.php';
require_once 'mongodb.php';
require_once 'postgresql.php';
require_once 'cassandra.php';

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

$usuario = $_SESSION['profesor']['usuario'];
$nombre = $_SESSION['profesor']['nombre'] ?? '';
$profesor_id = $_SESSION['profesor']['id'];

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nueva_nota'])) {
    $reclamoId = $_POST['reclamo_id'];
    $nuevaNota = floatval($_POST['nueva_nota']);
    $reclamoObjectId = new ObjectId($reclamoId);

    $reclamo = $mongodbR->findOne(['_id' => $reclamoObjectId]);
    $curso_codigo = $reclamo['curso_id'];
    $estudiante_id = $reclamo['estudiante_id'];

    $stmtCurso = $pg_conn->prepare("SELECT id FROM cursos WHERE codigo = :codigo");
    $stmtCurso->bindParam(':codigo', $curso_codigo);
    $stmtCurso->execute();
    $filaCurso = $stmtCurso->fetch(PDO::FETCH_ASSOC);
    $curso_id_real = $filaCurso['id'] ?? null;

    if ($curso_id_real !== null) {
        $update = $pg_conn->prepare("UPDATE notas SET nota = :nota WHERE estudiante_id = :est AND curso_id = :cur");
        $update->bindParam(':nota', $nuevaNota);
        $update->bindParam(':est', $estudiante_id, PDO::PARAM_INT);
        $update->bindParam(':cur', $curso_id_real, PDO::PARAM_INT);
        $update->execute();

        $mongodbR->updateOne(
            ['_id' => $reclamoObjectId],
            ['$set' => ['estado' => 'Aceptado']]
        );

        $ultimoSeguimiento = $mongodbS->findOne(
            ['reclamo_id' => $reclamoObjectId],
            ['sort' => ['fecha' => -1]]
        );

        if ($ultimoSeguimiento) {
            $mongodbS->updateOne(
                ['_id' => $ultimoSeguimiento['_id']],
                [
                    '$set' => [
                        'estado' => 'Aceptado',
                        'comentario' => "Nota cambiada por $nombre.",
                        'fecha' => new UTCDateTime(),
                        'actualizado_por' => $nombre
                    ]
                ]
            );
        }

        $correoEstudiante = $mysql->query("SELECT correo FROM estudiantes WHERE id = $estudiante_id")->fetch_assoc()['correo'] ?? null;
        if ($correoEstudiante) {
            $data = [
                'titulo' => 'Reclamo Validado',
                'mensaje' => '✅ Su reclamo ha sido aceptado. Su nota ha sido actualizada.',
                'fecha_envio' => date('Y-m-d H:i:s'),
                'estado' => 'nuevo',
                'tipo' => 'respuesta',
                'canal' => 'sistema',
                'destinatario' => $correoEstudiante
            ];

            $contexto = stream_context_create([
                'http' => [
                    'header' => "Content-Type: application/json",
                    'method' => 'POST',
                    'content' => json_encode($data)
                ]
            ]);
            @file_get_contents("http://localhost:5000/notificaciones/crear", false, $contexto);
        }

        $mensaje = "✅ Nota actualizada correctamente.";
    } else {
        $mensaje = "❌ Error: Código de curso no válido.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rechazar_id'])) {
    $reclamoId = $_POST['rechazar_id'];
    $reclamoObjectId = new ObjectId($reclamoId);

    $reclamo = $mongodbR->findOne(['_id' => $reclamoObjectId]);
    $estudiante_id = $reclamo['estudiante_id'] ?? null;

    $mongodbR->updateOne(
        ['_id' => $reclamoObjectId],
        ['$set' => ['estado' => 'Rechazado']]
    );

    $mongodbS->updateOne(
        ['reclamo_id' => $reclamoObjectId],
        [
            '$set' => [
                'estado' => 'Rechazado',
                'comentario' => 'Reclamo rechazado por el profesor.',
                'fecha' => new UTCDateTime(),
                'actualizado_por' => $nombre
            ]
        ],
        ['sort' => ['fecha' => -1]]
    );

    $correoEstudiante = $mysql->query("SELECT correo FROM estudiantes WHERE id = $estudiante_id")->fetch_assoc()['correo'] ?? null;
    if ($correoEstudiante) {
        $data = [
            'titulo' => 'Reclamo Rechazado',
            'mensaje' => '❌ Lo sentimos, su reclamo fue rechazado por el docente.',
            'fecha_envio' => date('Y-m-d H:i:s'),
            'estado' => 'nuevo',
            'tipo' => 'respuesta',
            'canal' => 'sistema',
            'destinatario' => $correoEstudiante
        ];

        $contexto = stream_context_create([
            'http' => [
                'header' => "Content-Type: application/json",
                'method' => 'POST',
                'content' => json_encode($data)
            ]
        ]);
        @file_get_contents("http://localhost:5000/notificaciones/crear", false, $contexto);
    }
}

$reclamosCursor = $mongodbR->find([
    'id_profesor_asignado' => intval($profesor_id),
    'estado' => 'En revisión'
]);
$reclamos = iterator_to_array($reclamosCursor);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Revisar Reclamos</title>
    <link rel="stylesheet" href="Estilos/stylesGenerales.css">
    <link rel="stylesheet" href="Estilos/ver_reclamosDocente.css">

</head>

<body>
    <div class="sidebar">
        <h1 class="logo-title">UTP<span style="color:red;">+</span>notes</h1>
        <div class="notificaciones">
            <h3>Menú Docente</h3>
            <p><a href="dashboard_docente.php" style="color:white;">← Volver al Panel</a></p>
        </div>
    </div>

    <div class="main">
        <div class="main-header">
            <h1>Reclamos de Estudiantes</h1>
            <div class="user-info">
                <span>
                    <?= htmlspecialchars($nombre); ?> (
                    <?= htmlspecialchars($usuario); ?>)
                </span>
            </div>
        </div>

        <?php if ($mensaje): ?>
        <div
            style="background:#d4edda; padding: 10px; border-left: 5px solid #28a745; border-radius: 6px; margin-bottom: 15px;">
            <?= $mensaje ?>
        </div>
        <?php endif; ?>

        <div class="card">
            <table class="tabla-notas">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Estudiante</th>
                        <th>Curso</th>
                        <th>Motivo</th>
                        <th>Descripción</th>
                        <th>Archivo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($reclamos)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">No hay reclamos pendientes.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($reclamos as $r): ?>
                    <?php
                            $estudiante_id = $r['estudiante_id'];
                            $curso_codigo = $r['curso_id'];

                            $stmt = $mysql->prepare("SELECT nombre_completo FROM estudiantes WHERE id = ?");
                            $stmt->bind_param("i", $estudiante_id);
                            $stmt->execute();
                            $res = $stmt->get_result();
                            $nombre_estudiante = ($fila = $res->fetch_assoc()) ? $fila['nombre_completo'] : 'Desconocido';
                            $stmt->close();
                            $stmtCurso = $pg_conn->prepare("SELECT id FROM cursos WHERE codigo = :codigo");
                            $stmtCurso->bindParam(':codigo', $curso_codigo);
                            $stmtCurso->execute();
                            $filaCurso = $stmtCurso->fetch(PDO::FETCH_ASSOC);
                            $curso_id_real = $filaCurso['id'] ?? null;

                            $notaActual = 'Sin nota';
                            if ($curso_id_real !== null) {
                                $pgQuery = $pg_conn->prepare("SELECT nota FROM notas WHERE estudiante_id = :est AND curso_id = :cur");
                                $pgQuery->bindParam(':est', $estudiante_id, PDO::PARAM_INT);
                                $pgQuery->bindParam(':cur', $curso_id_real, PDO::PARAM_INT);
                                $pgQuery->execute();
                                $resultadoNota = $pgQuery->fetch(PDO::FETCH_ASSOC);
                                if ($resultadoNota && isset($resultadoNota['nota'])) {
                                    $notaActual = $resultadoNota['nota'];
                                }
                            }

                            $archivo_id = isset($r['archivo_adjunto']) && $r['archivo_adjunto'] instanceof ObjectId
                                ? (string) $r['archivo_adjunto']
                                : null;
                            ?>
                    <tr>
                        <td>
                            <?= $r['_id'] ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($nombre_estudiante) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($curso_codigo) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($r['motivo']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($r['descripcion']) ?>
                        </td>
                        <td>
                            <?php if ($archivo_id): ?>
                            <a href="descargar_prueba_estudiante.php?id=<?= $archivo_id ?>" target="_blank">📎 Ver</a>
                            <a href="descargar_prueba_estudiante.php?id=<?= $archivo_id ?>&descarga=1">📥 Descargar</a>
                            <?php else: ?>
                            Sin archivo
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= $r['estado'] ?>
                        </td>
                        <td>
                            <form method="POST" onsubmit="return confirm('¿Seguro de rechazar?');">
                                <input type="hidden" name="rechazar_id" value="<?= $r['_id'] ?>">
                                <button class="boton-actualizar rechazar">✖ Rechazar</button>
                            </form>

                            <div class="form-editar-nota">
                                <form method="POST">
                                    <input type="hidden" name="reclamo_id" value="<?= $r['_id'] ?>">
                                    <label>Nota actual:
                                        <?= htmlspecialchars($notaActual) ?>
                                    </label><br>
                                    <input type="number" name="nueva_nota" step="0.1" min="0" max="20" required
                                        value="<?= is_numeric($notaActual) ? $notaActual : '' ?>">
                                    <button type="submit" class="boton-actualizar aceptar" style="margin-top: 5px;">✔
                                        Guardar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
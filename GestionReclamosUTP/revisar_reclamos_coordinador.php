<?php
session_start();
if (!isset($_SESSION['coordinador'])) {
    header("Location: login.php");
    exit();
}

require_once 'mongodb.php';
require_once 'mysql.php';
require_once 'postgresql.php';
require_once 'cassandra.php';

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

$usuario = $_SESSION['coordinador']['usuario'];
$nombre = $_SESSION['coordinador']['nombre'] ?? '';
$mensajeError = '';
$mensajeExito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admitir_id'], $_POST['mensaje_notificacion'])) {
    $reclamoObjectId = new ObjectId($_POST['admitir_id']);
    $mensaje = trim($_POST['mensaje_notificacion']);

    if ($mensaje !== '') {
        $reclamo = $mongodbR->findOne(['_id' => $reclamoObjectId]);
        $curso_id = $reclamo['curso_id'] ?? null;
        $estudiante_id = $reclamo['estudiante_id'] ?? null;
        $correo_profesor = 'sin_profesor@utp.edu.pe';

        if ($curso_id !== null && $estudiante_id !== null) {
            $pg_id_stmt = $pg_conn->prepare("SELECT id FROM cursos WHERE codigo = :codigo LIMIT 1");
            $pg_id_stmt->execute([':codigo' => $curso_id]);
            $curso_row = $pg_id_stmt->fetch(PDO::FETCH_ASSOC);
            $pg_id_stmt = null;

            if ($curso_row && isset($curso_row['id'])) {
                $curso_id = $curso_row['id'];

                $pg_query = $pg_conn->prepare("SELECT id_profesor FROM notas WHERE curso_id = :curso_id AND estudiante_id = :estudiante_id LIMIT 1");
                $pg_query->execute([':curso_id' => $curso_id, ':estudiante_id' => $estudiante_id]);

                if ($row = $pg_query->fetch(PDO::FETCH_ASSOC)) {
                    $id_profesor = $row['id_profesor'];

                    $stmt = $mysql->prepare("SELECT correo FROM profesores WHERE id = ?");
                    $stmt->bind_param("i", $id_profesor);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    if ($fila = $res->fetch_assoc()) {
                        $correo_profesor = $fila['correo'];
                    }
                    $stmt->close();
                }
            }
        }

        $insertado = insertarNotificacion([
            'notificacion_id' => rand(10000, 99999),
            'titulo' => 'Validación de Reclamo',
            'mensaje' => $mensaje,
            'fecha_envio' => date('d/m/Y'),
            'estado' => 'Pendiente',
            'tipo' => 'Validación Coordinador',
            'destinatario' => $correo_profesor,
            'evento_relacionado' => 3,
            'canal' => 'Aplicación Móvil'
        ]);

        if ($insertado) {
            $mongodbR->updateOne(
                ['_id' => $reclamoObjectId],
                ['$set' => ['estado' => 'En revisión']]
            );

            $mongodbS->updateOne(
                ['reclamo_id' => $reclamoObjectId],
                ['$set' => [
                    'estado' => 'En revisión',
                    'comentario' => 'Reclamo validado por el coordinador.',
                    'fecha' => new UTCDateTime(),
                    'actualizado_por' => $nombre
                ]],
                ['sort' => ['fecha' => -1]]
            );
            $mensajeExito = '✅ Reclamo validado y notificación enviada al profesor.';
        } else {
            $mensajeError = '❌ No se pudo registrar la notificación en Cassandra.';
            error_log("❌ Error al registrar la notificación en Cassandra desde PHP");
        }
    } else {
        $mensajeError = '⚠️ Debes ingresar un mensaje de notificación.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rechazar_id'])) {
    $reclamoObjectId = new ObjectId($_POST['rechazar_id']);

    $mongodbR->updateOne(
        ['_id' => $reclamoObjectId],
        ['$set' => ['estado' => 'Rechazado']]
    );

    $mongodbS->updateOne(
        ['reclamo_id' => $reclamoObjectId],
        ['$set' => [
            'estado' => 'Rechazado',
            'comentario' => 'Reclamo rechazado por el coordinador.',
            'fecha' => new UTCDateTime(),
            'actualizado_por' => $nombre
        ]],
        ['sort' => ['fecha' => -1]]
    );
}

$reclamosCursor = $mongodbR->find([
    'estado' => 'pendiente',
    'archivo_adjunto' => ['$exists' => true]
]);
$reclamos = iterator_to_array($reclamosCursor);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Revisión de Reclamos - Coordinador</title>
    <link rel="stylesheet" href="Estilos/stylesGenerales.css">
    <link rel="stylesheet" href="Estilos/camposCoordinador_styles.css">
</head>

<body>
    <div class="sidebar">
        <h1 class="logo-title">UTP<span style="color:red;">+</span>notes</h1>
        <div class="notificaciones">
            <h3>Menú Coordinador</h3>
            <p><a href="dashboard_coordinador.php" style="color:white;">&larr; Volver al Panel</a></p>
        </div>
    </div>

    <div class="main">
        <div class="main-header">
            <h1>Revisión de Reclamos Pendientes</h1>
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

        <?php if ($mensajeError): ?>
        <div class="mensaje-alerta error">
            <?= $mensajeError ?>
        </div>
        <?php elseif ($mensajeExito): ?>
        <div class="mensaje-alerta exito">
            <?= $mensajeExito ?>
        </div>
        <?php endif; ?>

        <div class="cards-container" style="grid-template-columns: 1fr;">
            <div class="card">
                <table style="width:100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #c0392b; color: white;">
                            <th>ID</th>
                            <th>Estudiante</th>
                            <th>Curso</th>
                            <th>Motivo</th>
                            <th>Descripción</th>
                            <th>Archivo</th>
                            <th>Estado</th>
                            <th>Profesor</th>
                            <th>Mensaje + Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reclamos as $r): ?>
                        <?php
                            $estudiante_id = $r['estudiante_id'] ?? null;
                            $curso_codigo = $r['curso_id'] ?? null;
                            $nombre_estudiante = 'Desconocido';
                            $nombre_profesor = 'No asignado';

                            if ($estudiante_id !== null) {
                                $stmt = $mysql->prepare("SELECT nombre_completo FROM estudiantes WHERE id = ?");
                                $stmt->bind_param("i", $estudiante_id);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                if ($fila = $res->fetch_assoc()) $nombre_estudiante = $fila['nombre_completo'];
                                $stmt->close();
                            }

                            if ($curso_codigo !== null) {
                                $pg_stmt = $pg_conn->prepare("SELECT id FROM cursos WHERE codigo = :codigo");
                                $pg_stmt->execute([':codigo' => $curso_codigo]);
                                $curso_row = $pg_stmt->fetch(PDO::FETCH_ASSOC);

                                if ($curso_row && isset($curso_row['id'])) {
                                    $curso_id_real = $curso_row['id'];
                                    $pg_stmt2 = $pg_conn->prepare("SELECT id_profesor FROM notas WHERE curso_id = :cid AND estudiante_id = :eid LIMIT 1");
                                    $pg_stmt2->execute([':cid' => $curso_id_real, ':eid' => $estudiante_id]);
                                    $prof_row = $pg_stmt2->fetch(PDO::FETCH_ASSOC);

                                    if ($prof_row && isset($prof_row['id_profesor'])) {
                                        $id_profesor = $prof_row['id_profesor'];
                                        $stmt2 = $mysql->prepare("SELECT nombre_completo FROM profesores WHERE id = ?");
                                        $stmt2->bind_param("i", $id_profesor);
                                        $stmt2->execute();
                                        $res2 = $stmt2->get_result();
                                        if ($fila2 = $res2->fetch_assoc()) $nombre_profesor = $fila2['nombre_completo'];
                                        $stmt2->close();
                                    }
                                }
                            }

                            $archivo_id = isset($r['archivo_adjunto']) ? (string)$r['archivo_adjunto'] : null;
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
                                <?= htmlspecialchars($r['motivo'] ?? '') ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($r['descripcion'] ?? '') ?>
                            </td>
                            <td>
                                <?php if ($archivo_id): ?>
                                <a href="descargar_prueba_estudiante.php?id=<?= urlencode($archivo_id) ?>"
                                    target="_blank">📎 Ver</a>
                                <a href="descargar_prueba_estudiante.php?id=<?= $archivo_id ?>&descarga=1">📥
                                    Descargar</a>
                                <?php else: ?>
                                <span style="color:gray;">Sin archivo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($r['estado'] ?? '') ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($nombre_profesor) ?>
                            </td>
                            <td>
                                <form method="POST"
                                    onsubmit="return confirm('¿Validar reclamo y enviar notificación?');">
                                    <input type="hidden" name="admitir_id" value="<?= $r['_id'] ?>">
                                    <textarea name="mensaje_notificacion" rows="2" cols="30" required
                                        placeholder="Mensaje a profesor..."></textarea><br>
                                    <button type="submit" class="boton-actualizar validar">✔ Validar</button>
                                </form>
                                <form method="POST" onsubmit="return confirm('¿Confirmar rechazo del reclamo?');">
                                    <input type="hidden" name="rechazar_id" value="<?= $r['_id'] ?>">
                                    <button type="submit" class="boton-actualizar rechazar">✖ Rechazar</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($reclamos)): ?>
                        <tr>
                            <td colspan="9" style="text-align:center;">No hay reclamos pendientes.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
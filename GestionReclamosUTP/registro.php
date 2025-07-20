<?php
session_start();

if (!isset($_SESSION['estudiante'])) {
    header("Location: index.php");
    exit();
}

require_once 'mongodb.php';
require_once 'postgresql.php';
require_once 'mysql.php';

use MongoDB\BSON\UTCDateTime;

$usuario = $_SESSION['estudiante']['usuario'];
$nombre = $_SESSION['estudiante']['nombre'] ?? '';
$estudiante_id = $_SESSION['estudiante']['usuario_id'] ?? null;

if (!$estudiante_id) {
    die("ID de usuario no encontrado en la sesión.");
}

$stmt = $pg_conn->prepare("
    SELECT n.id AS nota_id, n.nota, n.tipo_evaluacion, n.observacion, n.id_profesor,
           c.nombre AS curso_nombre, c.codigo AS curso_codigo
    FROM notas n
    JOIN cursos c ON n.curso_id = c.id
    WHERE n.estudiante_id = :estudiante_id
");
$stmt->bindParam(':estudiante_id', $estudiante_id, PDO::PARAM_INT);
$stmt->execute();
$cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($cursos as &$curso) {
    $id_profesor_pg = isset($curso['id_profesor']) ? intval($curso['id_profesor']) : 0;

    if ($id_profesor_pg > 0) {
        $stmt_prof = $mysql->prepare("SELECT nombre_completo FROM profesores WHERE id = ?");
        $stmt_prof->bind_param("i", $id_profesor_pg);
        $stmt_prof->execute();
        $res_prof = $stmt_prof->get_result();
        if ($prof_data = $res_prof->fetch_assoc()) {
            $curso['nombre_profesor'] = $prof_data['nombre_completo'];
        } else {
            $curso['nombre_profesor'] = 'Profesor no encontrado';
        }
        $stmt_prof->close();
    } else {
        $curso['nombre_profesor'] = 'ID de profesor inválido';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nota_id = $_POST['nota_id'] ?? '';
    $motivo = $_POST['asunto'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $estado = "pendiente";
    $prioridad = "alta";
    $fecha_reclamo = new UTCDateTime(strtotime(date('Y-m-d')) * 1000);
    $respuesta_docente = "En revisión";
    $archivo_id = null;

    $detalles_stmt = $pg_conn->prepare("
        SELECT n.nota, n.tipo_evaluacion, n.observacion, n.id_profesor,
               c.nombre AS curso_nombre, c.codigo AS curso_codigo
        FROM notas n
        JOIN cursos c ON c.id = n.curso_id
        WHERE n.id = :nota_id
    ");
    $detalles_stmt->bindParam(':nota_id', $nota_id, PDO::PARAM_INT);
    $detalles_stmt->execute();
    $detalles = $detalles_stmt->fetch(PDO::FETCH_ASSOC);

    if ($detalles) {
        if (isset($_FILES['archivo_adjunto']) && $_FILES['archivo_adjunto']['error'] === UPLOAD_ERR_OK) {
            $archivo_tmp = $_FILES['archivo_adjunto']['tmp_name'];
            $nombre_original = basename($_FILES['archivo_adjunto']['name']);
            $mime_type = mime_content_type($archivo_tmp) ?: 'application/octet-stream';

            $stream = fopen($archivo_tmp, 'rb');
            $archivo_id = $bucket->uploadFromStream($nombre_original, $stream, [
                'metadata' => [
                    'nombre_archivo' => $nombre_original,
                    'tipo' => $mime_type,
                    'usuario' => $usuario,
                    'curso' => $detalles['curso_nombre'] ?? 'Desconocido',
                    'evaluacion' => $detalles['tipo_evaluacion'] ?? '',
                    'descripcion' => $descripcion,
                    'fecha_subida' => new UTCDateTime()
                ]
            ]);
            fclose($stream);
        }

        $reclamo = [
            'estudiante_id'     => intval($estudiante_id),
            'curso_id'          => $detalles['curso_codigo'] ?? 'SIN-CODIGO',
            'motivo'            => $motivo,
            'descripcion'       => $descripcion,
            'estado'            => $estado,
            'fecha_reclamo'     => $fecha_reclamo,
            'tipo_evaluacion'   => $detalles['tipo_evaluacion'] ?? '',
            'archivo_adjunto'   => $archivo_id,
            'prioridad'         => $prioridad,
            'id_profesor_asignado' => intval($detalles['id_profesor'] ?? 0),
            'respuesta_docente' => $respuesta_docente,
            'fecha_respuesta'   => null,
            'resuelto_por'      => null
        ];

        $insertResult = $mongodbR->insertOne($reclamo);
        $reclamoId = $insertResult->getInsertedId();

        $mongodbS->insertOne([
            'reclamo_id'      => $reclamoId,
            'estado'          => 'pendiente',
            'comentario'      => 'Reclamo registrado por el estudiante.',
            'fecha'           => new UTCDateTime(),
            'actualizado_por' => $usuario,
            'estudiante_id'   => intval($estudiante_id)
        ]);

        $correo_ana = 'A12345678@utp.edu.pe';
        $curso_codigo = $detalles['curso_codigo'] ?? 'SIN-CODIGO';
        $titulo_notificacion = "Nuevo reclamo de nota";
        $mensaje_notificacion = "Reclamo de U($curso_codigo) del alumno $nombre ha sido registrado.";

        $data = [
            'titulo'      => $titulo_notificacion,
            'mensaje'     => $mensaje_notificacion,
            'fecha_envio' => date('Y-m-d H:i:s'),
            'estado'      => 'nuevo',
            'tipo'        => 'reclamo',
            'canal'       => 'sistema',
            'destinatario'=> $correo_ana
        ];

        $opciones = [
            'http' => [
                'header'  => "Content-Type: application/json",
                'method'  => 'POST',
                'content' => json_encode($data)
            ]
        ];

        $contexto = stream_context_create($opciones);
        @file_get_contents("http://localhost:5000/notificaciones/crear", false, $contexto);
    }

    header("Location: seguimiento.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Reclamo</title>
    <link rel="stylesheet" href="Estilos/stylesGenerales.css">
    <link rel="stylesheet" href="Estilos/camposEstudiante_styles.css">
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
            <h1>Registrar Reclamo</h1>
            <div class="user-info">
                <span>
                    <?php echo htmlspecialchars($nombre); ?> (
                    <?php echo htmlspecialchars($usuario); ?>) ▾
                </span>
                <div class="user-menu">
                    <a href="logout.php">Cerrar Sesión</a>
                </div>
            </div>
        </div>

        <div class="cards-container" style="grid-template-columns: 1fr;">
            <div class="card" style="padding: 20px;">
                <?php if (empty($cursos)): ?>
                <p>No se encontraron cursos con notas para ti.</p>
                <?php else: ?>
                <form method="POST" action="registro.php" enctype="multipart/form-data">
                    <label for="nota_id">Seleccione un curso:</label>
                    <select name="nota_id" id="nota_id" required onchange="mostrarInfo()">
                        <option value="">-- Elija un curso --</option>
                        <?php foreach ($cursos as $curso): ?>
                        <option value="<?= $curso['nota_id'] ?>"
                            data-profesor="<?= htmlspecialchars($curso['nombre_profesor']) ?>"
                            data-curso="<?= htmlspecialchars($curso['curso_nombre']) ?>"
                            data-nota="<?= $curso['nota'] ?>"
                            data-observacion="<?= htmlspecialchars($curso['observacion']) ?>">
                            <?= htmlspecialchars($curso['curso_nombre']) ?> (
                            <?= htmlspecialchars($curso['tipo_evaluacion']) ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>

                    <div class="info-box" id="info-box"
                        style="display:none; background-color:#f0f4ff; border-left: 4px solid #2563eb; padding: 10px; margin-top: 15px;">
                        <p><strong>Curso:</strong> <span id="infoCurso"></span></p>
                        <p><strong>Profesor:</strong> <span id="infoProfesor"></span></p>
                        <p><strong>Nota:</strong> <span id="infoNota"></span></p>
                        <p><strong>Observación:</strong> <span id="infoObservacion"></span></p>
                    </div>

                    <label for="asunto">Asunto del reclamo:</label>
                    <input type="text" name="asunto" id="asunto" required>

                    <label for="descripcion">Descripción detallada:</label>
                    <textarea name="descripcion" id="descripcion" rows="4" required></textarea>

                    <label for="archivo_adjunto">Archivo adjunto (PDF o imagen):</label>
                    <input type="file" name="archivo_adjunto" id="archivo_adjunto" accept=".pdf,image/*" required>

                    <button type="submit" class="boton-accion">Enviar Reclamo</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="JavaFunciones/camposEstudiante_java.js"></script>

</body>

</html>
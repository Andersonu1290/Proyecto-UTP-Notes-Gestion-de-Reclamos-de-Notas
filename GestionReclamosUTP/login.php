<?php
session_start();
require_once 'mysql.php';
require_once 'redis.php';

$usuario = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!preg_match('/^[UCAuca]\d{8}@utp\.edu\.pe$/', $usuario)) {
        $error = "Por favor, ingrese un correo institucional válido. Este debe comenzar con U, C o A seguido de 8 dígitos, y terminar en @utp.edu.pe.";
    } else {
        $primerCaracter = strtoupper($usuario[0]);

        switch ($primerCaracter) {
            case 'U':
                $tabla = "estudiantes";
                $rol = 'estudiante';
                $redirect = 'dashboard.php';
                break;
            case 'C':
                $tabla = "profesores";
                $rol = 'profesor';
                $redirect = 'dashboard_docente.php';
                break;
            case 'A':
                $tabla = "coordinadores";
                $rol = 'coordinador';
                $redirect = 'dashboard_coordinador.php';
                break;
            default:
                $error = "Tipo de usuario no reconocido. Verifique que el correo comience con U, C o A.";
        }

        if (empty($error)) {
            $sql = "SELECT * FROM $tabla WHERE correo = ? AND contraseña = ?";
            $stmt = $mysql->prepare($sql);
            $stmt->bind_param("ss", $usuario, $contrasena);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $fila = $result->fetch_assoc();

                $_SESSION[$rol] = [
                    'id' => $fila['id'],
                    'usuario' => $usuario,
                    'usuario_id' => $fila['id'],
                    'rol' => $rol,
                    'nombre' => $fila['nombre_completo'] ?? ''
                ];

                $evento = [
                    'usuario' => $usuario,
                    'rol' => $rol,
                    'evento' => 'inicio_sesion',
                    'fecha' => date('Y-m-d H:i:s')
                ];

                $redis->lpush('registro_sesiones', json_encode($evento));

                header("Location: $redirect");
                exit();
            } else {
                $error = "Las credenciales ingresadas no son válidas. Verifique que el correo y la contraseña coincidan con los registrados en el sistema.";
            }
        }
    }

    if (!empty($error)) {
        echo "<script>alert('$error'); window.location.href='login.php';</script>";
    }
}
?>
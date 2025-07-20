<?php
session_start();
require_once 'redis.php';

$usuario = '';
$rol = '';

if (isset($_SESSION['estudiante'])) {
    $usuario = $_SESSION['estudiante']['usuario'];
    $rol = 'estudiante';
    unset($_SESSION['estudiante']);
} elseif (isset($_SESSION['profesor'])) {
    $usuario = $_SESSION['profesor']['usuario'];
    $rol = 'profesor';
    unset($_SESSION['profesor']);
} elseif (isset($_SESSION['coordinador'])) {
    $usuario = $_SESSION['coordinador']['usuario'];
    $rol = 'coordinador';
    unset($_SESSION['coordinador']);
}

if ($usuario && $rol) {
    $evento = [
        'usuario' => $usuario,
        'rol' => $rol,
        'evento' => 'cierre_sesion',
        'fecha' => date('Y-m-d H:i:s')
    ];
    $redis->lpush('registro_sesiones', json_encode($evento));
}

header("Location: index.php");
exit();

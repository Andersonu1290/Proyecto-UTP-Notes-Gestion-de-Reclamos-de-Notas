<?php
require_once 'mongodb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $asunto = $_POST["asunto"] ?? '';
    $descripcion = $_POST["descripcion"] ?? '';
    $fecha = new MongoDB\BSON\UTCDateTime();
    $estado = "En revisión";

    try {
        $mongodbR->insertOne([
            'asunto' => $asunto,
            'descripcion' => $descripcion,
            'estado' => $estado,
            'fecha' => $fecha
        ]);
        header("Location: seguimiento.php");
        exit();
    } catch (Exception $e) {
        die("❌ Error al registrar reclamo: " . $e->getMessage());
    }
}

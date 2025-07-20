<?php
require 'vendor/autoload.php';

use MongoDB\Client;

try {
    $mongoClient = new Client("mongodb+srv://lopezgrupotrabajo:Lionelmessi@cluster0.h76bme9.mongodb.net/?retryWrites=true&w=majority");

    $mongoDB = $mongoClient->utp_reclamos;


    $mongodbR = $mongoDB->reclamos;
    $mongodbS = $mongoDB->seguimientos;

    $bucket = $mongoDB->selectGridFSBucket();


    if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
        echo "<h2>📁 Contenido de Reclamos</h2>";
        $reclamos = $mongodbR->find();
        foreach ($reclamos as $r) {
            echo "<strong>ID:</strong> " . $r['_id'] . "<br>";
            echo "<strong>Estudiante ID:</strong> " . ($r['estudiante_id'] ?? 'N/A') . "<br>";
            echo "<strong>Motivo:</strong> " . ($r['motivo'] ?? 'N/A') . "<br>";
            echo "<strong>Estado:</strong> " . ($r['estado'] ?? 'N/A') . "<br>";
            echo "<strong>Fecha:</strong> ";
            if (isset($r['fecha_reclamo']) && $r['fecha_reclamo'] instanceof MongoDB\BSON\UTCDateTime) {
                echo $r['fecha_reclamo']->toDateTime()->format('Y-m-d');
            } else {
                echo 'N/A';
            }
            echo "<br><hr>";
        }

        echo "<h2>📁 Contenido de Seguimientos</h2>";
        $seguimientos = $mongodbS->find();
        foreach ($seguimientos as $s) {
            echo "<strong>ID:</strong> " . $s['_id'] . "<br>";
            echo "<strong>Reclamo ID:</strong> " . ($s['reclamo_id'] ?? 'N/A') . "<br>";
            echo "<strong>Estado:</strong> " . ($s['estado'] ?? 'N/A') . "<br>";
            echo "<strong>Comentario:</strong> " . ($s['comentario'] ?? 'N/A') . "<br>";
            echo "<strong>Fecha:</strong> ";
            if (isset($s['fecha']) && $s['fecha'] instanceof MongoDB\BSON\UTCDateTime) {
                echo $s['fecha']->toDateTime()->format('Y-m-d H:i');
            } else {
                echo 'N/A';
            }
            echo "<br><hr>";
        }
    }
} catch (Exception $e) {
    die("❌ Error de conexión a MongoDB: " . $e->getMessage());
}

<?php
require 'mongodb.php';

header('Content-Type: application/json');

if (!isset($_GET['id_estudiante'])) {
    echo json_encode([]);
    exit();
}

$estudiante_id = (int) $_GET['id_estudiante'];

try {
    $cursor = $mongodbS->find(['estudiante_id' => $estudiante_id]);

    $resultados = [];

    foreach ($cursor as $doc) {
        $resultados[] = [
            '_id' => (string) ($doc['_id'] ?? ''),
            'reclamo_id' => isset($doc['reclamo_id']) ? (string) $doc['reclamo_id'] : '',
            'estado' => $doc['estado'] ?? '',
            'comentario' => $doc['comentario'] ?? '',
            'fecha' => isset($doc['fecha']) && $doc['fecha'] instanceof MongoDB\BSON\UTCDateTime
                ? $doc['fecha']->toDateTime()->format('Y-m-d\TH:i:s')
                : '',
            'actualizado_por' => $doc['actualizado_por'] ?? ''
        ];
    }

    echo json_encode($resultados);
} catch (Exception $e) {
    echo json_encode(["error" => "Error: " . $e->getMessage()]);
}

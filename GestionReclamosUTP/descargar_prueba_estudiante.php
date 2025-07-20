<?php
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

if (!isset($_GET['id'])) {
    die("ID de archivo no proporcionado.");
}

$archivoId = $_GET['id'];
$descargar = isset($_GET['descarga']) && $_GET['descarga'] === '1';

try {
    $mongoClient = new Client("mongodb+srv://lopezgrupotrabajo:Lionelmessi@cluster0.h76bme9.mongodb.net/?retryWrites=true&w=majority");

    $database = $mongoClient->selectDatabase('utp_reclamos');
    $bucket = $database->selectGridFSBucket();

    $archivo = $database->selectCollection('fs.files')->findOne([
        '_id' => new ObjectId($archivoId)
    ]);

    if (!$archivo) {
        die("Archivo no encontrado.");
    }

    $nombreArchivo = $archivo['filename'] ?? 'archivo.pdf';
    $tipoContenido = $archivo['metadata']['tipo'] ?? 'application/octet-stream';

    header('Content-Type: ' . $tipoContenido);

    if ($descargar) {
        header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
    } else {
        header('Content-Disposition: inline; filename="' . $nombreArchivo . '"');
    }

    header('Content-Length: ' . $archivo['length']);

    $stream = $bucket->openDownloadStream(new ObjectId($archivoId));
    fpassthru($stream);
} catch (Exception $e) {
    die("Error al descargar el archivo: " . $e->getMessage());
}

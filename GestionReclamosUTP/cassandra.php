<?php

function insertarNotificacion($data)
{
    $url = "http://127.0.0.1:5000/notificaciones/crear";

    $opciones = [
        'http' => [
            'header' => "Content-Type: application/json",
            'method' => 'POST',
            'content' => json_encode($data),
            'timeout' => 5
        ]
    ];

    $contexto = stream_context_create($opciones);
    $respuesta = @file_get_contents($url, false, $contexto);

    $codigo = 0;
    if (isset($http_response_header)) {
        foreach ($http_response_header as $header) {
            if (preg_match('#HTTP/\d+\.\d+\s+(\d+)#', $header, $matches)) {
                $codigo = intval($matches[1]);
                break;
            }
        }
    }

    return $codigo === 201;
}

function eliminarNotificacion($id)
{
    $url = "http://127.0.0.1:5000/notificaciones/" . urlencode($id);

    $opciones = [
        'http' => [
            'method' => 'DELETE',
            'timeout' => 5
        ]
    ];

    $contexto = stream_context_create($opciones);
    $respuesta = @file_get_contents($url, false, $contexto);

    $codigo = 0;
    if (isset($http_response_header)) {
        foreach ($http_response_header as $header) {
            if (preg_match('#HTTP/\d+\.\d+\s+(\d+)#', $header, $matches)) {
                $codigo = intval($matches[1]);
                break;
            }
        }
    }

    return $codigo === 200;
}

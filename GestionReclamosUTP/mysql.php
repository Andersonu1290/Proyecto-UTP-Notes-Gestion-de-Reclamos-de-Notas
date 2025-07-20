<?php
$mysql = new mysqli("localhost", "root", "Andylian129@", "utp_usuarios");

if ($mysql->connect_error) {
    die("Error de conexión: " . $mysql->connect_error);
} else {
    echo "✅ Conexión exitosa a MySQL. Pero parece que no puso bien la contraseña o usuario,Vuelve a intentarlo en el index.php.";
}

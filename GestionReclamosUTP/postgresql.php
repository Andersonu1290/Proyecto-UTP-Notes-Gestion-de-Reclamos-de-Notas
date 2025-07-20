<?php
$host = "localhost";
$dbname = "Utp_Academico";
$user = "postgres";
$password = "U23203203";

try {
    $pg_conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pg_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a PostgreSQL: " . $e->getMessage());
}

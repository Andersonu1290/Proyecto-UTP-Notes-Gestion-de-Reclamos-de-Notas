<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - Gestión de Reclamos UTP</title>
    <link rel="stylesheet" href="Estilos/stylesGenerales.css">
</head>

<body>

    <div class="container">

        <div class="left">
            <img src="img/Utplogonuevo.png" alt="Estudiantes UTP">
        </div>

        <div class="right">
            <form action="login.php" method="post" class="form-container">
                <div class="logo">UTP<span style="color:red;">+</span>notes</div>
                <div class="subtitulo">
                    La nueva experiencia digital de consulta de calificaciones<br>
                    <small>Cercana, dinámica y flexible</small>
                </div>

                <label for="usuario">Código UTP</label>
                <input type="text" name="usuario" id="usuario" placeholder="Ingresa tu usuario" required>
                <div class="info">Ejemplo de usuario: U1533148@utp.edu.pe</div>

                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" placeholder="Ingresa tu contraseña" required>

                <input type="submit" value="Iniciar sesión" class="submit-btn">
            </form>
        </div>
    </div>

</body>

</html>
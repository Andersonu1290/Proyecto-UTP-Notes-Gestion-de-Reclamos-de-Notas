# 📚 UTP+notes - Sistema de Gestión de Reclamos de Notas

UTP+notes es una plataforma web que permite a los estudiantes de la Universidad Tecnológica del Perú (UTP) registrar reclamos sobre sus notas académicas, a los profesores revisar dichos reclamos y a los coordinadores supervisar y controlar todo el proceso. El sistema está desarrollado con múltiples motores de base de datos y tecnologías modernas, integrando tanto bases relacionales como no relacionales para gestionar información distribuida.

**Link de demostracion del proyecto en youtube**
https://youtu.be/BV7V9IjIjaA 

**NO OLVIDE EJECUTAR EL APP.PY(es para que funcionen las notificaciones)**

**Usar el txt usado en el ejemplo para probar los dashboards Ejemplo : Prueba del video**

## 🚀 Funcionalidades principales

- Registro e inicio de sesión para estudiantes, profesores y coordinadores.
- Visualización de cursos y notas (PostgreSQL).
- Registro de reclamos con archivos adjuntos (MongoDB con GridFS).
- Seguimiento del estado de los reclamos en tiempo real (MongoDB).
- Notificaciones automáticas (Cassandra).
- Registro de sesiones de inicio/cierre (Redis).
- Paneles personalizados para cada rol (estudiante, docente, coordinador).
- Eliminación de notificaciones y cambios de estado.

## 🧑‍💻 Desarrolladores

- **Anderson Urrutia Moreyra Benonits** **U23203203**  **andersonmolles129@gmail.com**
- **Noe Benjamin Yallico Flores**       **U23211928**  **yalliconoe@gmail.com**
- **Cristhian Manuel Castro Quiñones**  **U23252010**  **dancastro665@gmail.com**

---

## 🚀 Funcionalidades destacadas

- Login con detección automática de rol (estudiante, profesor o coordinador).
- Panel personalizado para cada tipo de usuario.
- Registro de reclamos con archivos adjuntos (PDF o imágenes).
- Seguimiento en tiempo real del estado del reclamo.
- Notificaciones generadas automáticamente para docentes y coordinadores.
- Registro de sesiones (inicio/cierre) con Redis.
- Uso de 5 motores de base de datos reales y conectados.

---

## 🧩 Tecnologías y herramientas utilizadas

| Tecnología           | Uso principal                                      |
|----------------------|----------------------------------------------------|
| **PHP 8.2+**         | Backend principal                                  |
| **HTML5 / CSS3**     | Interfaz de usuario                                |
| **JavaScript + AJAX**| Interacción dinámica sin recargar páginas         |
| **MySQL**            | Autenticación y usuarios                           |
| **PostgreSQL**       | Cursos y notas                                     |
| **MongoDB Atlas**    | Reclamos, seguimiento y archivos (GridFS)          |
| **Cassandra (Astra DB)** | Notificaciones automáticas                     |
| **Redis (Redis Cloud)** | Registro de sesiones                            |
| **Python 3.10+**     | Conexión a Cassandra vía `app.py`                 |
| **Composer**         | Gestión de dependencias en PHP                     |

---

### 📂 Carpeta `vendor/`

- La carpeta `vendor/` es generada automáticamente por Composer y contiene:
  - `mongodb/mongodb`: para conectar PHP con MongoDB Atlas.
  - `predis/predis`: para conectar PHP con Redis.
- Ya viene incluida en el repositorio con sus dependencias resueltas. Si decides actualizar, asegúrate de usar Composer.

---

## 🧠 Arquitectura del proyecto

| Módulo                 | Tecnología            | Descripción                                          |
|------------------------|------------------------|------------------------------------------------------|
| Autenticación          | MySQL                  | Gestión de usuarios y sesiones                      |
| Notas y Cursos         | PostgreSQL             | Gestión de evaluaciones                             |
| Reclamos y Archivos    | MongoDB + GridFS       | Almacenamiento de reclamos y PDFs                   |
| Seguimiento            | MongoDB                | Estado en tiempo real de los reclamos               |
| Notificaciones         | Cassandra (AstraDB)    | Registro de cambios para los coordinadores          |
| Registro de sesiones   | Redis                  | Almacena eventos de inicio y cierre de sesión       |

---

## 🗂️ Estructura de Bases de Datos

Resumen de los motores de base de datos utilizados y sus respectivas entidades:

### 🐬 MySQL
- **Base de datos:** `utp_usuarios`
- **Tablas:**
  - `estudiantes`
  - `profesores`
  - `coordinadores`

### 🐘 PostgreSQL
- **Base de datos:** `Utp_Academico`
- **Tablas:**
  - `cursos`
  - `notas`

### 🍃 MongoDB Atlas
- **Base de datos:** `utp_reclamos`
- **Colecciones:**
  - `reclamos`
  - `seguimientos`
  - `fs.files` (archivos con GridFS)
  - `fs.chunks` (fragmentos de archivos)

### 🚀 Cassandra (AstraDB)
- **Base de datos:** `utp_eventos`
- **Keyspace:** `default_keyspace`
- **Tablas:**
  - `notificaciones`

### 🔴 Redis (Redis Cloud)
- **Base lógica:** `registro_sesiones`
- **Claves:**
  - `session:<usuario_id>:start`
  - `session:<usuario_id>:end`

---

## 🛠️ Requisitos previos

- [XAMPP](https://www.apachefriends.org/es/index.html) con Apache y MySQL habilitados
- PHP 8.2 o superior
- [Composer](https://getcomposer.org/) para instalar dependencias (MongoDB y Predis)
- Extensiones de PHP habilitadas:
  - `ext-mysqli`
  - `ext-mongodb`
  - `ext-curl`
  - `ext-json`
  - `ext-zip`
- Acceso a servicios externos:
  - MongoDB Atlas  
    https://cloud.mongodb.com/v2/68506ea3cd29416e6018941b#/overview  
  - AstraDB (Cassandra)  
    https://astra.datastax.com/org/59e1b623-f2b9-4afc-a062-3e2ba0bc2b02/database/dec5c0ac-1638-4930-8745-d5794df3f521/data-explorer  
  - Redis Cloud  
    https://ri.redis.io/13398622/browser?v=1752941190175  

---

## 🔐 Conexiones necesarias para las bases de datos

**MongoDB Atlas**:
-Cuenta: lopezgrupotrabajo@gmail.com
-Contraseña: Lionelmessi
-Colecciones: reclamos, seguimientos, fs.files, fs.chunks

**Redis Cloud**:
-Cuenta: lopezgrupotrabajo@gmail.com
-Contraseña: Lionelmessi
-Base para almacenar: registro_sesiones

**Astra DB (Cassandra)**:
-Cuenta: lopezgrupotrabajo@gmail.com
-Contraseña: Lionelmessi
-Base de datos: utp_eventos
-Keyspace: default_keyspace

**mysql.php(conexion necesaria a Mysql)**:
-MySQL (local)
-new mysqli("localhost", "root", "Andylian129@", "utp_usuarios");

**postgresql.php(conexion necesaria a Postgre)**:
-PostgreSQL (local)
$host = "localhost";
$dbname = "Utp_Academico";
$user = "postgres";
$password = "U23203203";

Importante: Para conectar correctamente con estos servicios debes iniciar sesión en la cuenta Gmail mencionada y verificar el acceso a MongoDB Atlas, Redis Cloud y AstraDB.
La cuenta lopezgrupotrabajo@gmail.com fue creada para fines de conexion de bd nadamas 

## ⚙️ Instalación del proyecto

1. **Clona este repositorio**
   ```bash
    cd C:\xampp\htdocs
    git clone https://github.com/Andersonu1290/Proyecto-UTP-Notes-Gestion-de-Reclamos-de-Notas.git
   
2.**Coloca el proyecto en la carpeta htdocs de XAMPP**
C:\xampp\htdocs\GestionReclamosUTP
Inicia Apache y MySQL desde el panel de XAMPP y accede a:
http://localhost/GestionReclamosUTP/index.php 

**Licencia**
Proyecto académico desarrollado en UTP para el curso de arquitectura de software. Uso libre con fines educativos.

**Créditos**
Gracias al equipo de trabajo y a al docente Adolfo Jorge Prado Ventocilla de la UTP por su guía y feadbacks durante el desarrollo del sistema.

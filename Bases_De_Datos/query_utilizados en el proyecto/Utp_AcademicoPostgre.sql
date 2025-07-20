CREATE TABLE cursos (
    id SERIAL PRIMARY KEY,
    codigo VARCHAR(10) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    creditos INT NOT NULL,
    ciclo INT NOT NULL,
    facultad VARCHAR(100),
    modalidad VARCHAR(50), -- Presencial, Virtual, Semipresencial
    estado VARCHAR(20) DEFAULT 'activo'
);
CREATE TABLE notas (
    id SERIAL PRIMARY KEY,
    estudiante_id INT NOT NULL,
    curso_id INT NOT NULL,
    nota DECIMAL(5,2) CHECK (nota >= 0 AND nota <= 100),
    tipo_evaluacion VARCHAR(50),
    observacion TEXT,
    fecha_registro DATE,
    registrado_por VARCHAR(100), 
    id_profesor INT;
);
--insertar datos en tabla notas agregar con encabesado
COPY public.notas
FROM 'C:\\Registros\\notas-definitivo.csv'
DELIMITER ','
CSV HEADER;
--insertar datos en tabla notas agregar sin encabesado
COPY public.notas
FROM 'C:\xampp\htdocs\GestionReclamosUTP\Archivos CVS\notasBackup2.csv'
DELIMITER ','
CSV;

TRUNCATE TABLE public.notas;

select * from cursos;
select * from notas;

drop table notas;
INSERT INTO cursos (codigo, nombre, descripcion, creditos, ciclo, facultad, modalidad)
VALUES
('MAT101', 'Matemáticas Básicas', 'Curso de álgebra, aritmética y lógica matemática', 4, 1, 'Ingeniería', 'Presencial'),
('FIS101', 'Física General', 'Conceptos fundamentales de la física clásica', 3, 1, 'Ingeniería', 'Presencial'),
('INF102', 'Fundamentos de Programación', 'Introducción a la programación estructurada', 4, 1, 'Ing. Sistemas', 'Virtual'),
('ADM202', 'Administración I', 'Teoría administrativa clásica y moderna', 3, 2, 'Administración', 'Presencial'),
('COM203', 'Comunicación Efectiva', 'Técnicas de redacción y comunicación oral', 2, 2, 'Ciencias Humanas', 'Presencial'),
('EST204', 'Estadística I', 'Probabilidad y estadística descriptiva', 3, 2, 'Ingeniería', 'Presencial'),
('ECO205', 'Economía General', 'Principios de micro y macroeconomía', 3, 2, 'Economía', 'Semipresencial'),
('DRE206', 'Derecho Empresarial', 'Fundamentos de derecho para los negocios', 3, 3, 'Administración', 'Virtual'),
('MAR301', 'Marketing I', 'Fundamentos del marketing y comportamiento del consumidor', 3, 3, 'Administración', 'Presencial'),
('FIS302', 'Física II', 'Ondas, electricidad y magnetismo', 3, 3, 'Ingeniería', 'Presencial'),
('MAT302', 'Matemáticas Avanzadas', 'Ecuaciones diferenciales y cálculo vectorial', 4, 3, 'Ingeniería', 'Presencial'),
('BD303', 'Base de Datos I', 'Modelo relacional, SQL y diseño de bases de datos', 4, 3, 'Ing. Sistemas', 'Virtual'),
('SIS304', 'Sistemas Operativos', 'Gestión de procesos, memoria y archivos', 4, 3, 'Ing. Sistemas', 'Presencial'),
('RED305', 'Redes I', 'Modelo OSI y TCP/IP, direccionamiento IP', 3, 4, 'Ing. Sistemas', 'Presencial'),
('CON306', 'Contabilidad General', 'Registro contable y estados financieros básicos', 3, 4, 'Administración', 'Presencial'),
('FIN401', 'Finanzas I', 'Análisis financiero básico y decisiones de inversión', 3, 4, 'Administración', 'Virtual'),
('PSI402', 'Psicología Organizacional', 'Conducta humana en entornos laborales', 2, 4, 'Ciencias Humanas', 'Presencial'),
('ETH403', 'Ética Profesional', 'Ética en el ejercicio profesional', 2, 4, 'General', 'Presencial'),
('PRO404', 'Programación Web', 'HTML, CSS, JavaScript y backend básico', 4, 5, 'Ing. Sistemas', 'Presencial'),
('SEG405', 'Seguridad Informática', 'Criptografía, hacking ético y firewalls', 3, 5, 'Ing. Sistemas', 'Virtual'),
('IA406', 'Inteligencia Artificial', 'Algoritmos de aprendizaje automático', 4, 5, 'Ing. Sistemas', 'Presencial'),
('BIO407', 'Biología Básica', 'Genética, evolución y ecología', 2, 1, 'Ciencias', 'Presencial'),
('QUI408', 'Química General', 'Estructura atómica y enlaces químicos', 3, 1, 'Ciencias', 'Presencial'),
('SOC409', 'Sociología', 'Estructuras sociales y análisis de la cultura', 2, 2, 'Ciencias Humanas', 'Presencial'),
('LOG410', 'Lógica y Argumentación', 'Pensamiento lógico formal', 2, 1, 'General', 'Presencial'),
('ADM411', 'Gestión de Proyectos', 'PMI, cronogramas y gestión de riesgos', 3, 5, 'Administración', 'Virtual'),
('SIS412', 'Arquitectura de Computadoras', 'Hardware, buses y ensamblador', 3, 4, 'Ing. Sistemas', 'Presencial'),
('SIS413', 'Ingeniería de Software', 'Ciclo de vida de software y metodologías ágiles', 4, 5, 'Ing. Sistemas', 'Presencial'),
('RED414', 'Redes II', 'Routing, switching y configuración de redes', 3, 5, 'Ing. Sistemas', 'Presencial'),
('TIC415', 'Transformación Digital', 'Tendencias en innovación tecnológica', 3, 6, 'General', 'Virtual');



INSERT INTO notas (estudiante_id, curso_id, nota, tipo_evaluacion, observacion, fecha_registro, registrado_por) VALUES
(1, 3, 20, 'Parcial', 'Buen desempeño en el primer examen', '2025-05-12', 'Dr. María Torres');
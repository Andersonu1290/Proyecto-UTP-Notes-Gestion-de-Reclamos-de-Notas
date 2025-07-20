use utp_usuarios;
select * from profesores;
select * from estudiantes;

CREATE TABLE estudiantes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre_completo VARCHAR(200),
  correo VARCHAR(100),
  dni int,
  carrera VARCHAR(150),
  ciclo INT,
  fecha_nacimiento DATE,
  telefono VARCHAR(30),
  direccion VARCHAR(150),
  contraseña VARCHAR(100)
);

INSERT INTO estudiantes (
  nombre_completo,
  correo,
  dni,
  carrera,
  ciclo,
  fecha_nacimiento,
  telefono,
  direccion,
  contraseña
) VALUES (
  'Anderson Urrutia Moreyra',
  'U23203203@utp.edu.pe',
  7920462,
  'Ingeniería de Sistemas',
  5,
  '2005-01-11',
  '987654321',
  'Av. Huampani Alto, Lima',
  'Andylian129@'
);


drop table estudiantes;
drop table coordinadores;
CREATE TABLE profesores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre_completo VARCHAR(100),
  correo VARCHAR(100),
  dni VARCHAR(10),
  especialidad VARCHAR(100),
  fecha_ingreso DATE,
  telefono VARCHAR(15),
  direccion VARCHAR(150),
  contraseña VARCHAR(100)
);
select *from estudiantes;
select *from profesores;
select *from coordinadores;
CREATE TABLE coordinadores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre_completo VARCHAR(100),
  correo VARCHAR(100),
  dni VARCHAR(10),
  area VARCHAR(100),
  fecha_ingreso DATE,
  telefono VARCHAR(15),
  direccion VARCHAR(150),
  contraseña VARCHAR(100)
);

ALTER TABLE coordinadores
ADD CONSTRAINT chk_correo_formato
CHECK (correo REGEXP '^A[0-9]{8}@utp\\.edu\\.pe$');

INSERT INTO coordinadores (nombre_completo, correo, dni, area, fecha_ingreso, telefono, direccion, contraseña) VALUES
('Ana Ramos', 'A12345678@utp.edu.pe', '71234567', 'Ingeniería de Sistemas', '2020-03-15', '987654321', 'Av. Los Álamos 123', 'ana123'),
('Luis Vargas', 'A87654321@utp.edu.pe', '69874512', 'Administración', '2019-06-10', '912345678', 'Calle Lima 456', 'luisv'),
('Marta López', 'A11112222@utp.edu.pe', '70123456', 'Contabilidad', '2021-01-20', '999888777', 'Av. Arequipa 789', 'marta2021'),
('Carlos Díaz', 'A22223333@utp.edu.pe', '74561234', 'Marketing', '2018-09-05', '988776655', 'Jr. Cusco 321', 'carlosd'),
('Paula Torres', 'A33334444@utp.edu.pe', '73219876', 'Derecho', '2022-02-28', '987123456', 'Av. Benavides 987', 'paulita'),
('Jorge Meza', 'A44445555@utp.edu.pe', '72345678', 'Psicología', '2020-07-12', '986543210', 'Calle Tarata 159', 'jorge2020'),
('Lucía Huamán', 'A55556666@utp.edu.pe', '71654321', 'Arquitectura', '2017-11-23', '985432167', 'Jr. Bolognesi 741', 'luciah'),
('Marco Paredes', 'A66667777@utp.edu.pe', '73456789', 'Ingeniería Industrial', '2016-08-30', '984321765', 'Av. Javier Prado 123', 'marcop'),
('Elena Ríos', 'A77778888@utp.edu.pe', '76543210', 'Medicina', '2023-05-04', '983210987', 'Calle Los Robles 654', 'elenita'),
('Raúl Herrera', 'A88889999@utp.edu.pe', '75432109', 'Educación', '2021-10-18', '982109876', 'Av. Universitaria 852', 'raul2021');


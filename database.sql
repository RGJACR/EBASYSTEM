-- multisucursal_v21
CREATE DATABASE IF NOT EXISTS multisucursal CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE multisucursal;
DROP TABLE IF EXISTS evaluaciones, notas, encuestas, documentos, estudiantes, usuarios, instituciones;
CREATE TABLE instituciones ( id INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(150) NOT NULL );
CREATE TABLE usuarios ( id INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(100) NOT NULL, email VARCHAR(100) UNIQUE NOT NULL, password VARCHAR(255) NOT NULL, rol ENUM('ADMINISTRADOR','DIRECTOR','DOCENTE') NOT NULL, institucion_id INT DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, celular VARCHAR(30) DEFAULT NULL, estado ENUM('activo','baja') DEFAULT 'activo', FOREIGN KEY (institucion_id) REFERENCES instituciones(id) );
CREATE TABLE estudiantes ( id INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(150), grado VARCHAR(50), edad INT, celular VARCHAR(30), institucion_id INT, FOREIGN KEY (institucion_id) REFERENCES instituciones(id) );
CREATE TABLE documentos ( id INT AUTO_INCREMENT PRIMARY KEY, usuario_id INT NOT NULL, institucion_id INT NOT NULL, modulo VARCHAR(100) NOT NULL, tipo VARCHAR(150) NOT NULL, nombre_original VARCHAR(255), ruta VARCHAR(255), estado ENUM('pendiente','aprobado','rechazado') DEFAULT 'pendiente', creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (usuario_id) REFERENCES usuarios(id), FOREIGN KEY (institucion_id) REFERENCES instituciones(id) );
CREATE TABLE encuestas ( id INT AUTO_INCREMENT PRIMARY KEY, institucion_id INT NOT NULL, estudiante_id INT, datos JSON, creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (institucion_id) REFERENCES instituciones(id), FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id) );
CREATE TABLE notas ( id INT AUTO_INCREMENT PRIMARY KEY, institucion_id INT NOT NULL, estudiante_id INT NOT NULL, grado VARCHAR(50), area VARCHAR(100), nota DECIMAL(5,2), creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (institucion_id) REFERENCES instituciones(id), FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id) );
CREATE TABLE evaluaciones ( id INT AUTO_INCREMENT PRIMARY KEY, docente_id INT NOT NULL, institucion_id INT NOT NULL, archivo VARCHAR(255), calificacion INT, estado ENUM('pendiente','calificado') DEFAULT 'pendiente', creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (docente_id) REFERENCES usuarios(id), FOREIGN KEY (institucion_id) REFERENCES instituciones(id) );

INSERT INTO instituciones (nombre) VALUES ('CEBA DOS DE MAYO'),('CEBA CARLOS FERMIN FITZCARRALD'),('CEBA GUILLERMO BILLIGURST');

INSERT INTO usuarios (nombre,email,password,rol,institucion_id,avatar,celular,estado) VALUES
('Admin','admin@example.com','0192023a7bbd73250516f069df18b500','ADMINISTRADOR',NULL,'public/img/avatars/admin.png','999000111','activo'),
('Director 1','director1@ceba1.local','eaae01eb4bcad3ededea38e325df5901','DIRECTOR',1,'public/img/avatars/director1.png','999111222','activo'),
('Director 2','director2@ceba2.local','eaae01eb4bcad3ededea38e325df5901','DIRECTOR',2,'public/img/avatars/director2.png','999222333','activo'),
('Director 3','director3@ceba3.local','eaae01eb4bcad3ededea38e325df5901','DIRECTOR',3,'public/img/avatars/director3.png','999333444','activo'),
('Docente 1','docente1@ceba1.local','8be2efedf58bc5ca5ef33aec86a7a217','DOCENTE',1,'public/img/avatars/doc1.png','999444555','activo'),
('Docente 2','docente2@ceba2.local','8be2efedf58bc5ca5ef33aec86a7a217','DOCENTE',2,'public/img/avatars/doc2.png','999555666','activo'),
('Docente 3','docente3@ceba3.local','8be2efedf58bc5ca5ef33aec86a7a217','DOCENTE',3,'public/img/avatars/doc3.png','999666777','activo');

INSERT INTO estudiantes (nombre,grado,edad,celular,institucion_id) VALUES ('Juan Perez','1er Grado',12,'999111222',1),('María Lopez','2do Grado',13,'999222333',1),('Carlos Ruiz','1er Secundaria',14,'999333444',2);

DROP DATABASE IF EXISTS venta_computadoras;
CREATE DATABASE venta_computadoras;
USE venta_computadoras;

-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - USUARIOS - - - - - - - - - - - - - - - - - - - - - - - - - - - -
CREATE TABLE tipo_usuario(
    id_tipo_usuario INT AUTO_INCREMENT PRIMARY KEY,
    tipo_usuario VARCHAR(100) UNIQUE NOT NULL
);

INSERT INTO tipo_usuario (tipo_usuario) VALUES 
('Administrador'),
('Tecnico'),
('Cliente');

CREATE TABLE usuario(
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    id_tipo_usuario INT NOT NULL, 
    
    nombre VARCHAR(200) NOT NULL, 
    correo VARCHAR(200) NOT NULL UNIQUE,
    pass VARCHAR(250) NOT NULL,

    direccion VARCHAR (300) NOT NULL, 
    telefono INT NOT NULL,
    FOREIGN KEY (id_tipo_usuario) REFERENCES tipo_usuario(id_tipo_usuario)
);

-- - - - - - - - - - - - - - - - - - - - - - - - - COMPONENTES/Inv - - - - - - - - - - - - - - - - - - - - - - - -
CREATE TABLE tipo_componente(
    id_tipo_componente INT AUTO_INCREMENT PRIMARY KEY, 
    tipo_componente VARCHAR(100) UNIQUE NOT NULL
);

-- Componentes principales
INSERT INTO tipo_componente(tipo_componente) VALUES
('Procesador'),
('Memoria RAM'),
('Almacenamiento'),
('Fuente de poder'),
('Gabinete'),
('Motherboard');

-- Inventario
CREATE TABLE componente(
    id_componente INT AUTO_INCREMENT PRIMARY KEY, 
    id_tipo_componente INT NOT NULL,

    nombre VARCHAR(100),
    descripcion VARCHAR(200), 
    capacidad INT, -- GB, MHz, nucleos, vatios, etc
    marca VARCHAR(100),
    modelo VARCHAR(100),

    precio DECIMAL(10,2) NOT NULL, 
    cantidad_stock INT NOT NULL,
    FOREIGN KEY (id_tipo_componente) REFERENCES tipo_componente(id_tipo_componente)
);

CREATE TABLE tipo_movimiento_inventario (
    id_tipo_movimiento INT AUTO_INCREMENT PRIMARY KEY,
    tipo_movimiento VARCHAR(50) NOT NULL
);
INSERT INTO tipo_movimiento_inventario(tipo_movimiento) VALUES 
('Entrada'),   -- compra a proveedor
('Salida'),    -- venta / ensamblaje
('Ajuste');    -- corrección manual

-- MOVIMIENTOS DE INVENTARIO
CREATE TABLE movimiento_inventario (
    id_movimiento INT AUTO_INCREMENT PRIMARY KEY,
    id_componente INT NOT NULL,
    id_tipo_movimiento INT NOT NULL,

    cantidad INT NOT NULL, -- positiva o negativa segun lo que se haga
    fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    observacion VARCHAR(255) NULL,
    FOREIGN KEY (id_componente) REFERENCES componente(id_componente),
    FOREIGN KEY (id_tipo_movimiento) REFERENCES tipo_movimiento_inventario(id_tipo_movimiento),
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

-- - - - - - - - - - - - - - - - - - - - - - ENSAMBLES (predefinidos y personalizados) - - - - - - - - - - - - - - - - - - - - -
-- Predefinido debe ser un boolean para diferenciar entre predefinido y personalizado :3
CREATE TABLE ensamble(
    id_ensamble INT AUTO_INCREMENT PRIMARY KEY,
    predefinido BOOLEAN NOT NULL, 
    
    id_usuario_creador INT NOT NULL,
    FOREIGN KEY (id_usuario_creador) REFERENCES usuario(id_usuario)
);

CREATE TABLE componente_ensamble(
    id_ensamble INT NOT NULL,
    id_componente INT NOT NULL,
    PRIMARY KEY (id_ensamble, id_componente),
    FOREIGN KEY (id_ensamble) REFERENCES ensamble(id_ensamble),
    FOREIGN KEY (id_componente) REFERENCES componente(id_componente)
);

-- - - - - - - - - - - - - - - - - - - - - - - - - - - REGISTRO DE VENTAS - - - - - - - - - - - - - - - - - - - - - - - - - -
CREATE TABLE estado_pedido(
    id_estado_pedido INT AUTO_INCREMENT PRIMARY KEY,
    estado_pedido VARCHAR(50) NOT NULL
);

INSERT INTO estado_pedido(estado_pedido) VALUES 
('Pendiente'),
('Confirmado'),
('Cancelado'),
('Completado');

CREATE TABLE pedido(
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario_pedido INT,
    id_estado_pedido INT NOT NULL,
    FOREIGN KEY (id_usuario_pedido) REFERENCES usuario(id_usuario),
    FOREIGN KEY (id_estado_pedido) REFERENCES estado_pedido(id_estado_pedido)
);

CREATE TABLE historial_cambios_pedido(
    id_historial_cambios INT AUTO_INCREMENT PRIMARY KEY, 

    id_pedido INT NOT NULL,
    id_estado_pedido INT NOT NULL,
    fecha_cambio_realizado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pedido) REFERENCES pedido(id_pedido),
    FOREIGN KEY (id_estado_pedido) REFERENCES estado_pedido(id_estado_pedido)
);

CREATE TABLE pedido_detalle( -- Permitir la venta de ensambles o componentes individualmente :3
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    id_ensamble INT NULL,
    id_componente INT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    FOREIGN KEY (id_pedido) REFERENCES pedido(id_pedido),
    FOREIGN KEY (id_ensamble) REFERENCES ensamble(id_ensamble),
    FOREIGN KEY (id_componente) REFERENCES componente(id_componente)
);
;


CREATE TABLE venta(
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL UNIQUE,
    fecha DATE NOT NULL,

    nombre_cliente VARCHAR(100) NOT NULL, -- si fue pedido por trabajador (por hacerse en una tienda fisica), pedir nombre del cliente
    nit_cliente INT NULL,
    id_usuario_ensamblador INT,
    monto DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedido(id_pedido),
    FOREIGN KEY (id_usuario_ensamblador) REFERENCES usuario(id_usuario)
);








-- Inserciones iniciales
-- Admin
-- INSERT INTO usuario(id_tipo_usuario, nombre, correo, pass, direccion, telefono) VALUES (1, 'Pedro Soto', 'pedroadmin@gmail.com', '12345', 'Dir admin', 12345678);
-- Cliente
-- INSERT INTO usuario(id_tipo_usuario, nombre, correo, pass, direccion, telefono) VALUES (3, 'Cliente Prueba', 'cliente@gmail.com', '12345', 'Dir cliente', 989848);
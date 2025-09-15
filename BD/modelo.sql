-- - - - - - - - - - - - - - - - - - - - - - - - - COMPONENTES - - - - - - - - - - - - - - - - - - - - - - - -

CREATE TABLE tipo_componente(
    id_tipo_componente INTEGER PRIMARY KEY, 
    tipo_componente VARCHAR(100) UNIQUE
);

-- Componentes principales 
INSERT INTO tipo_componente(tipo_componente) VALUES('Procesador');
INSERT INTO tipo_componente(tipo_componente) VALUES('Memoria RAM');
INSERT INTO tipo_componente(tipo_componente) VALUES('Almacenamiento');
INSERT INTO tipo_componente(tipo_componente) VALUES('Fuente de poder');
INSERT INTO tipo_componente(tipo_componente) VALUES('Gabinete');
INSERT INTO tipo_componente(tipo_componente) VALUES('Motherboard');

-- Inventario
CREATE TABLE componente(
    id_componente INTEGER PRIMARY KEY, 
    tipo_componente REFERENCES tipo_componente(id_tipo_componente),

    nombre VARCHAR (100),
    descripcion VARCHAR (200), 
    capacidad INTEGER, -- Esto puede ser cantidad de GB, velocidad, nucleos, vatios, etc :3
    marca VARCHAR(100),
    modelo VARCHAR(100),

    precio DECIMAL NOT NULL, 
    cantidad_stock INTEGER NOT NULL
);

CREATE TABLE tipo_movimiento_inventario (
    id_tipo_movimiento INTEGER AUTO_INCREMENT PRIMARY KEY,
    tipo_movimiento VARCHAR(50) NOT NULL
);
INSERT INTO tipo_movimiento_inventario(tipo_movimiento) VALUES ('Entrada');   -- compra de proveedor
INSERT INTO tipo_movimiento_inventario(tipo_movimiento) VALUES ('Salida');    -- venta / ensamblaje
INSERT INTO tipo_movimiento_inventario(tipo_movimiento) VALUES ('Ajuste');    -- corrección manual

CREATE TABLE movimiento_inventario (
    id_movimiento INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_componente INTEGER NOT NULL REFERENCES componente(id_componente),
    id_tipo_movimiento INTEGER NOT NULL REFERENCES tipo_movimiento_inventario(id_tipo_movimiento),

    cantidad INTEGER NOT NULL, -- positiva o negativa según el tipo
    fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_usuario INTEGER REFERENCES usuario(id_usuario), -- quién hizo el movimiento
    observacion VARCHAR(255) NULL
);



-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - USUARIOS - - - - - - - - - - - - - - - - - - - - - - - - - - - -
CREATE TABLE tipo_usuario(
    id_tipo_usuario INTEGER AUTO_INCREMENT PRIMARY KEY,
    tipo_usuario VARCHAR(100) UNIQUE
);

INSERT INTO tipo_usuario (tipo_usuairo) VALUES ('Administrador');
INSERT INTO tipo_usuario (tipo_usuairo) VALUES ('Tecnico');
INSERT INTO tipo_usuario (tipo_usuairo) VALUES ('Cliente');

CREATE TABLE usuario(
    id_usuario INTEGER PRIMARY KEY AUTO_INCREMENT,
    tipo_usuario INTEGER REFERENCES id_tipo_usuario NOT NULL, 

    nombre VARCHAR(200) NOT NULL, 
    correo VARCHAR(200) NOT NULL UNIQUE,
    pass VARCHR(200) NOT NULL
);

-- - - - - - - - - - - - - - - - - - - - - - ENSAMBLES (predefinidos y personalizados) - - - - - - - - - - - - - - - - - - - - -
-- Predefinido debe ser un boolean para diferenciar entre predefinido y personalizado :3
CREATE TABLE ensamble(
    id_ensamble INTEGER PRIMARY KEY AUTO_INCREMENT,
    predefinido BOOLEAN, 

    -- usuario que creo la computadora?
    id_usuario_creador INTEGER REFERENCES usuario(id_usuario) NOT NULL
    -- El precio se calcula consultando los componentes
);

CREATE TABLE componente_ensamble(
    id_ensamble REFERENCES ensamble(id_ensamble) NOT NULL,
    id_componente REFERENCES componente(id_componente) NOT NULL
    PRIMARY KEY (id_ensamble, id_componente)
);



-- - - - - - - - - - - - - - - - - - - - - - - - - - - REGISTRO DE VENTAS - - - - - - - - - - - - - - - - - - - - - - - - - -
CREATE TABLE estado_pedido(
    id_estado_pedido INTEGER AUTO_INCREMENT PRIMARY KEY,
    estado_pedido VARCHAR(50) NOT NULl
);
INSERT INTO estado_pedido(estado_pedido) VALUES ('Pendiente');
INSERT INTO estado_pedido(estado_pedido) VALUES ('Confirmado');
INSERT INTO estado_pedido(estado_pedido) VALUES ('Cancelado');
INSERT INTO estado_pedido(estado_pedido) VALUES ('Completado');

CREATE TABLE pedido(
    id_pedido INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_usuario_pedido INTEGER REFERENCES usuario(id_usuario), -- id del usuario que realizó el pedido, puede ser un cliente o un trabajador que realice el pedido por un cliente en una tienda fisica 
    estado_pedido INTEGER NOT NULL REFERENCES estado_pedido(id_estado_pedido)
);

CREATE TABLE historial_cambios_pedido(
    id_historial_cambios INTEGER AUTO_INCREMENT PRIMARY KEY, 

    id_pedido INTEGER NOT NULL REFERENCES pedido(id_pedido),
    estado INTEGER NOT NULL REFERENCES estado_pedido(id_estado_pedido),
    fecha_cambio_realizado TIMESTAMP NOT NULL
);


CREATE TABLE pedido_detalle( -- un pedido puede tener uno o más ensambles
    id_pedido INTEGER REFERENCES pedido(id_pedido) NOT NULl,
    id_ensable REFERENCES ensamble(id_ensamble) NOT NULl,
    PRIMARY KEY (id_pedido, id_ensamble)
);

CREATE TABLE venta(
    id_venta INTEGER PRIMARY KEY AUTO_INCREMENT,
    id_pedido REFERENCES pedido(id_pedido) NOT NULL UNIQUE REFERENCES pedido(id_pedido),
    fecha DATE NOT NULL,

    nombre_cliente VARCHAR(100) NOT NULL, -- El pedido pudo haber sido hecho por un tabajador, en ese caso pedir el nombre 
    nit_cliente INTEGER NULL,
    usuario_ensamblador REFERENCES usuario(id_usuario), -- trabajador que ensambló la pc :3
    monto DECIMAL NOT NULL -- calculo del total de la compra
);
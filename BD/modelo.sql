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

CREATE TABLE componente(
    id_componente INTEGER PRIMARY KEY, 
    tipo_componente REFERENCES tipo_componente(id_tipo_componente),

    nombre VARCHAR (100),
    descripcion VARCHAR (200), 
    capacidad INTEGER, -- Esto puede ser cantidad de GB, velocidad, nucleos, vatios, etc :3
    marca VARCHAR(100),

    precio DECIMAL NOT NULL, 
    cantidad_stock INTEGER NOT NULL
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
    
);



-- - - - - - - - - - - - - - - - - - - - - - - - - - - REGISTRO DE VENTAS - - - - - - - - - - - - - - - - - - - - - - - - - -
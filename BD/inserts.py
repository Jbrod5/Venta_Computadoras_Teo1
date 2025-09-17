import mysql.connector
from faker import Faker
import random
from datetime import datetime, timedelta

# Configuración de conexión a MariaDB
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="12345",  # cambia si tienes contraseña
    database="venta_computadoras"
)

cursor = db.cursor()
fake = Faker('es_ES')

# ----- Generar usuarios -----
tipos_usuario = [("Administrador",), ("Tecnico",), ("Cliente",)]
cursor.executemany("INSERT IGNORE INTO tipo_usuario (tipo_usuario) VALUES (%s)", tipos_usuario)
db.commit()

usuarios = []
for _ in range(10):
    tipo = random.choice([1, 2, 3])
    nombre = fake.name()
    correo = fake.unique.email()
    password = "12345"
    direccion = fake.address().replace("\n", ", ")
    telefono = random.randint(30000000, 39999999)
    usuarios.append((tipo, nombre, correo, password, direccion, telefono))

cursor.executemany(
    "INSERT INTO usuario (id_tipo_usuario, nombre, correo, pass, direccion, telefono) VALUES (%s,%s,%s,%s,%s,%s)",
    usuarios
)
db.commit()

# ----- Generar componentes -----
tipos_componente = [("Procesador",), ("Memoria RAM",), ("Almacenamiento",), ("Fuente de poder",), ("Gabinete",), ("Motherboard",)]
cursor.executemany("INSERT IGNORE INTO tipo_componente (tipo_componente) VALUES (%s)", tipos_componente)
db.commit()

componentes = []
marcas = ["Intel", "AMD", "Kingston", "Samsung", "Corsair", "Asus", "Gigabyte"]
for tipo_id in range(1, 7):  # 6 tipos de componente
    for _ in range(5):  # 5 componentes por tipo
        nombre = fake.word().capitalize()
        descripcion = fake.sentence(nb_words=6)
        capacidad = random.randint(2, 32)  # GB, nucleos, vatios, MHz, etc
        marca = random.choice(marcas)
        modelo = fake.bothify(text='??-####')
        precio = round(random.uniform(50, 1000), 2)
        cantidad_stock = random.randint(0, 50)
        componentes.append((tipo_id, nombre, descripcion, capacidad, marca, modelo, precio, cantidad_stock))

cursor.executemany(
    "INSERT INTO componente (id_tipo_componente, nombre, descripcion, capacidad, marca, modelo, precio, cantidad_stock) VALUES (%s,%s,%s,%s,%s,%s,%s,%s)",
    componentes
)
db.commit()

# ----- Generar movimientos de inventario -----
tipos_movimiento = [("Entrada",), ("Salida",), ("Ajuste",)]
cursor.executemany("INSERT IGNORE INTO tipo_movimiento_inventario (tipo_movimiento) VALUES (%s)", tipos_movimiento)
db.commit()

movimientos = []
cursor.execute("SELECT id_componente FROM componente")
componentes_ids = [row[0] for row in cursor.fetchall()]
cursor.execute("SELECT id_usuario FROM usuario")
usuarios_ids = [row[0] for row in cursor.fetchall()]

for _ in range(50):
    componente_id = random.choice(componentes_ids)
    tipo_movimiento_id = random.randint(1, 3)
    cantidad = random.randint(1, 10)
    if tipo_movimiento_id == 2:  # salida
        cantidad = -cantidad
    fecha = fake.date_time_between(start_date='-3y', end_date='now')
    usuario_id = random.choice(usuarios_ids)
    observacion = fake.sentence(nb_words=5)
    movimientos.append((componente_id, tipo_movimiento_id, cantidad, fecha, usuario_id, observacion))

cursor.executemany(
    "INSERT INTO movimiento_inventario (id_componente, id_tipo_movimiento, cantidad, fecha, id_usuario, observacion) VALUES (%s,%s,%s,%s,%s,%s)",
    movimientos
)
db.commit()

# ----- Generar ensambles -----
ensambles = []
for _ in range(10):
    predefinido = random.choice([True, False])
    creador = random.choice(usuarios_ids)
    ensambles.append((predefinido, creador))

cursor.executemany("INSERT INTO ensamble (predefinido, id_usuario_creador) VALUES (%s,%s)", ensambles)
db.commit()

# ----- Asociar componentes a ensambles -----
cursor.execute("SELECT id_ensamble FROM ensamble")
ensambles_ids = [row[0] for row in cursor.fetchall()]
for ensamble_id in ensambles_ids:
    componentes_elegidos = random.sample(componentes_ids, k=4)
    for comp_id in componentes_elegidos:
        cursor.execute("INSERT INTO componente_ensamble (id_ensamble, id_componente) VALUES (%s,%s)", (ensamble_id, comp_id))
db.commit()

# ----- Generar estados de pedido -----
estados = [("Pendiente",), ("Confirmado",), ("Cancelado",), ("Completado",)]
cursor.executemany("INSERT IGNORE INTO estado_pedido (estado_pedido) VALUES (%s)", estados)
db.commit()

# ----- Generar pedidos y ventas -----
pedidos = []
historial = []
ventas = []

cursor.execute("SELECT id_estado_pedido FROM estado_pedido")
estado_ids = [row[0] for row in cursor.fetchall()]

for _ in range(15):
    usuario_pedido = random.choice(usuarios_ids)
    estado = random.choice(estado_ids)
    cursor.execute("INSERT INTO pedido (id_usuario_pedido, id_estado_pedido) VALUES (%s,%s)", (usuario_pedido, estado))
    pedido_id = cursor.lastrowid

    # historial
    historial.append((pedido_id, estado, fake.date_time_between(start_date='-2y', end_date='now')))

    # Detalles de pedido
    ensamble_id = random.choice(ensambles_ids)
    cursor.execute("INSERT INTO pedido_detalle (id_pedido, id_ensamble) VALUES (%s,%s)", (pedido_id, ensamble_id))

    # Venta
    nombre_cliente = fake.name()
    nit_cliente = random.randint(1000000, 9999999)
    ensamblador = random.choice(usuarios_ids)
    monto = round(random.uniform(300, 5000), 2)
    fecha_venta = fake.date_between(start_date='-2y', end_date='today')
    cursor.execute(
        "INSERT INTO venta (id_pedido, fecha, nombre_cliente, nit_cliente, id_usuario_ensamblador, monto) VALUES (%s,%s,%s,%s,%s,%s)",
        (pedido_id, fecha_venta, nombre_cliente, nit_cliente, ensamblador, monto)
    )

db.commit()
cursor.close()
db.close()

print("¡Datos de ejemplo generados con éxito!")

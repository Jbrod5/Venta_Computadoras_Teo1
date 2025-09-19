#!/bin/bash

# Levantar servicio
#sudo systemctl start mariadb

# Configurar root con contraseña
#sudo mariadb -e "
#ALTER USER 'root'@'localhost' IDENTIFIED VIA mysql_native_password;
#SET PASSWORD = PASSWORD('12345');
#FLUSH PRIVILEGES;
#"

# Cargar la base de datos desde script.sql
sudo mariadb -u root -p12345 < /home/jorge/Teoría_Sistemas/Venta_Computadoras_Teo1/BD/script.sql

python3 ./inserts.py

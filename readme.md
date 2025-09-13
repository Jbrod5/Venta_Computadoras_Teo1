## Instalación de XAMPP (para Solus)
#### 1. Descargar y ejecutar el instalador de Xampp genérico para linux (lampp) y ejecutar el instalador
Se deben conceder permisos para ejecutar el instaldor.

La ruta de instalación por defecto será    `/opt/lampp/`

#### 2. Cambiar la carpeta expuesta por Xampp: 
Por defecto, XAMPP expone la ruta /opt/lampp/htdocs/ para linux

En mi caso, utilizaré esta ruta: /home/jorge/Teoría_Sistemas/

Para cambiarlo: 

1. Abrir el archivo de configuracion de XAMPP
```sh
sudo nano /opt/lampp/etc/httpd.conf
```

2. Reemplazar: 
```
DocumentRoot "/opt/lampp/htdocs"
<Directory "/opt/lampp/htdocs">
    ... y el resto hasta la etiqueta
</Directory>
```

Por: 
```
DocumentRoot "/home/jorge/Teoría_Sistemas"
<Directory "/home/jorge/Teoría_Sistemas">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

3. Dar permisos a la carpeta:
```sh
chmod -R 755 "/home/jorge/Teoría_Sistemas"
chown -R jorge:jorge "/home/jorge/Teoría_Sistemas"
```


#### 3. Solucion de problemas menores (dependencias y usuarios)
Mysql depende de libxcrypt para funcionar: 
``` sh
sudo eopkg install libxcrypt-compat
``` 
Por defecto, solus crea el grupo daemon pero no el usuario, ejecutar: 
```sh
sudo useradd -r -s /bin/false -g daemon daemon
```
#### 4. Accesos rápidos (por comodidad): 
Para no tener que aputar a la ruta de lampp y mysql desde la terminal:

1. Abrir el archivo zshrc para crear los enlaces: 
```sh
sudo nano ~/.zshrc
```
2. Al final del archivo colocar los enlaces:
```
alias xampp='sudo /opt/lampp/manager-linux-x64.run'
alias xampp-mysql='/opt/lampp/bin/mysql -u root -p'
```

#### 5. Potential issues (carga y manipulación de archivos)
Si se espera que XAMPP sea capaz de crear archivos y manejarlos se deben conceder permisos a las carpetas que utilizará.

Ejemplo (para subidas):
```sh
chmod -R 755 /home/jorge/Teoría_Sistemas/SupermercadoTS1/uploads
```

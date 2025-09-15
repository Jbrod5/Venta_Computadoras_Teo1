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


## Instalacion de MariaDB en Solus
```sh
sudo eopkg install mariadb
sudo eopkg install mariadb-devel
```
Por defecto, eopkg no crea las carpetas necesarias para MariaDB.

Ejecutar:
```sh
sudo mkdir -p /var/lib/mysql
sudo chown -R mysql:mysql /var/lib/mysql
```

Luego, inicializar la base de datos manualmente para que se creen los archivos necesarios para MariaDB:
```sh
sudo mariadb-install-db --user=mysql --basedir=/usr --datadir=/var/lib/mysql
```

Ahora podemos iniciar MariaDB manualmente:
```sh
sudo mysqld_safe --datadir=/var/lib/mysql &
```
y conectarnos al cliente:
```sh
mariadb -u root
```

#### Cambiar la contraseña root
1. Conectarse directamente como administrador:
```sh
sudo mariadb
```
2. Cambiar el metodo de autenticacion y contraseña (`12345` como ejemplo):
```SQL
ALTER USER 'root'@'localhost' IDENTIFIED VIA mysql_native_password;
SET PASSWORD = PASSWORD('12345');
FLUSH PRIVILEGES;
```
3. Conectarse a la base de datos con la nueva contraseña:
```sh
mariadb -u root -p
```

## Configuracion del entorno (PHP, Laravel, Vue)
### Instalacion de PHP
Instalar PHP desde los repositorios de Solus
```sh
sudo eopkg install php
```
Instalar Composer (gestor de dependencias de PHP):
```sh
sudo eopkg install composer
```

#### Creando un proyecto con Laravel
Laravel se descargará e instalará cuando sea llamado por composer:
```sh
composer create-project laravel/laravel venta_computadoras
cd venta_computadoras
```
#### Ejecutar el servidor de Laravel: 
```sh
php artisan serve
```
Laravel devolverá un mensaje indicando la URL donde podremos acceder al servidor: 
```sh
Laravel development server started: http://127.0.0.1:8000
```

### Instalacion de Node y NPM
Utilizando el gestor de paquetes de Solus:
```sh
sudo eopkg install nodejs
sudo eopkg install npm
```
### Instalar Vue dentro de Larabel
ejecutar dentro del proyecto de Larabel:
```
npm install
npm install vue@3
npm install @vitejs/plugin-vue --save-dev
```

#### Registrar vue
En el archivo `resources/js/app.js` registrar vue, allí también van los imports:

```js
import { createApp } from 'vue';
import Producto from './Componentes/Producto.vue';

const app = createApp({});
app.component('producto', Producto);
app.mount('#app');

```


## Ejecucion
```sh
npm run dev   # Para desarrollo, compila el javascript 
php artisan serve  # Para levantar el servidor de Laravel
```








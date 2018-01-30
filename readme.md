
## Requisitos

La aplicación tiene las siguientes dependencias:

- [Laravel](https://laravel.com/docs/5.5#installation)
	- PHP >= 7.0
	- OpenSSL PHP Extension
	- PDO PHP Extension
	- Mbstring PHP Extension
	- Tokenizer PHP Extension
	- XML PHP Extension
- MySQL 5.7.17

## Configuración del servidor

En el servidor linux hay que cambiar la zona horaria a 'Europe/Madrid' ya que en MySQL la varibale time_zone esta como 'SYSTEM', con lo que usa la zona horaria del servidor en el que se encuentra. Para confirmar que la zona horaria de MySQL es 'SYSTEM' usamos la siguiente cosulta.

```
SELECT @@global.time_zone, @@session.time_zone;
```

En linux, disponemos de los siguientes comandos para realizar el cambio.

```shell
# Visualizar la zona horaria actual
date +%Z

# Listar zonas disponibles
timedatectl list-timezones

# Establecer la zona horaria
sudo timedatectl set-timezone Europe/Madrid
```

## Subir el proyecto al servidor y configurarlo

1. Crear las siguientes rutas:

```
/var/www/time_tracking/
/var/www/html/time_tracking/
```

2. Copiar el contenido del proyecto en ```/var/www/time_tracking/``` (descartar las carpeta node_modules y scripts). La carpeta public moverla a ```/var/www/html/time_tracking/```.
3. Estando en ```/var/www/```, ejecutar:

```
sudo chown www-data:www-data time_tracking/ -R
```

4. Dentro de la carpeta del proyecto ```/var/www/time_tracking```:

```
php artisan cache:clear
sudo chmod -R 777 storage/
```

5. Actualizar los parametros del fichero ".env".

6. Actualizar las rutas en el fichero ```/var/www/html/time_tracking/public/index.php``` de

```php
require __DIR__.'/../bootstrap/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
```

a

```php
require __DIR__.'/../../../time_tracking/bootstrap/autoload.php';

$app = require_once __DIR__.'/../../../time_tracking/bootstrap/app.php';
```

7. Estando en ```/var/www/html```, ejecutar:

```
sudo chown www-data:www-data time_tracking/ -R
```

8. Crear el Archivo Virtual Host.

```shell
cd /etc/apache2/sites-available
sudo cp 000-default.conf time_tracking.conf
sudo nano time_tracking.conf
```

```
<VirtualHost *:80>
        ServerName 3db-time_tracking.app
        ServerAlias www.3db-time_tracking.app
        DocumentRoot /var/www/html/time_tracking/public
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

9. Habilitar el fichero Virtual Host

```shell
sudo a2ensite time_tracking.conf
# En caso de querer deshabilitarlo
sudo a2dissite time_tracking.conf
```

Reiniciar Apache para asegurar que los cambios se apliquen

```shell
sudo service apache2 restart
```

10. Acceder a la web ```http://time-tracking.app```.

## Crontab

Las entradas no cerradas a final de dia se cerran al ejecutarse el comando 'record:close', el cual será ejecutado por el crontab.

```shell
* * * * * /usr/bin/php7.1 /var/www/html/artisan schedule:run 1>> /dev/null 2>&1
```

Tener en cuenta que las rutas existan.

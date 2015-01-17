Plan Abre
=========

# Atención, eso es SOLO para el entorno de desarrollo, no para el servidor de VisPress.

## Instalación

### 0. Chequear prerrequisitos

Requiere lo que requiere Symfony 2.3, para probar si tenemos todo podemos hacer:

    php app/check.php
    
Para más info ver: http://symfony.com/doc/2.3/reference/requirements.html

### 1. Clonar este repo

Simplemente mediante:

    git clone https://github.com/hhrosario/abresf.git

Y meterse en ese directorio.

Luego habilitar los permisos de escritura para Apache en el dir **recursos**.

    sudo chown -R www-data:www-data recursos

Y creamos un enlace simbólico dentro de web para ese directorio:

    cd web
    ln -s ../recursos recursos

### 2. Instalar las dependencias

Instalar Composer desde getcomposer.org o ejecutando:

    curl -s http://getcomposer.org/installer | php

Si está instalado globalmente sólo hace falta ejecutar:

    composer install

Sino, si se bajó el archivo phar, ejecutar:

    php composer.phar install

Esto va a instalar las dependencias.

Al final nos pregunta nuestra configuración de base de datos,
de mailer y nos pide un secret token que puede ser cualquier cosa.
Con eso crea el archivo **parameters.yml**

Las opciones por defecto están bien, poner los parámetros que correspondan
según la configuración local.

Esto **no crea la base de datos**, solo nos pide el nombre,
hay que crearla a mano. En esta guía el nombre es **abresfdb**.

Las dependencias son las default de Symfony, más el **FOSUserBundle**,
un bundle de Symfony2 para manejar usuarios muy usado.

### 3. Preparar la base de datos

Crear la base de datos, ejecutando:

    mysql -u [usuario] -p[password] -e "CREATE DATABASE abresfdb;" 

O con el gestor que sea, MySQL Workbench, phpmyadmin, etc.

Luego, se crea el schema (tablas, keys, indexes, etc) con: 

    app/console doctrine:schema:update --force

> Nota: si da errores de permisos en el directorio **app/cache** revisar cómo se especifican los permisos en la documentación de Symfony, o en todo caso, darle permisos full a ese directorio con: **sudo chmod -R 777 app/cache**. Lo mismo para el directorio **app/logs**.

### 4. Crear un dominio local y virtual host asociado

> Nota: Esto no es estrictamente necesario pero yo lo recomiendo mucho para cualquier proyecto en Symfony. Simplifica mucho. Mis ejemplos son para Ubuntu+Apache2.

Crear el archivo:

    /etc/apache2/sites-available/abresf.local

El contenido está en el directorio "otros-ejemplos" de este repo. Modificar los paths según corresponda.

Habilitar la configuración mediante:

    sudo a2ensite abresf.local

Crear un alias en el archivo **/etc/hosts** para ese dominio agregando una línea al final:

    127.0.0.1 abresf.local

Y reiniciar Apache:

    sudo service apache2 reload

### 5. Compilar y copiar los assets públicos

Ejecutar:

    app/console assets:install
    app/console assetic:dump

> Nota: si da error de permisos en algun directorio bundles, que suele pasar por ejecutar *composer install* como root, simplemente borrar el directorio bundles.

### 6. Verificar la configuración

A esta altura ya debería verse accesible la web vacía en:

    http://abresf.local/

> Nota: si acusa un problema de permisos con el directorio **app/logs** revisar lo mismo que con el directorio **app/cache** (ver nota más arriba)

### 7. Crear un usuario

Ingresando a:

    http://abresf.local/admin

Nos va a redireccionar a una pantalla de login. Como todavía no existe un usuario, hay que registrar uno yendo a:

    http://abresf.local/register/

> Esta URL la vamos a desactivar cuando terminemos el desarrollo.

Poner un email, nombre de usuario y password (por ejemplo: admin, prueba), y de nuevo el password donde dice "Verification".

No hace falta confirmar mail, ya con eso queda el usuario creado.

### 8. Importar los datos del webservice:

Los botones de importar están ocultos, mientras tanto, se pueden importar a mano con las URLs.

Hacerlo en este orden:

    http://abresf.local/admin/ejetrabajo/importar
    http://abresf.local/admin/lineaaccion/importar
    http://abresf.local/admin/intervencion/importar
    http://abresf.local/admin/localidad/importar
    http://abresf.local/admin/barrio/importar
    http://abresf.local/distrito/importar

Y finalmente los proyectos. Este proceso modifica el **memory_limit** de PHP mediante ini_set, la configuración de PHP puede impedir eso, verificarlo. Puede demorar.

    http://abresf.local/admin/proyecto/importar/

> Nota: incluir la barra al final

Con eso deberíamos poder ver los proyectos.

### 9. Editar un proyecto

Agregar unos datos y una imagen para testear la configuración.


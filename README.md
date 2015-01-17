Plan Abre
=========

## Instalación

### 1. Clonar este repo

Simplemente mediante:

    git clone https://github.com/hhrosario/abresf.git

Y meterse en ese directorio.

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

### 4. Crear un dominio local y virtual host asociado

Esto no es estrictamente necesario pero yo lo recomiendo mucho
para cualquier proyecto en Symfony.



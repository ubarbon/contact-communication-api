Contact Communication Api
=========

This test project is an API made with framework of Symfony3 version 3.4.20.

## Communication resource example
https://github.com/ubarbon/contact-communication-api/doc/communications.611111111.log

## Full Description of the test 
https://gist.github.com/miguelgf/e099e5e5bfde4f6428edb0ae94946c83
## Description Contact communication view

Lo que valoraremos del ejercicio es:
- Como te desenvuelves programando: rapidez, estilo, consistencia, etc...
- La eficacia e idoneidad de la idea
- La arquitectura del software

----

Disponemos de un fichero de log alojado en un servidor remoto que contiene las comunicaciones que un determinado
número de teléfono ha tenido a lo largo de un periodo de tiempo. 

Debes desarrollar una aplicación web que recupere y procese estos ficheros y muestre en el navegador **la lista de 
contactos**, y junto a cada uno de ellos, **la lista de las comunicaciones** que dicho número de teléfono ha tenido 
con ese contacto.

La composición de cada fichero de log es la siguiente:
  - El nombre del fichero seguirá un patrón `communications.XXXXXXXXX.log` dónde las X representarán el número de teléfono a consultar
  - Cada línea representa una comunicación entrante o saliente
  - Nos interesan sólo dos tipos de comunicaciones: **llamadas** y **SMSs**
  - Los registros de **llamadas** se componen de la siguiente estructura:
    - `1` char - Siempre tendremos una `C` indicando que es una llamada.
    - `9` chars - Indicando el número de origen de la comunicación
    - `9` chars - Indicando el número de destino de la comunicación
    - `1` char - Para saber si es entrante (`1`) o saliente (`0`)
    - `24` chars - Indicando el nombre del contacto
    - `14` chars - Indicando la fecha y la hora de la comunicación
    - `6` chars - Indicando la duración de la llamada
  - Los registros de **SMS** se componen de la siguiente estructura:
    - `1` char - Siempre tendremos una `S` indicando que es una llamada.
    - `9` chars - Indicando el número de origen de la comunicación
    - `9` chars - Indicando el número de destino de la comunicación
    - `1` char - Para saber si es entrante (`1`) o saliente (`0`)
    - `24` chars - Indicando el nombre del contacto
    - `14` chars - Indicando la fecha y la hora de la comunicación
  - Existen otros registros en el log que no nos interesa tener en cuenta en este caso.

----

Ten en cuenta que:
- El fichero debe recuperarse del servidor remoto. Vamos a asumir que nuestro server es `https://gist.githubusercontent.com/miguelgf/e099e5e5bfde4f6428edb0ae94946c83/raw/fa27e59eb8f14ee131fca5c0c7332ff3b924e0b2/`. Y el único fichero del que disponemos por ahora es `communications.611111111.log`.
- Puedes utilizar el framework que quieras, siempre que sea un entorno web.
- Trata de obtener un resultado óptimo desde el punto de vista del usuario

Dependencies
=========
- Install php7-fpm , please see http://blog.koenreiniers.nl/guide-to-combining-apache-virtual-hosts-and-php7-fpm
- You must have installed php7(fpm), apache, mysql database engine and the following php packages in order to work.
 
 - mysql (apt-get install php7.0-mysql)
 - xml   (apt-get install php7.0-xml)
 

Test
=========
Dependencies
=========
 - zip (apt-get install php7.0-zip)


1-Globally install the PHAR: https://phpunit.de/manual/current/en/installation.html#installation.phar
- $ wget https://phar.phpunit.de/phpunit-6.5.phar
- $ chmod +x phpunit-6.5.phar
- $ sudo mv phpunit-6.5.phar /usr/local/bin/phpunit
- $ phpunit --version
- PHPUnit x.y.z by Sebastian Bergmann and contributors.


Apache
=========
- Enable module "rewrite" (a2enmod rewrite)

Improvement
=========
 - intl  (apt-get install php7.0-int)

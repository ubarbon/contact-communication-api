Contact Communication Api
=========

This project is an API made with framework of Symfony3 version 3.4.20

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
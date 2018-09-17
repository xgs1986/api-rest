MODO API REST
========================

Instalación 
--------------
* instalar xampp: https://www.apachefriends.org/xampp-files/7.2.9/xampp-win32-7.2.9-0-VC15-installer.exe
* instalar composer: https://getcomposer.org/Composer-Setup.exe
* descargar el proyecto y pegarlo en xampp\httpdocs
* composer install --ignore-platform-reqs => en las preguntas dar todo intro para saltar y mantener los valores por defecto
* php bin/console doctrine:database:create
* php bin/console doctrine:schema:create
* php bin/console server:run
* acceder a http://localhost:800X/api/doc

Autentificación 
--------------
* Nos damos de alta con el user pass email que queramos en el endpoint register
* Una vez dados de alta, vamos al endpoint login, introduciendo el user/pass y este endpoint nos dará el token
* En el botón superior de Authorize, introducimos en el recuadro Bearer {token obtenido anteriomente} y damos a login y done.
* Ya podemos ejecutar tanto el car/coordinates como el car/reservation

Tests 
--------------
Nos situamos en el directorio raíz del proyecto y ejecutamos:
.\vendor\bin\phpunit tests\AppBundle\Controller\

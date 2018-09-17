MODO API REST
========================

Instalación 
--------------
* instalar xampp: https://www.apachefriends.org/xampp-files/7.2.9/xampp-win32-7.2.9-0-VC15-installer.exe
* instalar composer: https://getcomposer.org/Composer-Setup.exe
* descargar el proyecto y pegarlo en xampp\httpdocs
* composer install --ignore-platform-reqs
* php bin/console doctrine:database:create
* php bin/console doctrine:schema:create
* php bin/console server:run
* acceder a http://localhost:800X/api/doc

Autentificación 
--------------
* Nos damos de alta con el user pass email que queramos en el endpoint register
* Una vez dados de alta, vamos al endpoint login, introduciendo el user/pass y este endpoint nos dará el token
* En el botón superior de autentificación, introducimos en el recuadro Bearer {token obtenido anteriomente} y damos a login.
* Ya podemos ejecutar tanto el car/coordinates como el car/reservation

Tests 
--------------
Nos situamos en el directorio raíz del proyecto y ejecutamos:
.\vendor\bin\phpunit tests\AppBundle\Controller\


Directorios  
--------------
modo-api
├───app
│   │   .htaccess
│   │   AppCache.php
│   │   AppKernel.php
│   │
│   ├───config
│   │       config.yml
│   │       config_dev.yml
│   │       config_prod.yml
│   │       config_test.yml
│   │       parameters.yml
│   │       parameters.yml.dist
│   │       routing.yml
│   │       routing_dev.yml
│   │       security.yml
│   │       services.yml
│   │
│   └───Resources
│       └───views
│           │   base.html.twig
│           │
│           └───default
│                   index.html.twig
│
├───bin
│       console
│       symfony_requirements
│
├───config
│   └───jwt
│           private.pem 
│           private.pem-back
│           public.pem
│
├───src
│   │   .htaccess
│   │
│   └───AppBundle
│       │   AppBundle.php
│       │
│       ├───Controller
│       │       ExceptionController.php
│       │       RestCarCoordinatesController.php
│       │       RestCarReservationController.php
│       │       RestUserLoginController.php
│       │       RestUserRegisterController.php
│       │
│       ├───DataFixtures
│       │   └───ORM
│       │           LoadUserData.php
│       │
│       ├───Entity
│       │   │   CarReservation.php
│       │   │   User.php
│       │   │
│       │   └───Common
│       │           HTTPResponseEntity.php
│       │
│       ├───EventListener
│       │       AuthenticationListener.php
│       │
│       │
│       ├───Services
│       │       CarListService.php
│       │       CarService.php
│       │       ClientFactory.php
│       │       DatabaseConnectionService.php
│       │       LocationListService.php
│       │       RequestHandlerService.php
│       │       ResponseViewService.php
│       │       UserService.php
│       │
│       └───Utils
│               ApiException.php
│               DataBaseQueries.php
│               ModoHandlerRequest.php
│               Utilities.php
│
└───tests
    └───AppBundle
        ├───Controller
        │       CarCoordinatesControllerTest.php
        │       CarReservationControllerTest.php
        │       UserLoginControllerTest.php
        │       UserRegisterControllerTest.php
        │
        └───Lib
                FunctionalTestsHelper.php
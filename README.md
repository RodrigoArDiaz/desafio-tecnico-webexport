# Proyecto Laravel 11 - CRUD de Usuarios y Roles - Desafio tecnico

Este proyecto es una aplicación web desarrollada en Laravel 11 que permite gestionar usuarios y roles. Utiliza MySQL como base de datos, plantillas Blade para la vista y Bootstrap 5.3 para el diseño.

## Requisitos Previos

- PHP 8.2 o superior
- Composer
- MySQL
- Git

## Instalación

Sigue estos pasos para configurar el proyecto en tu entorno local:

1. **Clonar el repositorio**

   ```bash
   git clone https://github.com/RodrigoArDiaz/desafio-tecnico-webexport.git
   
   cd desafio-tecnico-webexport

2. **Configurar el archivo .env**

   Copia el archivo .env.example y renómbralo a .env. Luego, configura las variables de entorno necesarias, especialmente las relacionadas con la base de datos:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nombre_de_tu_base_de_datos
   DB_USERNAME=tu_usuario_mysql
   DB_PASSWORD=tu_contraseña_mysql


3. **Generar la clave de aplicación**

   ```bash
   php artisan key:generate

4. **Instalar dependencias de Composer**

   ```bash
   composer install


5. **Ejecutar migraciones y seeders**

   El seeder 'DatosTestSeeder' contiene la logica para generar permisos predefinidos y los usuarios de prueba (incluyendo superadministrador, usuario con privilegios para acceder al CRUD de usuarios y de roles). Revisar el archivo del seeder para mas información.

   ```bash
   php artisan migrate
   php artisan db:seed --class=DatosTestSeeder

6. **Iniciar el servidor de desarrollo**

   El proyecto estará disponible en http://localhost:8000 luego de ejecutar.

   ```bash
   php artisan serve


## Uso

1. CRUD de Usuarios: Accede a la gestión de usuarios a través de la ruta /usuarios.

2. CRUD de Roles: Accede a la gestión de roles a través de la ruta /roles.

# Ejemplos con PHP 8.2

- calculator.php: Ejemplo de una calculadora simple para realizar operaciones básicas.
- password.php: Ejemplo de como generar una contraseña aleatoria.
- process_image.php: Ejemplo para generar una imagen de un servicio externo.
- tasks.php: Ejemplo de como crear un todo list para agregar, eliminar y editar tareas.
- users.php: Este ejemplo es para realizar un CRUD de usuarios.
- search.php: En este ejemplo se muestra como realizar una búsqueda en una base de datos.
- login.php: Ejemplo de como realizar un login con PHP.
- html.php: Aquí he puesto en práctica lo que voy aprendiendo de JavaScript.

> Notas:
>
> - Este repositorio se irá actualizando con más ejemplos, será un repositorio de referencia sobre PHP 8.2.
> - Son ejercicios simples que estoy realizando para aprender PHP 8.2.
> - Se irán agregando ejemplos mientras voy cursando los cursos de [Academia Joystick](https://www.academy.joystick.com.mx/).
> - La documentación y mensajes del código fuente estará en ingles, pero los archivos '*.md' de los ejemplos estarán en español.

## Ideas propuestas para el proyecto final

- Desarrollar un framework simple para crear aplicaciones web.
- Crear una estructura para los temas de CSS y definir un sistema de plantillas.
- Crear un sistema de autenticación simple.
- Crear un sistema de roles y permisos.
- Se piensa usar la menor cantidad de librerías externas.
- El ORM a usar será Doctrine, porque es el más usado en PHP.
- Al principio se usará MySQL, pero se piensa usar PostgreSQL.
- Se piensa usar Docker para el entorno de desarrollo.
- Se piensa usar PHPUnit para las pruebas unitarias.
- Se busca que el framework sea simple y fácil de usar.
- Primero se desarrollará el framework y luego se creará una aplicación de ejemplo.
- Se piensa usar el patrón MVC para después hacer un micro framework.

## Sobre el proyecto

El proyecto se llama "Visita Por Mexico" y es un proyecto para promover el turismo en México.

Usando el framework se creará una aplicación web para promover el turismo en México de una forma simple y fácil de usar.

Pienso usar la base de hoteles de la empresa en la que trabajo ([Revenatium](https://www.revenatium.com/)) para promocionar los hoteles de México mediante SEO y redes sociales.

Busco mejorar mis técnicas de SEO orgánico y aprender a usar las redes sociales para promocionar los hoteles de México.

> En general mi objetivo es crear una aplicación web que sea simple y fácil de usar, que sea rápida y que tenga un buen SEO.

### Entorno de desarrollo

- Herd 1.2.0 - Build 14
- Composer 2.5.5
- PHP 8.2.9
- MySQL 8.0
- Prepros 7.9.0
- Visual Studio Code

### Instalación

- Clonar el repositorio.
- Ejecutar `composer install`.
- Se usa la dependencia de monolog para los logs de la aplicación.
- Ejecutar Prepros para compilar los archivos de Sass.
- Crear la base de datos que se encuentra en la carpeta `db` para MySQL, que sirve para los ejemplos de `users.php` y `search.php`.

## Sobre la estructura del proyecto

- `assets`: Contiene los archivos de Sass y JavaScript, que se compilan con Prepros.
  - `css`: Contiene los archivos de CSS.
    - `main.scss`: Contiene el archivo principal de Sass, este archivo se compila con Prepros y genera el archivo `main.min.css`. Es un `custom framework` de CSS con temas y enfocado a `mobile first` con media query responsive para los demás tipos de dispositivos.
    - `normalize.css`: Contiene el archivo de Normalize CSS, para normalizar los estilos de los navegadores.
  - `js`: Contiene los archivos de JavaScript.
    - `main.js`: Contiene el archivo principal de JavaScript, este archivo se compila con Prepros y genera el archivo `main.min.js`. Contiene pequeños ejemplos de JavaScript.
  - `img`: Contiene las imágenes, de momento solo hay un favicon.
- `db`: Contiene la base de datos para MySQL.
  - `database.sql`: Contiene la base de datos para el ejemplo de `users.php` y `search.php`.
- `logs`: Dentro de esta carpeta se guardan los logs de la aplicación.
- `src`: Contiene el código fuente de la aplicación.
  - `Controllers`: Contiene las clases para el manejo de las peticiones HTTP.
  - `Core`: Contiene las clases principales de la aplicación.
  - `Crud`: Contiene las clases para realizar un CRUD.
  - `Examples`: Contiene los ejemplos de la aplicación.
  - `Exceptions`: Contiene las clases para las excepciones.
  - `Helpers`: Contiene las clases para los helpers.
  - `Hooks`: Contiene las clases para los hooks.
  - `Models`: Contiene las clases para el modelo de la aplicación.
  - `Routes`: Contiene las clases para las rutas de la aplicación.
  - `Services`: Contiene las clases para los servicios de la aplicación.
  - `Templates`: Contiene las clases para las plantillas de la aplicación.
    - `Includes`: Contiene las clases para los partials de la aplicación.
    - `Layouts`: Contiene las clases para los layouts de la aplicación.
    - `Pages`: Contiene las clases para las páginas de la aplicación.
    - `Views`: Contiene las clases para las vistas de la aplicación.
    - `Widgets`: Contiene las clases para los widgets de la aplicación.
  - `Tests`: Contiene las clases para las pruebas unitarias.
- `vendor`: Contiene las dependencias de Composer.

## Importante

- Estoy usando PSR-4 para el `autoloading` de clases, por eso todas las clases están en la carpeta `src`.
- La carpeta `src` será la carpeta raíz del proyecto.
- Mi idea es trabajar con namespaces para organizar las clases y usar el `autoloading` de Composer.
- También tengo pensado ir evolucionando el proyecto usando buenas prácticas de programación y orientación a objetos.
- No se si sea correcto pero estoy cargando el archivo `autoload.php` de Composer con un `require_once` en cada archivo de la carpeta `src`.

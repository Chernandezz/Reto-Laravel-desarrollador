
# Instalación

1. Abrir el terminal en la carpeta raiz

2. Dirigirse a la carpeta my-proyect

3. Ejecutar el comando composer i

   - Si se tiene una alerta/error similar a este "Failed to download webmozart/assert from dist: The zip extension and unzip/7z commands are both missing, skipping. The php.ini used by your command-line PHP is: C:\xampp\php\php.ini Now trying to download from source"
   - ir al archivo php.ini y descomendar la linea ";extension=zip"
   - repetir punto 1

4. Regresar a la raiz del proyecto

5. Montar el contenedor con "docker compose up"

6. En un nuevo terminal ir a la raiz del proyecto e ingresar al terminal del contenedor de laravel con "docker exec -it <nombre  servicio  laravel  en  el  contenedor> bash"

7. Ejecutar la migracion de la BD "php artisan migrate:refresh --seed"

8. El proyecto ya se encuentra listo ejecutandose en "http://127.0.0.1:8000/" y con las respectivas tablas

9. Empezar a probar y ejecutar las peticiones del postman que se encuentran en un archivo JSON en la raiz del proyeto

## Librerías usadas

- JWT Auth: Para manejar el login del proyecto

- fakerphp/faker: Para la creacion de los seeders

## Otros

- Se adjunta un archivo de postman con todas las apis con ejemplos y listas para ser probadas

## Categorias creadas

- Pesadas

- Alicates

- Taladro

## Tecnologias usadas

- Laravel

- PHP

- Git

- Github

- Postman

- Docker

## Diccionario de datos

## Tabla: "maquinarias"


| Columna | Tipo de dato | Descripción |
| ------------ |----------------------------------|--------|
| id | integer | Identificador único de la maquinaria. |
| name | string | Nombre de la maquinaria. |
| description | string | Descripción detallada de la maquinaria. |
| availability | timestamp | Indicador de disponibilidad de la maquinaria. Los valores posibles son 1 (disponible), 0 (no disponible) y 2 (suspendida). |
| dailyPrice | string | Precio diario de alquiler de la maquinaria. |
| category | string | Categoría a la que pertenece la maquinaria. |
| created_at | datetime | Fecha y hora de creación del registro. |  
| updated_at | datetime | Fecha y hora de última actualización del registro. |

---

## Tabla: "reserva_maquinarias"

| Columna | Tipo de dato | Descripción |
| ------------- | ------------ | ---------------------------------------------------------- |
| id | integer | Identificador único de la reserva de maquinaria. |
| maquinaria_id | string | Identificador único de la maquinaria reservada. |
| user_id | string | Identificador único del usuario que realiza la reserva. |
| fecha_inicio | timestamp | Fecha en que se inicia la reserva en formato "YYYY-MM-DD". |
| fecha_fin | string | Fecha en que finaliza la reserva en formato "YYYY-MM-DD". |
| dias | string | Número de días de duración de la reserva. |
| precio_total | string | Precio total de la reserva. |
| created_at | datetime | Fecha y hora de creación del registro. |
| updated_at | datetime | Fecha y hora de última actualización del registro. |

---

## Tabla: "Users"

| Columna | Tipo de dato | Descripción |
| ----------------- | ------------ | ----------------------------------------------------------------- |
| id | integer | Identificador único del usuario. |
| name | string | Nombre del usuario. |
| email | string | Dirección de correo electrónico del usuario. |
| email_verified_at | timestamp | Fecha y hora en que se verificó el correo electrónico del usuario. |
| password | string | Contraseña encriptada del usuario. |
| role | string | Rol del usuario en el sistema (por defecto: "user"). |
| remember_token | string | Token de autenticación persistente. |
| created_at | timestamp | Fecha y hora de creación del registro. |
| updated_at | timestamp | Fecha y hora de última actualización del registro. |

---

## Tabla: "Password Reset Tokens"

| Columna | Tipo de dato | Descripción |
| ---------- | ------------ | ------------------------------------------------------------------------------ |
| email | string | Correo electrónico del usuario que solicita el restablecimiento de contraseña. |
| token | string | Token generado para restablecer la contraseña del usuario. |
| created_at | string | Fecha de creación del token de restablecimiento de contraseña. |

---

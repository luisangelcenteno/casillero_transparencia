# Casillero Digital - Arquitectura estilo Laravel

Esta carpeta reorganiza el proyecto PHP original en una arquitectura MVC inspirada en Laravel.

## Estructura

- `public/index.php`: punto de entrada unico de la aplicacion.
- `routes/web.php`: rutas web de la aplicacion.
- `app/Controllers`: controladores por modulo.
- `app/Models`: consultas y operaciones de base de datos.
- `app/Core`: router, controlador base, conexion PDO y helpers.
- `resources/views`: vistas separadas por modulo.
- `config/database.php`: configuracion de PostgreSQL.
- `storage/uploads`: archivos subidos por los usuarios.

## Rutas principales

- `/login`
- `/registro`
- `/recuperar`
- `/dashboard`
- `/solicitudes`
- `/solicitudes/crear`
- `/solicitudes/detalle?id=1`
- `/ubigeo?dep=15`
- `/ubigeo?prov=1501`

## Ejecucion local

Desde esta carpeta, si PHP esta instalado:

```bash
php -S localhost:8000 -t public
```

Luego abrir:

```text
http://localhost:8000/login
```

## Base de datos

La conexion usa los mismos datos del proyecto original:

```text
host: localhost
port: 3306
database: casillatransparencia
user: root
password:
```

Tambien se dejo `.env.example` como referencia si luego desean evolucionarlo hacia Laravel real.

## Nota

No se borro el proyecto original. Esta version queda como una migracion organizada para demostrar la arquitectura y facilitar una futura conversion a Laravel completo.

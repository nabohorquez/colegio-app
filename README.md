# AcademicSoft

Sistema web de administración escolar desarrollado con Laravel. La aplicación organiza la gestión académica y administrativa del colegio desde módulos protegidos por inicio de sesión y permisos por rol.

## Funcionalidades

- Inicio de sesión y administración de usuarios, roles y permisos.
- Gestión de páginas y módulos del menú según los permisos asignados.
- Registro de estudiantes, acudientes y empleados.
- Administración de matrículas, tipos de matrícula, grados y asignaturas.
- Gestión de temas, actividades y contenidos académicos.
- Registro y consulta de calificaciones, con reportes detallados y consolidados.

## Tecnologías

- PHP 7.3 o superior (también compatible con PHP 8).
- Laravel 8.
- MySQL (configurable mediante Laravel).
- Node.js y npm para compilar los recursos del frontend con Laravel Mix.

## Requisitos previos

Instala PHP y Composer, una base de datos compatible (por ejemplo, MySQL) y Node.js con npm. En Windows, el proyecto puede ejecutarse con Laragon.

## Instalación

1. Clona el repositorio y entra en la carpeta del proyecto.

   ```bash
   git clone <URL_DEL_REPOSITORIO>
   cd colegio-app
   ```

2. Instala las dependencias de PHP y JavaScript.

   ```bash
   composer install
   npm install
   ```

3. Crea el archivo de entorno y genera la clave de la aplicación.

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   En Windows PowerShell, puedes copiar el archivo con:

   ```powershell
   Copy-Item .env.example .env
   ```

4. Crea una base de datos vacía y actualiza en `.env` los valores `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD` según tu entorno. Revisa también `APP_NAME` y `APP_URL`.

5. Ejecuta las migraciones y los seeders disponibles.

   ```bash
   php artisan migrate --seed
   ```

6. Compila los recursos del frontend.

   ```bash
   npm run dev
   ```

7. Inicia el servidor de desarrollo.

   ```bash
   php artisan serve
   ```

Abre la URL que indique Artisan (normalmente `http://127.0.0.1:8000`). La ruta inicial redirige al formulario de inicio de sesión.

## Desarrollo del frontend

Para recompilar automáticamente los recursos al modificarlos:

```bash
npm run watch
```

Para generar recursos optimizados:

```bash
npm run production
```

## Base de datos y datos iniciales

Las migraciones están en `database/migrations` y los seeders en `database/seeders`. El seeder principal es `DatabaseSeeder`; consulta allí qué datos iniciales se insertan antes de ejecutar `migrate --seed` en un entorno existente. Para volver a crear la base de datos desde cero, Laravel ofrece `php artisan migrate:fresh --seed`, que elimina las tablas existentes: úsalo solo cuando sea seguro borrar esos datos.

## Pruebas

El proyecto incluye configuración de PHPUnit. Para ejecutar las pruebas:

```bash
php artisan test
```

También puedes usar `vendor/bin/phpunit`.

## Estructura principal

- `app/Http/Controllers`: controladores de las operaciones de la aplicación.
- `app/Models`: modelos Eloquent.
- `database/migrations`: esquema y cambios de base de datos.
- `database/seeders`: roles, permisos y datos iniciales.
- `resources/views`: vistas Blade.
- `routes/web.php`: rutas web, incluyendo las protegidas por autenticación y permisos.
- `docs/class-diagram.puml`: diagrama de clases del dominio.

## Acceso inicial

Revisa `database/seeders` (en particular `FirstUser.php` y `DatabaseSeeder.php`) para conocer cómo se crea el usuario inicial. No guardes credenciales reales en el repositorio; define las credenciales de cada entorno de manera segura.

## Configuración de IA

`.env.example` incluye variables opcionales para seleccionar el proveedor y el modelo de IA mediante `AI_PROVIDER` y `AI_DEFAULT_MODEL`. Configura las credenciales adicionales que requiera el proveedor en tu entorno si utilizas esa integración.

## Seguridad

No publiques el archivo `.env` ni compartas claves o contraseñas. En producción, configura `APP_DEBUG=false`, usa una clave de aplicación privada y establece correctamente `APP_URL` y la conexión de base de datos.

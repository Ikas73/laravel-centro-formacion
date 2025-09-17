# Centro de Formación – Laravel 12 + Docker

Este proyecto es una aplicación web para la gestión de cursos, alumnos, profesores y horarios en un centro de formación. Está construido con **Laravel 12** y utiliza **Docker** para facilitar la instalación y el desarrollo, sin importar el sistema operativo.

---

## 📚 Documentación Técnica Ampliada

¿Quieres ver la arquitectura, diagramas y detalles técnicos?  
Consulta la documentación completa aquí:  
🔗 [Gestión de Cursos y Eventos - DeepWiki](https://deepwiki.com/Ikas73/laravel-centro-formacion/3.1-course-and-event-management)

---

## Tabla de Contenidos

- [Descripción General](#descripción-general)
- [Tecnologías y Servicios](#tecnologías-y-servicios)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Principales Funcionalidades](#principales-funcionalidades)
- [Requisitos Previos](#requisitos-previos)
- [Instalación y Puesta en Marcha](#instalación-y-puesta-en-marcha)
- [Comandos Útiles](#comandos-útiles)
- [Contribuciones](#contribuciones)
- [Licencia](#licencia)

---

## Descripción General

El objetivo de este proyecto es proporcionar una plantilla robusta y escalable para aplicaciones Laravel, facilitando el desarrollo local y la futura puesta en producción. Gracias a Docker, la configuración del entorno es sencilla, reproducible y desacoplada del sistema operativo anfitrión.

Incluye:
- **Laravel 12** como framework principal.
- **PHP 8.3** ejecutándose sobre FPM-Alpine.
- **PostgreSQL 14** como base de datos relacional.
- Gestión de dependencias con **Composer** y **npm**.
- Soporte para desarrollo frontend moderno con **Vite** y **TailwindCSS**.
- Panel de administración para gestión de alumnos, profesores, cursos y preinscripciones.

---

## 🚀 ¿Qué puedes hacer con este proyecto?

- Gestionar alumnos, profesores, cursos y preinscripciones.
- Visualizar y editar horarios de cursos.
- Usar un panel de administración con estadísticas y KPIs.
- Disfrutar de un diseño moderno y responsive.
- Automatizar tareas con comandos personalizados y scripts.

---

## 🛠️ Tecnologías y Servicios

- **Laravel 12** (PHP 8.3)
- **Docker** y **Docker Compose**
- **PostgreSQL 14** (puerto 49000)
- **Node.js & npm** (para assets frontend)
- **Composer** (gestión de dependencias PHP)
- **Vite** (build frontend)
- **TailwindCSS** y **Bootstrap Icons**
- **Redis** (extensión PHP instalada, servicio no incluido por defecto)
- Servicios adicionales fácilmente integrables: **pgAdmin**, etc.
- **Testing:** PHPUnit
- **Scripts útiles:** carpeta `scripts/` para automatizaciones

---

## 📁 Estructura del Proyecto

```
proyecto-laravel/
├── docker-compose.yml
├── Dockerfile
├── app/                # Lógica de la aplicación (modelos, controladores, etc.)
├── public/             # Punto de entrada web
├── routes/             # Definición de rutas
├── database/           # Migraciones, seeders y factories
├── resources/          # Vistas Blade, CSS y JS
├── storage/            # Archivos generados y logs
├── scripts/            # Scripts útiles para desarrollo y despliegue
├── config/             # Configuración de Laravel
├── .env.example        # Variables de entorno de ejemplo
├── composer.json       # Dependencias PHP
├── package.json        # Dependencias JS
├── tailwind.config.js  # Configuración TailwindCSS
├── vite.config.js      # Configuración Vite
└── ...
```

- **Dockerfile**: Imagen personalizada para Laravel (PHP-FPM, Node.js, Composer, Redis).
- **docker-compose.yml**: Orquestación de servicios (app, db).
- **app/**: Lógica de la aplicación Laravel (modelos, controladores, etc.).
- **routes/**: Definición de rutas web y API.
- **database/**: Migraciones, seeders y factories.
- **resources/**: Vistas Blade, CSS y JS.
- **storage/**: Archivos generados y logs.
- **scripts/**: Scripts útiles para desarrollo y despliegue.
- **config/**: Archivos de configuración de Laravel.

---

## Principales Funcionalidades

- **Gestión de Alumnos:** Alta, listado, filtrado, búsqueda y paginación. Soporte para campos como nombre, apellidos, DNI, email, nivel formativo y estado (Activo, Inactivo, Pendiente, Baja).
- **Gestión de Profesores y Cursos:** Estructura preparada para CRUD completo.
- **Preinscripciones:** Migraciones y vistas para gestión de preinscritos.
- **Gestión de Horarios:** Sincronización automática desde el campo `horario` de los cursos y comandos Artisan personalizados.
- **Panel de Administración:** Dashboard con KPIs, tarjetas resumen, ratio alumno-profesor y tasa de asistencia.
- **Diseño Responsive:** Layouts personalizados con TailwindCSS y Bootstrap Icons.
- **Autenticación y Seguridad:** Integración con sistema de usuarios de Laravel.
- **Frontend Moderno:** Vite, TailwindCSS, Alpine.js y efectos visuales modernos.
- **Soporte para migraciones y seeders personalizados.**
- **Testing:** PHPUnit para pruebas automáticas.
- **Automatización:** Scripts y comandos personalizados para despliegue y sincronización.

---

## Requisitos Previos

- [Docker](https://docs.docker.com/get-docker/) instalado
- [Docker Compose](https://docs.docker.com/compose/install/) instalado
- [Git](https://git-scm.com/) instalado

---

## 📝 Instalación y Puesta en Marcha

### 1. Clona el repositorio

```bash
git clone <URL_DEL_REPOSITORIO>
cd proyecto-laravel
```

### 2. Copia y configura el archivo de entorno

```bash
cp .env.example .env
```
Edita `.env` si necesitas cambiar usuario/contraseña de la base de datos, etc.

### 3. Construye y levanta los servicios

```bash
docker-compose up --build -d
```

### 4. Instala dependencias de Laravel y frontend

```bash
docker-compose exec app composer install
docker-compose exec app npm install
docker-compose exec app npm run build
```

### 5. Genera la clave de la aplicación

```bash
docker-compose exec app php artisan key:generate
```

### 6. Ejecuta las migraciones y seeders

```bash
docker-compose exec app php artisan migrate --seed
```

---

### WARP-workflow: Desplegar Cambios de Frontend

Para agilizar el proceso de actualización de la demo después de realizar cambios en el frontend (CSS, JavaScript, etc.), se ha creado un workflow específico para la terminal [Warp](https://www.warp.dev/).

Este workflow automatiza los pasos necesarios para que tus modificaciones visuales se reflejen correctamente en el entorno de producción/demo, evitando el error común de que los estilos no se carguen.

#### El Workflow: `demo-frontend.yml`

Este es el código que necesitas guardar para que Warp lo reconozca.

**Ubicación del archivo:** `~/.warp/workflows/demo-frontend.yml`

```yaml
name: Demo Laravel: Desplegar con Cambios Frontend
command: |
  echo "🎨 Compilando activos de frontend con Vite..."
  npm run build
  echo "🔵 Levantando los contenedores en segundo plano..."
  docker-compose up -d
  echo "🟢 Contenedores iniciados. Obteniendo la URL del túnel..."
  echo "--------------------------------------------------------"
  docker-compose logs cloudflared-tunnel
  echo "--------------------------------------------------------"
  echo "✅ Copia la URL pública de arriba para ver tu demo."
description: Recompila los activos de Vite (CSS/JS) y luego levanta los contenedores y muestra la URL. Úsalo SIEMPRE que modifiques archivos en resources/js o resources/css.
author: Gemini
tags:
  - laravel
  - docker
  - vite
  - frontend
```

#### ¿Cómo se utiliza?

Una vez que hayas guardado el archivo `.yml` en la ubicación correcta:

1.  **Navega a la raíz** de tu proyecto en la terminal Warp.
2.  Abre el lanzador de Workflows con `Ctrl + Shift + R`.
3.  Busca y selecciona **"Demo Laravel: Desplegar con Cambios Frontend"**.
4.  Presiona `Enter`.

#### ¿Qué hace este workflow?

Al ejecutarlo, el workflow realiza los siguientes pasos en orden:

1.  **`npm run build`**: Toma todos tus archivos de `resources/css` y `resources/js`, los compila y los empaqueta en la carpeta `public/build`. Este es el paso más importante para que tus cambios sean visibles.
2.  **`docker-compose up -d`**: Inicia (o reinicia) los contenedores de Docker en segundo plano, asegurando que tu aplicación esté corriendo con el código más reciente.
3.  **`docker-compose logs cloudflared-tunnel`**: Muestra el registro del contenedor de Cloudflare, donde encontrarás la **URL pública y temporal** para acceder a tu demo.

Con un solo comando, te aseguras de que tu demo está compilada, corriendo y accesible.


---


## 💡 Comandos Útiles

- **Ver logs de un servicio:**  
  `docker-compose logs <servicio>`
- **Detener los servicios:**  
  `docker-compose down`
- **Acceder a la aplicación:**  
  - Laravel: [http://localhost:8000](http://localhost:8000)
  - PostgreSQL: puerto `49000`
- **Ejecutar comandos Artisan:**  
  `docker-compose exec app php artisan <comando>`
- **Ejecutar scripts automáticos:**  
  `./scripts/git-push.sh`

---

## Contribuciones

¡Las contribuciones son bienvenidas! Para contribuir:

1. Haz un fork del repositorio.
2. Crea una rama para tu funcionalidad:
    ```bash
    git checkout -b mi-nueva-funcionalidad
    ```
3. Realiza tus cambios y haz commit.
4. Envía un pull request.

---

## 🆘 ¿Necesitas ayuda?

- Consulta la documentación técnica en DeepWiki (enlace arriba).
- Abre un issue en GitHub o contacta con el autor.

---

## Licencia

Este proyecto está bajo la licencia [MIT](LICENSE).

---

> ¿Dudas o sugerencias? Abre un issue o contacta con el autor del repositorio.
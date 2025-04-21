# Centro de Formación – Laravel 12 + Docker

Este proyecto es una base profesional para el desarrollo de aplicaciones web modernas utilizando **Laravel 12** y un entorno de desarrollo completamente orquestado con **Docker**. Incluye servicios para base de datos PostgreSQL y servidor PHP-FPM, y está preparado para integración con herramientas modernas de frontend y servicios adicionales como Redis o pgAdmin si lo necesitas.

---

## Tabla de Contenidos

- [Descripción General](#descripción-general)
- [Tecnologías y Servicios](#tecnologías-y-servicios)
- [Estructura del Proyecto](#estructura-del-proyecto)
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
- Soporte para desarrollo frontend moderno con **Vite**.

---

## Tecnologías y Servicios

- **Laravel 12** (PHP 8.3)
- **Docker** y **Docker Compose**
- **PostgreSQL 14**
- **Node.js & npm** (para assets frontend)
- **Composer** (gestión de dependencias PHP)
- Servicios adicionales fácilmente integrables: **Redis**, **pgAdmin**, etc.

---

## Estructura del Proyecto

```
[01]Docker_Proyecto/
│
├── docker-compose.yml
├── Dockerfile
├── src/
│   ├── app/
│   ├── public/
│   ├── routes/
│   ├── database/
│   ├── .env.example
│   ├── composer.json
│   ├── package.json
│   └── ...
└── ...
```

- **Dockerfile**: Imagen personalizada para Laravel (PHP-FPM, Node.js, Composer, Redis).
- **docker-compose.yml**: Orquestación de servicios (app, db).
- **src/**: Código fuente de la aplicación Laravel.

---

## Requisitos Previos

- [Docker](https://docs.docker.com/get-docker/) instalado
- [Docker Compose](https://docs.docker.com/compose/install/) instalado
- [Git](https://git-scm.com/) instalado

---

## Instalación y Puesta en Marcha

1. **Clona el repositorio:**
    ```bash
    git clone <URL_DEL_REPOSITORIO>
    cd [01]Docker_Proyecto
    ```

2. **Copia el archivo de entorno y configura variables:**
    ```bash
    cp src/.env.example src/.env
    ```
    Edita `src/.env` según tus necesidades (usuario y contraseña de la base de datos, etc).

3. **Construye y levanta los servicios:**
    ```bash
    docker-compose up --build -d
    ```

4. **Instala las dependencias de Laravel:**
    ```bash
    docker exec -it centro_app composer install
    ```

5. **Instala dependencias de frontend (opcional):**
    ```bash
    docker exec -it centro_app npm install
    docker exec -it centro_app npm run build
    ```

6. **Genera la clave de la aplicación:**
    ```bash
    docker exec -it centro_app php artisan key:generate
    ```

7. **Ejecuta las migraciones de la base de datos:**
    ```bash
    docker exec -it centro_app php artisan migrate
    ```

---

## Comandos Útiles

- **Ver logs de un servicio:**
    ```bash
    docker-compose logs <servicio>
    ```
- **Detener los servicios:**
    ```bash
    docker-compose down
    ```
- **Acceder a la aplicación:**
    - Laravel: [http://localhost:8000](http://localhost:8000)
    - PostgreSQL: puerto `54321` (ver docker-compose)

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

## Licencia

Este proyecto está bajo la licencia [MIT](LICENSE).

---

> ¿Dudas o sugerencias? Abre un issue o contacta con el autor del repositorio.
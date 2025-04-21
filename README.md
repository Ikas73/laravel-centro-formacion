# Proyecto Centro de Formación - Laravel + Docker

Este proyecto es una aplicación web desarrollada con **Laravel** y preparada para ejecutarse en un entorno **Docker**. Incluye servicios para la base de datos (**PostgreSQL**), cacheo (**Redis**), administración de base de datos (**pgAdmin**), servidor web (**Nginx**) y búsqueda avanzada (**Elasticsearch**).

## Tabla de Contenidos

- [Descripción](#descripción)
- [Tecnologías Utilizadas](#tecnologías-utilizadas)
- [Requisitos Previos](#requisitos-previos)
- [Instalación](#instalación)
- [Uso](#uso)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Contribuciones](#contribuciones)
- [Licencia](#licencia)

---

## Descripción

El objetivo de este proyecto es proporcionar una base robusta y escalable para el desarrollo de aplicaciones web modernas, utilizando Laravel como framework principal y Docker para facilitar la configuración y despliegue en cualquier entorno. El stack incluye servicios adicionales como Redis para cacheo, PostgreSQL como base de datos principal, pgAdmin para administración visual y Elasticsearch para búsquedas avanzadas.

## Tecnologías Utilizadas

- **Laravel 12** (PHP 8.3)
- **Docker** y **Docker Compose**
- **PostgreSQL 14**
- **Redis**
- **pgAdmin 4**
- **Nginx**
- **Elasticsearch**
- **Node.js & npm** (para assets frontend)
- **Composer** (gestión de dependencias PHP)

## Requisitos Previos

- [Docker](https://docs.docker.com/get-docker/) instalado
- [Docker Compose](https://docs.docker.com/compose/install/) instalado
- [Git](https://git-scm.com/) instalado

## Instalación

1. **Clona el repositorio:**
    ```bash
    git clone <URL_DEL_REPOSITORIO>
    cd [01]Docker_Proyecto
    ```

2. **Copia el archivo de entorno:**
    ```bash
    cp src/.env.example src/.env
    ```

3. **Configura las variables de entorno** en `src/.env` según tus necesidades (usuario y contraseña de la base de datos, etc).

4. **Construye y levanta los servicios:**
    ```bash
    docker-compose up --build -d
    ```

5. **Instala las dependencias de Laravel:**
    ```bash
    docker exec -it <nombre_contenedor_app> composer install
    ```

6. **Genera la clave de la aplicación:**
    ```bash
    docker exec -it <nombre_contenedor_app> php artisan key:generate
    ```

7. **Ejecuta las migraciones de la base de datos:**
    ```bash
    docker exec -it <nombre_contenedor_app> php artisan migrate
    ```

> **Nota:** Reemplaza `<nombre_contenedor_app>` por el nombre real del contenedor de la aplicación (por ejemplo, `centro_app` si así lo defines en `docker-compose.yml`).

## Uso

- Accede a la aplicación en: [http://localhost:8080](http://localhost:8080)
- Accede a pgAdmin en: [http://localhost:5050](http://localhost:5050)
- El servidor Nginx sirve la aplicación Laravel desde el directorio `public`.

### Comandos útiles

- **Ver logs de un servicio:**
    ```bash
    docker-compose logs <servicio>
    ```
- **Detener los servicios:**
    ```bash
    docker-compose down
    ```

## Estructura del Proyecto

```
[01]Docker_Proyecto/
│
├── docker-compose.yml
├── Dockerfile
├── nginx/
│   └── conf.d/
│       └── default.conf
├── src/
│   ├── app/
│   ├── public/
│   ├── routes/
│   ├── database/
│   ├── .env.example
│   └── ...
└── ...
```

- **Dockerfile**: Imagen personalizada para Laravel (PHP-FPM, Node.js, Composer, Redis).
- **docker-compose.yml**: Orquestación de servicios (app, db, redis, nginx, pgadmin, elasticsearch).
- **nginx/conf.d/default.conf**: Configuración del servidor web.
- **src/**: Código fuente de la aplicación Laravel.

## Contribuciones

¡Las contribuciones son bienvenidas! Para contribuir:

1. Haz un fork del repositorio.
2. Crea una rama para tu funcionalidad:
    ```bash
    git checkout -b mi-nueva-funcionalidad
    ```
3. Realiza tus cambios y haz commit.
4. Envía un pull request.

## Licencia

Este proyecto está bajo la licencia [MIT](LICENSE).

---

> **¿Dudas o sugerencias?** Abre un issue o contacta con el autor del repositorio.
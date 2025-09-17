# Guía Detallada: Túneles Temporales de Cloudflare con Docker Compose

## 1. Objetivo

El objetivo de esta guía es documentar el procedimiento para exponer un servicio web, que se ejecuta dentro de un contenedor Docker, a internet. Esto se logrará mediante un túnel temporal de Cloudflare (`trycloudflare.com`), cuya configuración estará completamente contenida y automatizada dentro del archivo `docker-compose.yaml`.

Este método es ideal para demostraciones, pruebas y desarrollo, ya que no requiere configuración manual externa y se inicia junto con el proyecto.

## 2. Requisitos Previos

- **Docker y Docker Compose:** El sistema debe tener Docker y Docker Compose instalados y operativos.
- **Proyecto Docker Compose:** Debe existir un archivo `docker-compose.yaml` con al menos un servicio web que se desee exponer.
- **Cuenta de Cloudflare:** Se necesita una cuenta de Cloudflare. La primera vez que se ejecute un túnel, el sistema puede requerir una autenticación a través del navegador.

---

## 3. Procedimiento Paso a Paso

### **Paso 1: Identificar el Servicio de Destino y su Puerto Interno**

**Hito:** Conocer el nombre exacto del servicio de Docker y el puerto en el que la aplicación escucha *dentro* de su contenedor.

**Acciones:**
1.  **Analizar `docker-compose.yaml`:** Abre el archivo `docker-compose.yaml`.
2.  **Localizar el Nombre del Servicio:** Identifica el nombre clave del servicio que quieres exponer. Por ejemplo, en el siguiente fragmento, el nombre del servicio es `webapp`.

    ```yaml
    services:
      webapp: # <- ESTE ES EL NOMBRE DEL SERVICIO
        image: nginx:alpine
        # ...
    ```

3.  **Determinar el Puerto Interno:** Averigua en qué puerto se ejecuta la aplicación *dentro* del contenedor. Este dato suele estar en la documentación de la imagen Docker. Si el servicio tiene una sección `ports` como `"8080:80"`, el puerto interno es el de la derecha (`80`).

    **Ejemplo:**
    - Para una imagen `nginx`, el puerto interno es `80`.
    - Para una imagen `node` que expone una app, podría ser `3000`.
    - Para una imagen de Paperless-ngx, es `8000`.

### **Paso 2: Añadir el Servicio de Cloudflared al `docker-compose.yaml`**

**Hito:** El archivo `docker-compose.yaml` está modificado para incluir un nuevo servicio (`cloudflared-tunnel`) que creará el túnel de forma automática.

**Acciones:**
1.  **Copiar Plantilla:** Copia el siguiente bloque de código YAML. Esta es una plantilla genérica para el servicio de túnel.

    ```yaml
    # --- INICIO DE PLANTILLA DE TÚNEL CLOUDFLARE ---
    cloudflared-tunnel-mi-app: # <--- 1. Renombrar con un nombre único
      image: cloudflare/cloudflared:latest
      restart: unless-stopped
      depends_on:
        - webapp # <--- 2. Reemplazar con el nombre del servicio de destino
      command: tunnel --url http://webapp:80 # <--- 3. Reemplazar servicio y puerto
    # --- FIN DE PLANTILLA DE TÚNEL CLOUDFLARE ---
    ```

2.  **Pegar en `docker-compose.yaml`:** Pega el bloque en tu archivo `docker-compose.yaml`, al mismo nivel de indentación que los otros servicios.

3.  **Adaptar la Plantilla:**
    1.  **Renombrar el servicio:** Cambia `cloudflared-tunnel-mi-app` por un nombre descriptivo y único (ej. `cloudflared-tunnel-nextcloud`).
    2.  **Establecer dependencia:** En la sección `depends_on`, reemplaza `webapp` por el nombre del servicio que identificaste en el **Paso 1**. Esto asegura que tu aplicación se inicie antes que el túnel.
    3.  **Configurar el `command`:** Esta es la instrucción principal. Modifícala siguiendo el formato `tunnel --url http://<nombre-servicio>:<puerto-interno>`:
        - Reemplaza `<nombre-servicio>` por el nombre del servicio del **Paso 1**.
        - Reemplaza `<puerto-interno>` por el puerto interno del **Paso 1**.

### **Paso 3: Iniciar los Servicios y Obtener la URL del Túnel**

**Hito:** Todos los contenedores están en ejecución y se ha obtenido la URL pública temporal generada por Cloudflare.

**Acciones:**
1.  **Iniciar Docker Compose:** Desde una terminal en la raíz del proyecto, ejecuta:
    ```bash
    docker compose up -d
    ```
2.  **Consultar los Logs:** Para encontrar la URL pública, revisa los logs del contenedor del túnel que acabas de crear.
    ```bash
    # Reemplaza <nombre-del-servicio-cloudflared> por el nombre que le diste en el Paso 2
    docker compose logs <nombre-del-servicio-cloudflared>
    ```
3.  **Extraer la URL:** En los logs, busca una línea que contenga una URL que termine en `.trycloudflare.com`. Cópiala.

    ```
    ...
    INFO | CF-RAY: 823be8b5235a1234-EWR | https://some-random-name.trycloudflare.com
    ...
    ```

### **Paso 4: Configurar la Confianza en la Aplicación (CSRF/Trusted Domains)**

**Hito:** La aplicación de destino está configurada para aceptar peticiones HTTP que provengan de la URL de Cloudflare, evitando errores de seguridad (como CSRF o Host Header inválido).

**Acciones:**
1.  **Identificar el Método de Configuración:** Determina cómo se configuran las variables de entorno en tu aplicación. Generalmente es a través de la sección `environment` en el `docker-compose.yaml`.
2.  **Localizar la Variable Correcta:** Busca en la documentación de tu aplicación o en su configuración existente el nombre de la variable que gestiona los dominios de confianza. Nombres comunes son:
    - `PAPERLESS_CSRF_TRUSTED_ORIGINS`
    - `NEXTCLOUD_TRUSTED_DOMAINS` (este se configura en un archivo `config.php`, no como variable de entorno)
    - `CSRF_TRUSTED_ORIGINS`
    - `ALLOWED_HOSTS`
    - `CORS_ALLOWED_ORIGINS`
    - `APP_URL`
3.  **Actualizar la Configuración:** Asigna la URL completa que obtuviste en el **Paso 3** a esta variable.

    **Ejemplo en `docker-compose.yaml`:**
    ```yaml
    services:
      mi-aplicacion:
        image: alguna-imagen/mi-app
        environment:
          # Reemplaza con la URL obtenida en el Paso 3
          CSRF_TRUSTED_ORIGINS: https://some-random-name.trycloudflare.com
    ```
4.  **Aplicar Cambios:** Si realizaste cambios en el `docker-compose.yaml`, reinicia los servicios para que surtan efecto.
    ```bash
    docker compose up -d --force-recreate
    ```

### **Paso 5: Verificación Final**

**Hito:** El servicio es accesible públicamente a través de la URL de Cloudflare y funciona correctamente.

**Acciones:**
1.  **Abrir Navegador:** Abre un navegador web.
2.  **Navegar a la URL:** Pega la URL `https://...trycloudflare.com` que obtuviste.
3.  **Confirmar:** La aplicación web debería cargarse sin errores.

---

## 4. Ejemplo Completo

**Situación:** Exponer un servicio llamado `grafana` que corre en el puerto interno `3000`.

**`docker-compose.yaml` ANTES:**
```yaml
services:
  grafana:
    image: grafana/grafana:latest
    ports:
      - "3000:3000"
```

**`docker-compose.yaml` DESPUÉS:**
```yaml
services:
  grafana:
    image: grafana/grafana:latest
    ports:
      - "3000:3000"
    environment:
      # Se añade la URL que se verá en los logs del túnel
      GF_SERVER_ROOT_URL: https://unique-name-for-grafana.trycloudflare.com

  cloudflared-tunnel-grafana:
    image: cloudflare/cloudflared:latest
    restart: unless-stopped
    depends_on:
      - grafana
    command: tunnel --url http://grafana:3000
```

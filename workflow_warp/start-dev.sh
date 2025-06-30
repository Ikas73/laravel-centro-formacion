#!/bin/bash

# --- Script para iniciar el entorno de desarrollo Laravel con Docker DENTRO de WSL ---

# Definimos códigos de color para los mensajes
GREEN="\033[0;32m"
RED="\033[0;31m"
YELLOW="\033[0;33m"
BLUE="\033[0;34m"
CYAN="\033[0;36m"
NC="\033[0m" # Sin color

# 1. Verificar que estamos en la raíz del proyecto (buscando docker-compose.yml)
if [ ! -f "docker-compose.yml" ] && [ ! -f "docker-compose.yaml" ]; then
    echo -e "${RED}❌ No se encontró docker-compose.yml o docker-compose.yaml${NC}"
    echo -e "${YELLOW}Asegúrate de ejecutar este script desde la raíz de tu proyecto.${NC}"
    exit 1
fi

# 2. Verificar que existe 'artisan' en la raíz (lógica simplificada para la nueva estructura)
if [ ! -f "artisan" ]; then
    echo -e "${RED}❌ No se encontró el archivo 'artisan'.${NC}"
    echo -e "${YELLOW}Este no parece ser un proyecto Laravel válido.${NC}"
    exit 1
fi

echo -e "${GREEN}🚀 Iniciando entorno de desarrollo Laravel...${NC}"
echo -e "${CYAN}📍 Ubicación: $(pwd)${NC}"

# 3. Levantar los contenedores
echo -e "${BLUE}🐳 Levantando contenedores con 'docker-compose up -d'...${NC}"
docker-compose up -d

# Esperar un poco a que los servicios se estabilicen
sleep 5

# 4. Iniciar el servidor Laravel en segundo plano (con -T)
echo -e "${BLUE}🌐 Iniciando servidor Laravel (puerto 8000)...${NC}"
docker-compose exec -T app php artisan serve --host=0.0.0.0 --port=8000 &

# Esperar un momento
sleep 2

# 5. Iniciar el dev server de npm en segundo plano (con -T)
echo -e "${CYAN}⚡ Iniciando npm dev server...${NC}"
docker-compose exec -T app npm run dev &

# Mostrar información de los trabajos iniciados
sleep 3
echo -e "\n${GREEN}📊 Trabajos en ejecución:${NC}"
jobs -l

echo -e "\n${GREEN}✅ Entorno iniciado:${NC}"
echo -e "   ${CYAN}🌐 Laravel: http://localhost:8000${NC}"
echo -e "   ${CYAN}⚡ Vite Dev Server iniciado${NC}"
echo -e "\n${YELLOW}💡 Para detener los servicios:${NC}"
echo -e "   ${NC}Para traer un proceso al primer plano: 'fg %1' (para el trabajo 1)"
echo -e "   ${NC}Para detener un proceso en segundo plano: 'kill %1' (para el trabajo 1)"
echo -e "   ${NC}Para detener todos los contenedores: 'docker-compose down'"
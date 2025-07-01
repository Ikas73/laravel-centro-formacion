#!/bin/bash

# --- Script para iniciar el entorno de desarrollo Laravel con Docker DENTRO de WSL ---

# Definimos códigos de color para los mensajes
GREEN="\033[0;32m"
RED="\033[0;31m"
YELLOW="\033[0;33m"
BLUE="\033[0;34m"
CYAN="\033[0;36m"
NC="\033[0m" # Sin color

# Función para limpiar procesos al salir
cleanup() {
    echo -e "\n${YELLOW}🧹 Limpiando procesos...${NC}"
    if [ ! -z "$LARAVEL_PID" ]; then
        kill $LARAVEL_PID 2>/dev/null
    fi
    if [ ! -z "$VITE_PID" ]; then
        kill $VITE_PID 2>/dev/null
    fi
    echo -e "${GREEN}✅ Limpieza completada${NC}"
}

# Registrar función de limpieza para cuando se termine el script
trap cleanup EXIT

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

# 3.1. Verificar si hay problemas con las dependencias de npm
echo -e "${YELLOW}🔍 Verificando estado de las dependencias de npm...${NC}"
npm_test_result=$(docker-compose exec -T app npm run dev --dry-run 2>&1 || echo "error")

if echo "$npm_test_result" | grep -q "Cannot find module.*rollup"; then
    echo -e "${YELLOW}⚠️  Detectado problema con dependencias de rollup. Reinstalando...${NC}"
    docker-compose exec -T app rm -rf package-lock.json node_modules
    docker-compose exec -T app npm install
    echo -e "${GREEN}✅ Dependencias reinstaladas${NC}"
fi

# 4. Iniciar el servidor Laravel usando nohup
echo -e "${BLUE}🌐 Iniciando servidor Laravel (puerto 8000)...${NC}"
nohup docker-compose exec -T app php artisan serve --host=0.0.0.0 --port=8000 > laravel.log 2>&1 &
LARAVEL_PID=$!

# Esperar un momento
sleep 3

# 5. Iniciar el dev server de npm usando nohup
echo -e "${CYAN}⚡ Iniciando npm dev server...${NC}"
nohup docker-compose exec -T app npm run dev > vite.log 2>&1 &
VITE_PID=$!

# Esperar un poco para que los servicios se inicialicen
sleep 5

# Verificar que los procesos estén funcionando
echo -e "${BLUE}📊 Verificando servicios...${NC}"

# Verificar Laravel
if kill -0 $LARAVEL_PID 2>/dev/null; then
    echo -e "${GREEN}✅ Servidor Laravel: Funcionando (PID: $LARAVEL_PID)${NC}"
else
    echo -e "${RED}❌ Servidor Laravel: Error al iniciar${NC}"
    echo -e "${YELLOW}Ver log: tail -f laravel.log${NC}"
fi

# Verificar Vite
if kill -0 $VITE_PID 2>/dev/null; then
    echo -e "${GREEN}✅ Vite Dev Server: Funcionando (PID: $VITE_PID)${NC}"
else
    echo -e "${RED}❌ Vite Dev Server: Error al iniciar${NC}"
    echo -e "${YELLOW}Ver log: tail -f vite.log${NC}"
fi

echo -e "\n${GREEN}✅ Entorno iniciado:${NC}"
echo -e "   ${CYAN}🌐 Laravel: http://localhost:8000${NC}"
echo -e "   ${CYAN}⚡ Vite Dev Server ejecutándose${NC}"
echo -e "\n${YELLOW}📋 Comandos útiles:${NC}"
echo -e "   ${NC}Ver logs de Laravel: tail -f laravel.log"
echo -e "   ${NC}Ver logs de Vite: tail -f vite.log"
echo -e "   ${NC}Detener servicios: docker-compose down"
echo -e "   ${NC}Reiniciar dependencias npm: docker-compose exec app npm install"

echo -e "\n${BLUE}💡 Los servicios seguirán ejecutándose en segundo plano.${NC}"
echo -e "${BLUE}   Presiona Ctrl+C para detener este script (los servicios continuarán).${NC}"

# Mantener el script corriendo para mostrar logs en tiempo real si se desea
read -p $'\n'"${CYAN}¿Quieres ver los logs en tiempo real? (y/n): ${NC}" -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo -e "${BLUE}📊 Mostrando logs en tiempo real (Ctrl+C para salir)...${NC}"
    tail -f laravel.log vite.log
fi

#!/bin/bash

# --- Script para entrar en un directorio específico DENTRO de WSL ---

# Definimos códigos de color para los mensajes (opcional pero mejora la legibilidad)
GREEN="\033[0;32m"
RED="\033[0;31m"
CYAN="\033[0;36m"
NC="\033[0m" # Sin color

# 1. Definimos la ruta del proyecto en formato Linux
projectPath="/home/user1234/proyectos/proyecto-laravel"

# 2. Comprobamos si el directorio existe
#    El comando '[ -d "ruta" ]' es el equivalente de 'Test-Path' para directorios en Linux.
if [ -d "$projectPath" ]; then
    # Si existe, entramos en él.
    # El comando 'cd' es el equivalente de 'Set-Location'.
    cd "$projectPath"
    
    # Mostramos el mensaje de éxito. 'echo -e' permite interpretar los colores.
    echo -e "${GREEN}✓ ¡Éxito! Se ha entrado en el directorio del proyecto.${NC}"
    
    # 'pwd' es el equivalente de 'Get-Location' para mostrar la ruta actual.
    echo -e "${CYAN}📁 Ubicación actual: $(pwd)${NC}"
    
else
    # Si no existe, mostramos un mensaje de error claro.
    echo -e "${RED}❌ Error: El directorio '$projectPath' no se ha encontrado.${NC}"
    echo "   Por favor, verifica que la ruta es correcta."
    # Salimos con un código de error para que otros scripts sepan que algo falló.
    exit 1
fi
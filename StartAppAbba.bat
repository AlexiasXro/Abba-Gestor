@echo off
setlocal

echo ===============================
echo Iniciando AppAbba (modo portable)
echo ===============================

REM ===== Cambiar a la carpeta del proyecto =====
REM Asegurate de poner este .bat dentro de la carpeta Abba-app
cd /d "%~dp0"

REM ===== Preguntar ruta de PHP si no se encuentra php.exe en PATH =====
where php >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    set /p PHP_PATH=Ingresa la ruta completa de php.exe (ej: C:\xampp\php\php.exe):
) else (
    set PHP_PATH=php
)

REM ===== Iniciar servidor Laravel =====
start "" "%PHP_PATH%" artisan serve

REM ===== Esperar 5 segundos para que el servidor arranque =====
timeout /t 5

REM ===== Abrir Edge como app web apuntando al proyecto =====
start "" "C:\Program Files (x86)\Microsoft\Edge\Application\msedge_proxy.exe" --profile-directory="Profile 1" --app-id=bjbfehkajmjimkpiipaoiakadkmjcgol --app-url=http://127.0.0.1:8000/login --app-launch-source=4

echo =====================================
echo AppAbba iniciado!
echo Cierra esta ventana solo si quieres.
echo =====================================
pause

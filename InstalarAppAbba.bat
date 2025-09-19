@echo off
setlocal

echo ===============================
echo Bienvenido a la instalacion de AppAbba
echo ===============================

REM ===== Pedir ruta de PHP =====
set /p PHP_PATH=Ingresa la ruta completa de php.exe (ej: C:\xampp\php\php.exe): 

REM ===== Pedir ruta del proyecto =====
set /p PROJECT_PATH=Ingresa la ruta completa de la carpeta Abba-app: 

REM ===== Descargar NSSM =====
echo Descargando NSSM...
set NSSM_ZIP=%TEMP%\nssm.zip
set NSSM_DIR=%TEMP%\nssm

powershell -Command "Invoke-WebRequest -Uri https://nssm.cc/release/nssm-2.24.zip -OutFile '%NSSM_ZIP%'"
powershell -Command "Expand-Archive -Path '%NSSM_ZIP%' -DestinationPath '%NSSM_DIR%'"

REM ===== Crear servicio con NSSM =====
echo Creando servicio AppAbba...

"%NSSM_DIR%\nssm-2.24\win64\nssm.exe" install AppAbba "%PHP_PATH%" "artisan serve" "%PROJECT_PATH%"

REM ===== Configurar arranque automatico =====
"%NSSM_DIR%\nssm-2.24\win64\nssm.exe" set AppAbba Start SERVICE_AUTO_START

REM ===== Iniciar el servicio =====
"%NSSM_DIR%\nssm-2.24\win64\nssm.exe" start AppAbba

REM ===== Crear acceso directo a Edge =====
echo Creando acceso directo a AppAbba en el escritorio...

set SHORTCUT="%USERPROFILE%\Desktop\AppAbba.lnk"
powershell -Command "$WshShell = New-Object -ComObject WScript.Shell; $Shortcut = $WshShell.CreateShortcut('%SHORTCUT%'); $Shortcut.TargetPath = 'C:\Program Files (x86)\Microsoft\Edge\Application\msedge_proxy.exe'; $Shortcut.Arguments = '--profile-directory=\"Profile 1\" --app-id=bjbfehkajmjimkpiipaoiakadkmjcgol --app-url=http://127.0.0.1:8000/login --app-launch-source=4'; $Shortcut.Save()"

echo =====================================
echo Instalacion completa!
echo Ahora AppAbba arrancara automaticamente con Windows.
echo Acceso directo creado en el escritorio.
echo =====================================

pause

@echo off
:: Guardar la carpeta donde está este .bat
set "PROJECT_DIR=%~dp0"
cd /d "%PROJECT_DIR%"

:: Inicia el servidor Laravel en una nueva ventana
start "" cmd /k "php artisan serve"

:: Espera a que el servidor levante
timeout /t 5 >nul

:: Abre la app en el navegador
start "" http://127.0.0.1:8000/login

:: Cierra la ventana original del .bat
exit

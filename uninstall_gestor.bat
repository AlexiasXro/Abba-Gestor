@echo off
title Desinstalador Gestor ABBA
setlocal enabledelayedexpansion

:: -----------------------------
:: CONFIGURACION
:: -----------------------------
set SERVICE_NAME=abba-laravel
set XAMPP_DIR=C:\xampp

echo 🔍 Desinstalando Gestor ABBA...

:: -----------------------------
:: ELIMINAR SERVICIO NSSM
:: -----------------------------
where nssm >nul 2>nul
if %ERRORLEVEL%==0 (
    echo ⚙️ Deteniendo servicio %SERVICE_NAME%...
    nssm stop %SERVICE_NAME%
    echo ⚙️ Eliminando servicio %SERVICE_NAME%...
    nssm remove %SERVICE_NAME% confirm
) else (
    echo ❌ NSSM no encontrado. El servicio no pudo eliminarse automaticamente.
)

:: -----------------------------
:: PREGUNTAR POR XAMPP
:: -----------------------------
echo.
set /p DELETE_XAMPP="¿Desea desinstalar XAMPP tambien? (s/n): "
if /i "!DELETE_XAMPP!"=="s" (
    if exist "%XAMPP_DIR%\uninstall.exe" (
        echo 🚀 Ejecutando desinstalador de XAMPP...
        "%XAMPP_DIR%\uninstall.exe" --mode unattended
        echo ✅ XAMPP desinstalado.
    ) else (
        echo ⚠️ No se encontro desinstalador de XAMPP en %XAMPP_DIR%
    )
)

echo.
echo ✅ Proceso de desinstalacion finalizado.
pause

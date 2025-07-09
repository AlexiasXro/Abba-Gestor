instalar PHP PHP 8.4.8
    C:\Program Files\PHP
    https://windows.php.net/download#php-8.4
    https://www.apachefriends.org/es/download.html

      *Habilitar permisos de cambio al usuaro comun[name del equipo] 
      Cambios en PHP.ini->extension=fileinfo
                    extension=pdo_sqlite
                    extension=sqlite3
                    extension=zip


    instalar composer 
    Uso del instalador#
    https://getcomposer.org/doc/00-intro.md#installation-windows

    instalar zip
    https://www.7-zip.org/
    Asegurate de agregar su ruta a las variables de entorno (ej.: C:\Program Files\7-Zip)

    manejo de tikec impreso?
    composer require barryvdh/laravel-dompdf

_________________________________________________________________

# 🚀 GUÍA DE INSTALACIÓN PARA NUEVA PC – Proyecto Laravel (Modo `php artisan serve`)

## 📦 Requisitos previos (instalaciones necesarias)

En la nueva PC, asegurate de tener:

- **PHP 8.1 o superior**  
  ➤ https://www.php.net/downloads.php

- **Composer**  
  ➤ https://getcomposer.org/download/

- **XAMPP** (opcional)  
  ✔ No es necesario para tu caso actual, ya que usás `php artisan serve`.

## 🛠️ Instalación paso a paso

### 1. Copiar el proyecto Laravel

Copiá toda la carpeta del proyecto a la nueva PC.  
📁 Ruta recomendada: `C:\Proyectos\abba`

Asegurate de incluir:

- La carpeta `database/` con el archivo `bdAbba.sqlite`
- El archivo `.env` si lo tenés, o usar `.env.example`

### 2. Instalar las dependencias

Abrí la terminal (CMD o PowerShell) y ejecutá:

```bash
cd C:\Proyectos\abba
composer install
```

### 3. Configurar el archivo `.env`

Si no tenés `.env`, copiá el de ejemplo:

```bash
cp .env.example .env
```

Editá el archivo `.env` y asegurate que tenga:

```dotenv
DB_CONNECTION=sqlite
DB_DATABASE=database/bdAbba.sqlite
```

### 4. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 5. Crear base de datos (si no existe el archivo)

Si no tenés el archivo `bdAbba.sqlite`, podés crearlo con:

```bash
mkdir database
type nul > database/bdAbba.sqlite
```

O manualmente: creá un archivo vacío llamado `bdAbba.sqlite` dentro de la carpeta `database/`.

### 6. Ejecutar migraciones y seeders (solo si querés empezar desde cero)

```bash
php artisan migrate --seed
```

### 7. Levantar el servidor local

```bash
php artisan serve
```

📡 Luego, abrí el navegador y visitá:

[http://127.0.0.1:8000](http://127.0.0.1:8000)

✅ ¡Listo! El proyecto debería estar funcionando en la nueva PC.

---

## (Opcional) Crear acceso directo para iniciar el sistema

Abrí el Bloc de Notas y pegá esto:

```bat
@echo off
cd C:\Proyectos\abba
php artisan serve
pause
```

Guardalo como `iniciar_abba.bat` (en tipo de archivo elegí “Todos los archivos”).

Hacé doble clic sobre ese archivo para iniciar el sistema fácilmente.


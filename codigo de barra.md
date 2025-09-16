# 📌 Instalación y uso de milon/barcode en Laravel

## 🛠️ Instalación de la librería
Desde la terminal del proyecto Laravel:

```bash
composer require milon/barcode
```

⚠️ Si aparece un error de `ext-gd`, significa que la extensión **GD** de PHP no está habilitada.

---

## ⚙️ Habilitar extensión GD en PHP
1. Abrir el archivo `php.ini` (en XAMPP, Laragon o la instalación de PHP).
2. Buscar la línea:

```ini
;extension=gd
```

3. Quitar el `;` para habilitarla:

```ini
extension=gd
```

4. Guardar el archivo y **reiniciar Apache/servidor**.
5. Verificar en la terminal:

```bash
php -m | findstr gd
```

Si aparece `gd`, está activa ✅.

---

## 🧩 Uso en el proyecto
La librería se usará para:

- Generar códigos de barras en **vistas Blade**.  
- Imprimir **etiquetas compatibles con lectores físicos USB**.  
- Mostrar el código junto a un **QR** (doble compatibilidad).  

---

## 🖼️ Ejemplo en Blade
En `resources/views/qr_impr.blade.php`:

```blade
{!! DNS1D::getBarcodeHTML($producto->codigo, 'C128', 1.5, 40) !!}
```

🔹 Genera un **código de barras tipo Code 128**, estándar compatible con la mayoría de escáneres.

---

## ✅ Resumen
- Librería instalada: `milon/barcode`
- Extensión necesaria: **GD**
- Uso: códigos de barras `Code 128` en vistas e impresión.

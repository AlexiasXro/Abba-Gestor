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

_________________________________________________________________

# Diagrama de Clases - Sistema de Ventas y Stock

## 🟩 Producto
- id: int
- codigo: string (único)
- nombre: string
- descripcion: text (nullable)
- precio: decimal(10,2)
- stock_minimo: int (default: 3)
- activo: boolean (default: true)
- timestamps

🔗 Relaciones:
- Muchos a muchos con **Talle** (producto_talle)
- Uno a muchos con **VentasDetalle**

---

## 🟦 Talle
- id: int
- talle: string
- timestamps

🔗 Relaciones:
- Muchos a muchos con **Producto** (producto_talle)
- Uno a muchos con **VentasDetalle**

---

## 🟨 ProductoTalle (Pivot)
- id: int
- producto_id: FK -> Producto
- talle_id: FK -> Talle
- stock: int (default: 0)
- timestamps

---

## 🧑 Cliente
- id: int
- nombre: string
- apellido: string
- telefono: string (nullable)
- email: string (nullable)
- direccion: string (nullable)
- timestamps

🔗 Relaciones:
- Uno a muchos con **Venta**

---

## 🧾 Venta
- id: int
- cliente_id: FK -> Cliente (nullable)
- fecha_venta: datetime
- subtotal: decimal(10,2)
- descuento: decimal(10,2)
- total: decimal(10,2)
- metodo_pago: string
- notas: text (nullable)
- timestamps

🔗 Relaciones:
- Uno a muchos con **VentasDetalle**

---

## 📄 VentasDetalle
- id: int
- venta_id: FK -> Venta
- producto_id: FK -> Producto
- talle_id: FK -> Talle
- cantidad: int
- precio_unitario: decimal(10,2)
- descuento: decimal(10,2)
- subtotal: decimal(10,2)
- timestamps

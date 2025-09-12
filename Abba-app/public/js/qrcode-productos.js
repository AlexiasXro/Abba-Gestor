
//Generar códigos QR -> qrcode-productos.js 
// productos/index.blade.php
// productos/show.blade.php
// layouts/app.blade.php

//solo toma lo q laravel le pasa

document.addEventListener("DOMContentLoaded", () => {
    const productos = window.productosQR || [];

    productos.forEach(p => {
        try {
            const qrContainer = document.getElementById(p.containerId || `qrcode-${p.codigo}`);
            if (!qrContainer) return;
            new QRCode(qrContainer, {
                text: p.url,
                width: 60,
                height: 60,
                colorDark: "#000",
                colorLight: "#fff",
                correctLevel: QRCode.CorrectLevel.H
            });
        } catch (e) {
            console.error('Error generando QR para', p.codigo, e);
        }
    });
});





<?php

// 1. Establece el encabezado Content-Type.
// Esto le dice al navegador que la respuesta es una imagen PNG.
header("Content-Type: image/png");

// 2. Hace una solicitud a la API de QR externa.
// Los parámetros 'data' y 'size' están codificados directamente en la URL.
$apiUrl = 'https://api.qrserver.com/v1/create-qr-code/?data=Test&size=150x150';

// 3. Obtiene el contenido de la respuesta de la API externa.
$imageData = file_get_contents($apiUrl);

// 4. Imprime el contenido binario de la imagen.
// Este es el contenido puro de la imagen PNG.
echo $imageData;

?>
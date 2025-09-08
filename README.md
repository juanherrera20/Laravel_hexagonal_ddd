
## Instrucciones Generales

1. Clona este repositorio en tu máquina local:
```bash
git clone https://github.com/tu-repositorio/examen-laravel.git
cd examen-laravel
```
2. Instala las dependencias necesarias:
```bash
composer install
npm install
```
3. Configura tu archivo .env con las credenciales de tu base de datos.
4. Ejecuta las migraciones y los seeders:
```bash
php artisan migrate:fresh --seed
```

## Contenido del Repositorio

Este repositorio contiene tres casos proyectos:

1. **Caso 1** : Implementación básica de un CRUD sin autenticación.
2. **Caso 2** : Implementación de un CRUD con autenticación usando Sanctum, paginación, filtrado y ordenamiento.
3. **Caso 3** : Implementación de un CRUD aplicando la Arquitectura Hexagonal.

Cada caso tiene su propia rama (_caso-1_, _caso-2_, _caso-3_) con un README detallado que describe los requisitos y las historias de usuario correspondientes.

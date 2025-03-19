# Caso 1: CRUD Básico

## Descripción

En este caso, deberás implementar un CRUD básico para una o más entidades sin autenticación. El objetivo es evaluar tu capacidad para trabajar con las operaciones básicas de Laravel (Create, Read, Update, Delete) siguiendo la arquitectura MVC.

## Historias de Usuario

1. **HU-01** : Como usuario, quiero poder crear registros para una entidad principal (Libro) y asignarlos a una entidad relacionada (Autor).
2. **HU-02** : Como usuario, quiero poder listar todos los libros junto con su autor correspondiente.
3. **HU-03** : Como usuario, quiero poder ver los detalles de un libro específico, incluyendo su autor.
4. **HU-04** : Como usuario, quiero poder actualizar un libro existente, incluyendo su relación con el autor.
5. **HU-05** : Como usuario, quiero poder eliminar un libro.

## Especificaciones

- Entidades sugeridas: Libro (principal) y Autor (relacionada).
- Usa el patrón MVC para organizar tu código.
- Implementa una relación de uno a muchos (1:N) : Un autor puede tener muchos libros, pero un libro pertenece a un solo autor.
- No es necesario implementar autenticación.
- Incluye validaciones básicas en los formularios.
- Asegúrate de mostrar correctamente las relaciones en las vistas.
- Implementar manejo de errores predeterminados, para errores no tan comunes usar status 500.
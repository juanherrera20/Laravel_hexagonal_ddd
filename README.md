# Caso 1: CRUD Básico

## Historias de Usuario

1. **HU-01** : Como usuario, quiero poder crear registros para una entidad principal (Libro) y asignarlos a una entidad relacionada (Autor).
2. **HU-02** : Como usuario, quiero poder listar todos los libros junto con su autor correspondiente.
3. **HU-03** : Como usuario, quiero poder ver los detalles de un libro específico, incluyendo su autor.
4. **HU-04** : Como usuario, quiero poder actualizar un libro existente, incluyendo su relación con el autor.
5. **HU-05** : Como usuario, quiero poder eliminar un libro.

## Especificaciones

- Entidades Creadas: Libro (principal) y Autor (relacionada).
- Patrón MVC para organizar tu código.
- Implementa una relación de uno a muchos (1:N) : Un autor puede tener muchos libros, pero un libro pertenece a un solo autor.
- Incluye validaciones básicas en los formularios.
- Implementa manejo de errores predeterminados, para errores no tan comunes se usa status 500.

# Caso 2: CRUD con Autenticación

## Descripción

En este caso, deberás implementar un CRUD para una entidad con autenticación basada en Sanctum. Además, deberás incluir paginación, filtrado y ordenamiento en las consultas.

## Historias de Usuario

1. **HU-01** : Como usuario nuevo, quiero tener la posibilidad de registrarme en la aplicación.
2. **HU-02** : Como usuario registrado, quiero tener la posibilidad de autenticarme en la aplicación.
3. **HU-03** : Como usuario autenticado, quiero poder crear registros.
4. **HU-04** : Como usuario autenticado, quiero poder listar registros con paginación.
5. **HU-05** : Como usuario autenticado, quiero poder filtrar registros por usuario que lo creó.
5. **HU-06** : Como usuario autenticado, quiero poder filtrar por registros creados por mí.
6. **HU-07** : Como usuario autenticado, quiero poder ordenar registros por fecha de creación.
7. **HU-08** : Como usuario autenticado, quiero poder actualizar y eliminar registros.

## Especificaciones

- Entidad sugerida: Post.
- Implementa autenticación con Sanctum.
- Usa paginación para listar registros.
- Añade endpoints para filtrar y ordenar.
# Caso 2: CRUD con Autenticación

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

- Entidades creadas: Post y User.
- Se implementa autenticación con Sanctum.
- Se implementa paginación para listar registros.
- Contiene endpoints para filtrar y ordenar.

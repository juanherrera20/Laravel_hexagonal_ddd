# Comandos Personalizados de la Aplicación

## make:ddd
Crea la estructura básica de la arquitectura hexagonal para una entidad de un contexto específico.

### Uso
```bash
php artisan make:ddd {context} {entity}
```

### Parámetros
- `context`: El contexto delimitado (bounded context), por ejemplo: admin, lms, job_request
- `entity`: La entidad para la cual crear la estructura DDD, por ejemplo: books

### Ejemplo
```bash
php artisan make:ddd admin books
```

### Resultado
Crea la siguiente estructura de directorios en `src/admin/books`:
```
├── domain/
│   ├── entities/
│   ├── value_objects/
│   └── contracts/
├── application/
└── infrastructure/
    ├── controllers/
    ├── routes/
    ├── validators/
    ├── repositories/
    ├── listeners/
    └── events/
```
También crea un controlador básico y configura las rutas automáticamente.

## make:entityddd
Crea una entidad en la capa de dominio para un contexto específico.

### Uso
```bash
php artisan make:entityddd {context} {entity}
```

### Parámetros
- `context`: El contexto al que pertenece la entidad
- `entity`: El nombre de la entidad a crear

### Ejemplo
```bash
php artisan make:entityddd admin book
```

### Resultado
Crea un archivo de entidad en `src/admin/book/domain/entities/Book.php`

## make:repositoryddd
Crea un repositorio que implementará los contratos definidos en la capa de dominio.

### Uso
```bash
php artisan make:repositoryddd {context} {entity}
```

### Parámetros
- `context`: El contexto al que pertenece el repositorio
- `entity`: La entidad para la cual crear el repositorio

### Ejemplo
```bash
php artisan make:repositoryddd admin book
```

### Resultado
Crea un archivo de repositorio en `src/admin/book/infrastructure/repositories/EloquentBookRepository.php`

## make:ucddd
Crea un caso de uso para manejar la lógica de negocio.

### Uso
```bash
php artisan make:ucddd {context} {entity} {usecase}
```

### Parámetros
- `context`: El contexto al que pertenece el caso de uso
- `entity`: La entidad relacionada con el caso de uso
- `usecase`: El nombre del caso de uso a crear

### Ejemplo
```bash
php artisan make:ucddd admin book create
```

### Resultado
Crea un archivo de caso de uso en `src/admin/book/application/CreateUseCase.php`

## make:validatorddd
Crea un validador personalizado para las solicitudes HTTP.

### Uso
```bash
php artisan make:validatorddd {context} {entity} {validator}
```

### Parámetros
- `context`: El contexto al que pertenece el validador
- `entity`: La entidad relacionada con el validador
- `validator`: El nombre del validador a crear

### Ejemplo
```bash
php artisan make:validatorddd admin book store
```

### Resultado
Crea un archivo de form request en `src/admin/book/infrastructure/validators/StoreRequest.php`

## make:contractddd
Crea la interfaz de los contratos que define las funcionalidades que se implementarán en el repositorio.

### Uso
```bash
php artisan make:contractddd {context} {entity}
```

### Parámetros
- `context`: El contexto al que pertenece el contrato
- `entity`: La entidad para la cual crear el contrato

### Ejemplo
```bash
php artisan make:contractddd admin book
```

### Resultado
Crea un archivo de contrato en `src/admin/book/domain/contracts/BookRepositoryContract.php`

## make:voddd
Crea un objeto de valor (Value Object) para una entidad específica.

### Uso
```bash
php artisan make:voddd {context} {entity} {atributte} {type}
```

### Parámetros
- `context`: El contexto al que pertenece el objeto de valor
- `entity`: La entidad relacionada con el objeto de valor
- `atributte`: El nombre del atributo que representa el objeto de valor
- `type`: El tipo de dato del objeto de valor (string, int, float, etc.)

### Ejemplo
```bash
php artisan make:voddd admin book title string
```

### Resultado
Crea un archivo de objeto de valor en `src/admin/book/domain/valueObjects/BookTitle.php` con la estructura básica y tipado fuerte.
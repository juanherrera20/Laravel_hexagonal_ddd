<h1>Listado de Libros</h1>

@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<a href="{{ url('/books/create') }}">➕ Crear nuevo libro</a>

<ul>
    @foreach ($books as $book)
        <li>
            <strong>{{ $book->title }}</strong> — {{ $book->author->name }}
            <a href="{{ url('/books/' . $book->id) }}">👁 Ver</a>
            <a href="{{ url('/books/' . $book->id . '/edit') }}">✏️ Editar</a>
            <form action="{{ url('/books/' . $book->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">🗑 Eliminar</button>
            </form>
        </li>
    @endforeach
</ul>

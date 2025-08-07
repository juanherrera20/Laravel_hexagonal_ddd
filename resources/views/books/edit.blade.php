<h1>Editar libro</h1>

@if ($errors->any())
    <ul style="color: red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ url('/books/' . $book->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Título:</label>
    <input type="text" name="title" value="{{ $book->title }}"><br>

    <label>Descripción:</label>
    <textarea name="description">{{ $book->description }}</textarea><br>

    <label>Precio:</label>
    <input type="number" step="0.01" name="price" value="{{ $book->price }}"><br>

    <label>Autor:</label>
    <select name="author_id">
        @foreach ($authors as $author)
            <option value="{{ $author->id }}" @if ($book->author_id == $author->id) selected @endif>
                {{ $author->name }}
            </option>
        @endforeach
    </select><br>

    <button type="submit">Actualizar</button>
</form>

<a href="{{ url('/books') }}">⬅ Volver</a>

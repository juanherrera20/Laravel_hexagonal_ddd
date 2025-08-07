<h1>Crear nuevo libro</h1>

@if ($errors->any())
    <ul style="color: red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ url('/books') }}" method="POST">
    @csrf
    <label>Título:</label>
    <input type="text" name="title"><br>

    <label>Descripción:</label>
    <textarea name="description"></textarea><br>

    <label>Precio:</label>
    <input type="number" step="0.01" name="price"><br>

    <label>Autor:</label>
    <select name="author_id">
        @foreach ($authors as $author)
            <option value="{{ $author->id }}">{{ $author->name }}</option>
        @endforeach
    </select><br>

    <button type="submit">Guardar</button>
</form>

<a href="{{ url('/books') }}">⬅ Volver</a>

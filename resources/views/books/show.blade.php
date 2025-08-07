<h1>Detalle del Libro</h1>

<p><strong>Título:</strong> {{ $book->title }}</p>
<p><strong>Descripción:</strong> {{ $book->description }}</p>
<p><strong>Precio:</strong> ${{ $book->price }}</p>
<p><strong>Autor:</strong> {{ $book->author->name }}</p>

<a href="{{ url('/books') }}">⬅ Volver</a>

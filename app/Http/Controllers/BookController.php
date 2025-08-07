<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('author')->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        return view('books.create', compact('authors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'author_id' => 'required|exists:authors,id'
        ]);

        Book::create($request->all());

        return redirect('/books')->with('success', 'Libro creado exitosamente.');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        return view('books.edit', compact('book', 'authors'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'author_id' => 'required|exists:authors,id'
        ]);

        $book->update($request->all());

        return redirect('/books')->with('success', 'Libro actualizado exitosamente.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/books')->with('success', 'Libro eliminado.');
    }
}

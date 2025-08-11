<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;


class PostController extends Controller
{
    private $postsValidator = [
        'title' => 'required',
        'content' => 'required',
    ];

    // List Posts and filtering
    public function index(Request $request)
    {
        $query = Post::with('user');

        // Filtrar por usuario específico
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filtrar por registros creados por mí
        if ($request->boolean('mine')) {
            $query->where('user_id', $request->user()->id);
        }

        // Ordenar por fecha
        if ($request->filled('order')) {
            $query->orderBy('created_at', $request->order === 'asc' ? 'asc' : 'desc');
        }

        // Paginación
        $posts = $query->paginate(10);

        return response()->json($posts);

        // $posts = Post::with('user')->paginate(10);
        // return response()->json(compact('posts'));
    }


    public function store(Request $request)
    {
        
        Post::create($request->all());

        return redirect('/books')->with('success', 'Libro creado exitosamente.');
    }

    // public function show(Book $book)
    // {
    //     return view('books.show', compact('book'));
    // }

    // public function edit(Book $book)
    // {
    //     $authors = Author::all();
    //     return view('books.edit', compact('book', 'authors'));
    // }

    // public function update(Request $request, Book $book)
    // {
    //     $request->validate([
    //         'title' => 'required',
    //         'description' => 'nullable',
    //         'price' => 'required|numeric',
    //         'author_id' => 'required|exists:authors,id'
    //     ]);

    //     $book->update($request->all());

    //     return redirect('/books')->with('success', 'Libro actualizado exitosamente.');
    // }

    // public function destroy(Book $book)
    // {
    //     $book->delete();
    //     return redirect('/books')->with('success', 'Libro eliminado.');
    // }
}

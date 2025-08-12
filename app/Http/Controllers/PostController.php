<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
        try {
            $validateStore = Validator::make($request->all(), $this->postsValidator);

            if($validateStore->fails()){
                return response()->json([
                    'message' => 'Ha ocurrido un error de validación',
                    'errors' => $validateStore->errors()
                ], 400);
            }

            $data = $validateStore->validated();
            $user = Auth::user();
            

            $post = Post::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'user_id' => $user->id
            ]);

           // Respuesta de éxito
            return response()->json([
                'message' => 'El Post se ha creado',
                'post' => $post
            ], 200);

        } catch (\Exception $e){
            return response()->json([
                'message' => 'Error Interno del Servidor',
                'error' => $e -> getMessage()
            ]);

        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validateUpdate = Validator::make($request->all(), $this->postsValidator);

            if ($validateUpdate->fails()) {
                return response()->json([
                    'message' => 'Ha ocurrido un error de validación',
                    'errors' => $validateUpdate->errors()
                ], 400);
            }

            // Buscar el post
            $post = Post::findOrFail($id);

            // Verificar si es el creador
            if ($post->user_id !== Auth::id()) {
                return response()->json([
                    'message' => 'No tienes permiso para actualizar este post'
                ], 403);
            }

            $post->update($validateUpdate->validated());

            return response()->json([
                'message' => 'Post actualizado correctamente',
                'post' => $post
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error Interno del Servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);

            // Verificar si es el creador
            if ($post->user_id !== Auth::id()) {
                return response()->json([
                    'message' => 'No tienes permiso para eliminar este post'
                ], 403);
            }

            $post->delete();

            return response()->json([
                'message' => 'Post eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error Interno del Servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    
}

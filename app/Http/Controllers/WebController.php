<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
class WebController extends Controller
{
    public function index()
    {
        $todos = Post::all(); // Veritabanından tüm verileri çek
        return view('web.index', compact('todos'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Yeni todo oluştur
        Post::create([
            'title' => $request->input('title'),
        ]);

        // Verileri yeniden getir ve view'a döndür
        return redirect()->route('index');
    }

    public function destroy($id)
    {
        $todo = Post::find($id);
        $todo->delete();
        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $todo = Post::find($id);
        $todo->completed = $request->input('completed');
        $todo->save();

        return response()->json(['success' => true]);
    }

}

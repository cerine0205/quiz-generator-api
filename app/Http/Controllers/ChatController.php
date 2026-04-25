<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    // GET /api/chats
    public function index(Request $request)
    {
        return $request->user()
            ->chats()
            ->latest()
            ->get();
    }

    // POST /api/chats
    public function store(Request $request)
    {
        $chat = $request->user()->chats()->create([
            'title' => $request->input('title', 'New Chat'),
        ]);

        return response()->json($chat, 201);
    }

    // GET /api/chats/{id}
    public function show(Request $request, $id)
    {
        $chat = $request->user()
            ->chats()
            ->with('messages')
            ->findOrFail($id);

        return response()->json($chat);
    }

    // DELETE /api/chats/{id}
    public function destroy(Request $request, $id)
    {
        $chat = $request->user()
            ->chats()
            ->findOrFail($id);

        $chat->delete();

        return response()->json([
            'message' => 'Chat deleted successfully'
        ]);
    }
}

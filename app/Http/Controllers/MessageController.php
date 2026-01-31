<?php

namespace App\Http\Controllers;

use App\Events\MessageSend;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client.messages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string'],
            'recipient_id' => ['required', 'integer', 'exists:users,id']
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'recipient_id' => $request->post('recipient_id'),
            'message' => $request->post('message')
        ]);

        // now i need useing the (Event Listenr)
        event(new MessageSend($message));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

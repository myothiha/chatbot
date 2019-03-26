<?php

namespace App\Http\Controllers;

use App\Services\Messenger\ChatBot;
use Illuminate\Http\Request;

class BroadcastController extends Controller
{
    private $chatbot;

    /**
     * BroadcastController constructor.
     * @param ChatBot $chatbot
     */
    public function __construct(ChatBot $chatbot)
    {
        $this->chatbot = $chatbot;
    }

    public function getBroadcast(Request $request)
    {
        return view('admin.broadcast.create');
    }

    public function broadcast(Request $request)
    {
        $this->chatbot->broadcast($request->message);
        return redirect()->action('BroadcastController@getBroadcast');
    }

}

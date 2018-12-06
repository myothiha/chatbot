<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\FbUser;
use App\Reply;
use App\Services\Messenger\ApiConstant;
use App\Services\Messenger\ChatBot;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{

    private $chatBot;

    public function __construct(ChatBot $chatBot)
    {
        $this->chatBot = $chatBot;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FbUser $fbUser = null)
    {
        $fbUsers = $this->format(FbUser::notSeen()->get());

        $seenFbUsers = $this->format(FbUser::seen()->get());

        $currentFbUser = ($fbUser ?? $fbUsers->first()) ?? $seenFbUsers->first();

//        dd($currentFbUser->profilePic);

//        dd($currentFbUser->conversations->last()->replies->toArray());

//        dd($fbUsers->toArray());

//        dd($fbUsers->first()->conversations->last()->updated_at->diffForHumans());

        return view('admin.conversations.index', [
            'fbUsers'       => $fbUsers,
            'seenFbUsers'   => $seenFbUsers,
            'currentFbUser' => $currentFbUser,
        ]);
    }

    public function reply(Request $request,FbUser $fbUser)
    {
        $this->chatBot->setFbUser($fbUser);

        $reply = new Reply(['message' => $request->message, 'conversation_id' => $fbUser->conversations->last()->id]);
        Auth::user()->replies()->save($reply);

        $response = $this->chatBot->reply([$reply->message], ApiConstant::TEXT);

        $fbUser->seenMode(ApiConstant::SEEN); // Todo mark seen when admin reply message

        return redirect("/conversations/{$fbUser->id}");
    }

    private function format(Collection $collection) {
        return $collection->filter(function ($fbUser, $key) {
            return $fbUser->conversations->isNotEmpty();
        })
            ->sortByDesc(function ($fbUser, $key) {
                return $fbUser->conversations->last()->created_at->timestamp;
            })
            ->values();
    }
}

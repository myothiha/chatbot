@extends('admin.layouts.app')

@section('title', 'Conversations')

@section('heading', 'Messages')

@section('subheading', "From Users" )

<!-- Breadcrumb Section -->
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ action('QuestionController@index', 0) }}">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <a>Messages</a>
        </li>
    </ol>
@endsection

@section('content')

    <!-- Content Section -->

    <div class="row mb-4">
        @if( $currentFbUser != null )
            <div class="messaging">
                <div class="inbox_msg">
                    <div class="inbox_people">
                        <div class="headind_srch">
                            <div class="recent_heading">
                                <h4>Recent</h4>
                            </div>
                        </div>
                        <div class="inbox_chat">
                            @foreach($fbUsers as $index => $fbUser)
                                <div class="chat_list{{ $fbUser->is($currentFbUser) ? ' active_chat' : '' }}">
                                    <a href="{{ @action('ConversationController@index', $fbUser->id) }}">
                                        <div class="chat_people">
                                            <div class="chat_img">
                                                <img src="{{ $fbUser->profilePic }}" alt="sunil">
                                            </div>
                                            <div class="chat_ib">
                                                <h5>{{ $fbUser->name }} <span
                                                        class="chat_date">{{ $fbUser->conversations->last()->created_at->diffForHumans() }}</span>
                                                </h5>
                                                <p class="unseen">{{ $fbUser->conversations->last()->message }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                            @foreach($seenFbUsers as $index => $fbUser)
                                <div class="chat_list{{ $fbUser->is($currentFbUser) ? ' active_chat' : '' }}">
                                    <a href="{{ @action('ConversationController@index', $fbUser->id) }}">
                                        <div class="chat_people">
                                            <div class="chat_img">
                                                <img src="{{ $fbUser->profilePic }}" alt="sunil">
                                            </div>
                                            <div class="chat_ib">
                                                <h5>{{ $fbUser->name }} <span
                                                        class="chat_date">{{ $fbUser->conversations->last()->created_at->diffForHumans() }}</span>
                                                </h5>
                                                <p>{{ $fbUser->conversations->last()->message }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mesgs">
                        <div class="msg_history">
                            @foreach($currentFbUser->conversations as $conversation)
                                <div class="incoming_msg">
                                    <div class="incoming_msg_img">
                                        <img src="{{ $currentFbUser->profilePic }}">
                                    </div>
                                    <div class="received_msg">
                                        <div class="received_withd_msg">
                                            <p>{{ $conversation->message }}</p>
                                            <span
                                                class="time_date"> {{ $conversation->created_at->format('h : i A | M d') }} </span>
                                        </div>
                                    </div>
                                </div>
                                @foreach($conversation->replies as $reply)
                                    <div class="outgoing_msg">
                                        <div class="sent_msg">
                                            <p>{{ $reply->message }}</p>
                                            <span
                                                class="time_date"> {{ $reply->created_at->format('h : i A | M d') }} </span>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                        <div class="type_msg">
                            <div class="input_msg_write">
                                <form action="{{ @action('ConversationController@reply', $currentFbUser->id) }}"
                                      method="POST">
                                    {{ csrf_field() }}
                                    <input type="text" name="message" class="write_msg" placeholder="Type a message"/>
                                    <button class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o"
                                                                                  aria-hidden="true"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <p>Currently no conversation</p>
        @endif

    </div>
    <!-- /.row -->
@endsection

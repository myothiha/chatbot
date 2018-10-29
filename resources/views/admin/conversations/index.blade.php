@extends('admin.layouts.app')

@section('title', 'Conversations')

@section('heading', 'Questions')

@section('subheading', "From Users" )

<!-- Breadcrumb Section -->
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ action('QuestionController@index', 0) }}">Home</a>
    </li>
    <li class="breadcrumb-item active">
        <a>Conversation</a>
    </li>
@endsection

@section('content')

    <!-- Content Section -->

    <div class="row mb-4">

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Message</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($fbUsers as $index => $fbUser)
                <tr>

                    <th scope="row">{{ ++$index }}</th>
                    <td>{{ $fbUser->name }}</td>
                    <td>{{ $fbUser->conversations->last()->message }}</td>

                    <td><a href="{{ action('ConversationController@reply', $fbUser->id ) }}"
                           class="btn btn-outline-dark">Reply</a></td>

                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.row -->
@endsection

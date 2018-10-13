@extends('admin.layouts.app')

@section('title', 'Page Title')

@section('heading', 'Answers')

@section('subheading', "For " . ($question->message ?? "Top Question") )

<!-- Breadcrumb Section -->
@section('breadcrumb')
    <li class="breadcrumb-item">
        Answers</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ action('AnswerController@index', $questionId) }}">List</a>
    </li>
@endsection

@section('content')

    <!-- Content Section -->

    <!-- Answer Create Button -->
    <div class="row">
        <a href="{{ action('AnswerController@create', $parentId) }}" class="btn btn-outline-info mb-3">Create New
            Answer</a>
    </div>

    <!-- Answer Type -->
    <div class="row  mb-4">
        <p>Type:</p>

        <form class="form-inline" action="{{ action('AnswerTypeController@store', $parentId) }}" method="POST">

            {{ csrf_field() }}

            <div class="form-group mx-sm-3 mb-2">
                <label for="type" class="sr-only">Type: </label>
                <select id="type" name="type" class="form-control" required>

                    @if(!$answerType)
                        <option value="" selected>None</option>
                    @endif

                    @foreach( $types as $key => $value)

                        @if ($answerType == $key)
                            <option value="{{ $key }}" selected>{{ $value }}</option>
                        @else
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endif

                    @endforeach
                </select>
            </div>
            <input type="submit" name="btnSubmit" class="btn btn-outline-info" value="Save">
        </form>
    </div>

    <div class="row mb-4">

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Answer (EN)</th>
                <th scope="col">Answer (MM)</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($answers as $index => $question)
                <tr>

                    <th scope="row">{{ ++$index }}</th>
                    <td>{{ $question->message_en }}</td>
                    <td>{{ $question->message_zg }}</td>
                    <td><a href="{{ action('AnswerController@index', $question->id) }}"
                           class="btn btn-outline-info">Sub Questions</a></td>
                    <td><a href="{{ action('AnswerController@edit', [$parentId, $question->id]) }}"
                           class="btn btn-outline-dark">Edit</a></td>
                    <td>
                        <form action="{{ action('AnswerController@destroy', [$parentId, $question->id]) }}"
                              method="post">

                            {{ csrf_field() }}

                            <input type="hidden" name="_method" value="DELETE"/>

                            <input type="submit" class="btn btn-outline-danger" name="btnSubmit" value="Delete"/>
                        </form>
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.row -->
@endsection

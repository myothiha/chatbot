@extends('admin.layouts.app')

@section('title', 'Page Title')

@section('heading', 'Questions')

@section('subheading', 'List')

<!-- Breadcrumb Section -->
@section('breadcrumb')
    <li class="breadcrumb-item">
        Questions</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ action('QuestionController@index', $parentId) }}">List</a>
    </li>
@endsection

@section('content')

    <!-- Content Section -->

    <div class="row">
        <a href="{{ action('QuestionController@create', $parentId) }}" class="btn btn-outline-info mb-3">Create New
            Question</a>
    </div>

    <div class="row  mb-4">
        <form class="form-inline">
            <div class="form-group mx-sm-3 mb-2">
                <label for="type" class="sr-only">Type: </label>
                <select id="type" name="type" class="form-control">
                    @foreach( \App\Models\Questions\Question::TYPES as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
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
                <th scope="col">Question (EN)</th>
                <th scope="col">Question (MM)</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($questions as $index => $question)
                <tr>

                    <th scope="row">{{ ++$index }}</th>
                    <td>{{ $question->message_en }}</td>
                    <td>{{ $question->message_zg }}</td>
                    <td><a href="{{ action('QuestionController@index', $question->id) }}"
                           class="btn btn-outline-info">Sub Questions</a></td>
                    <td><a href="{{ action('QuestionController@edit', [$parentId, $question->id]) }}"
                           class="btn btn-outline-dark">Edit</a></td>
                    <td>
                        <form action="{{ action('QuestionController@destroy', [$parentId, $question->id]) }}"
                              method="post">

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

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
        <a href="{{ action('QuestionController@index') }}">List</a>
    </li>
@endsection

@section('content')

    <!-- Content Section -->
    <div class="row mb-4">

        <a href="{{ @action('QuestionController@create', $question->id ?? 0) }}" class="btn btn-outline-info mb-3">Create New Question</a>

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">No</th>
                <th scope="col">Question (EN)</th>
                <th scope="col">Question (MM)</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                @foreach($questions as $index => $question)
                    <th scope="row">{{ $index }}</th>
                    <td>{{ $question->message_en }}</td>
                    <td>{{ $question->message_zg }}</td>

                    <form action="{{ @action('QuestionController@delete', $question->id) }}" method="post">

                        <input type="hidden" name="_method" value="DELETE" />

                        <a  href="{{ @action('QuestionController@edit', $question->id) }}" class="btn btn-secondary">Edit</a>
                        <input type="submit" class="btn btn-danger" name="btnSubmit" value="submit" />
                    </form>

                @endforeach
            </tr>
            </tbody>
        </table>
    </div>
    <!-- /.row -->
@endsection

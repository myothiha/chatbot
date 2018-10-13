@extends('admin.layouts.app')

@section('title', 'Page Title')

@section('heading', 'Create Answer')

<!-- Breadcrumb Section -->
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a>Answers</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ action('AnswerController@index', $questionId) }}">List</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ action('AnswerController@create', $questionId) }}">Create Answer</a>
    </li>
@endsection

@section('content')

    <!-- Content Section -->
    <form action="{{ action('AnswerController@store', $questionId) }}" method="post" enctype="multipart/form-data">

        {{ csrf_field() }}

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Trace Aid</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="traceAId" name="traceAId" placeholder="Trace Aid">
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Button (Myanmar 3)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="button_mm3" name="button_mm3"
                       placeholder="Text want to display on Button">
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Message (Myanmar 3)</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="message_mm3" name="message_mm3"
                          placeholder="Message want to display"></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Button (Zawgyi)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="button_zg" name="button_zg"
                       placeholder="Text want to display on Button">
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Message (Zawgyi)</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="message_zg" name="message_zg"
                          placeholder="Message want to display"></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Button (English)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="button_en" name="button_en"
                       placeholder="Text want to display on Button">
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Message (English)</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="message_en" name="message_en"
                          placeholder="Message want to display"></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Image</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" id="image" name="image" placeholder="Message want to display">
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Visible</label>
            <div class="col-sm-10">
                <select id="type" name="type" class="form-control">
                    <option value="1">True</option>
                    <option value="0">False</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
    <!-- /.row -->
@endsection

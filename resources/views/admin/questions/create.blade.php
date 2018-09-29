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
    <form action="{{ action('QuestionController@store', $parentId) }}" method="post" enctype="multipart/form-data">
        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Type</label>
            <div class="col-sm-10">
                <select id="type" name="type" class="form-control">
                    @foreach( $types as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Trace Qid</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="traceQid" name="traceQId" placeholder="Trace Qid">
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Trace Pid</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="tracePId" name="tracePId" placeholder="Trace Pid">
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
                <input type="text" class="form-control" id="message_mm3" name="message_mm3"
                       placeholder="Message want to display">
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
                <input type="text" class="form-control" id="message_zg" name="message_zg"
                       placeholder="Message want to display">
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
                <input type="text" class="form-control" id="message_en" name="message_en"
                       placeholder="Message want to display">
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

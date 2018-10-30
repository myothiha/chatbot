@extends('admin.layouts.app')

@section('title', 'Page Title')

@section('heading', 'Questions')

@section('subheading', 'Edit')

<!-- Breadcrumb Section -->
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            Index
        </li>
        <li class="breadcrumb-item">
            <a href="{{ action('QuestionController@index', 0) }}">List</a>
        </li>

        @foreach($parentQuestions as $quest)
            <li class="breadcrumb-item">
                <a href="{{ action('QuestionController@index', $quest->id) }}">{{ $quest->message_en }}</a>
            </li>
        @endforeach

        <li class="breadcrumb-item active">
            <a href="#"><b>{{ $question->message_en }} Edit</b></a>
        </li>
    </ol>
@endsection

@section('content')

    <!-- Content Section -->
    <form action="{{ action('QuestionController@update', [$parentId, $question->id]) }}" method="post"
          enctype="multipart/form-data">

        {{ csrf_field() }}

        <input type="hidden" name="_method" value="PUT" />

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Trace Qid</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="traceQid" name="traceQId" placeholder="Trace Qid" value="{{ $question->traceQId }}">
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Trace Pid</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="tracePId" name="tracePId" placeholder="Trace Pid" value="{{ $question->tracePId }}">
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Button (Myanmar 3)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="button_mm3"rows="10" name="button_mm3" value="{{ $question->button_mm3 }}"
                       placeholder="Text want to display on Button">
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Message (Myanmar 3)</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="message_mm3" rows="10" name="message_mm3"
                          placeholder="Message want to display">{{ $question->message_mm3 }}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Button (Zawgyi)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="button_zg" name="button_zg" value="{{ $question->button_zg }}"
                       placeholder="Text want to display on Button">
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Message (Zawgyi)</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="message_zg" rows="10" name="message_zg"
                          placeholder="Message want to display">{{ $question->message_zg }}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Button (English)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="button_en" name="button_en" value="{{ $question->button_en }}"
                       placeholder="Text want to display on Button">
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Message (English)</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="message_en" rows="10" name="message_en"
                          placeholder="Message want to display">{{ $question->message_en }}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Image</label>
            <div class="col-sm-10">
                <input type="hidden" name="prev_image" value="{{ $question->image }}" />
                <img src="{{$question->thumbnail}}" class="mb-2"/>
                <input type="file" class="form-control" id="image" name="image" placeholder="Message want to display">
            </div>
        </div>

        <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label">Visible</label>
            <div class="col-sm-10">
                <select id="status" name="status" class="form-control">
                    <option value="1" {{ $question->status==1 ? 'selected' : '' }}>True</option>
                    <option value="0" {{ $question->status==0 ? 'selected' : '' }}>False</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>
    <!-- /.row -->
@endsection

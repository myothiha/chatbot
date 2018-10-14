@extends('admin.layouts.app')

@section('title', 'Page Title')

@section('heading', 'Questions')

@section('subheading', 'List')

<!-- Breadcrumb Section -->
@section('breadcrumb')
    <li class="breadcrumb-item">
        Questions</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ action('AnswerController@index', $questionId) }}">List</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ action('AnswerController@edit', [$questionId, $answer->id] ) }}">Edit Question</a>
    </li>
@endsection

@section('content')

    <!-- Content Section -->
    <form action="{{ action('AnswerController@update', [$questionId, $answer->id]) }}" method="post"
          enctype="multipart/form-data">

        {{ csrf_field() }}

        <input type="hidden" name="_method" value="PUT" />

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Trace Aid</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="traceQid" name="traceAId" placeholder="Trace Aid" value="{{ $answer->traceAId }}">
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Button (Myanmar 3)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="button_mm3" name="button_mm3" value="{{ $answer->button_mm3 }}"
                       placeholder="Text want to display on Button">
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Message (Myanmar 3)</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="message_mm3" name="message_mm3"
                          placeholder="Message want to display">{{ $answer->message_mm3 }}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Button (Zawgyi)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="button_zg" name="button_zg" value="{{ $answer->button_zg }}"
                       placeholder="Text want to display on Button">
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Message (Zawgyi)</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="message_zg" name="message_zg"
                          placeholder="Message want to display">{{ $answer->message_zg }}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Button (English)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="button_en" name="button_en" value="{{ $answer->button_en }}"
                       placeholder="Text want to display on Button">
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Message (English)</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="message_en" name="message_en"
                          placeholder="Message want to display">{{ $answer->message_en }}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Image</label>
            <div class="col-sm-10">
                <input type="hidden" name="prev_image" value="{{ $answer->image }}" />
                <img src="{{$answer->thumbnail}}" class="mb-2"/>
                <input type="file" class="form-control" id="image" name="image" placeholder="Message want to display">
            </div>
        </div>

        <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label">Visible</label>
            <div class="col-sm-10">
                <select id="status" name="status" class="form-control">
                    <option value="1" {{ $answer->status==1 ? 'selected' : '' }}>True</option>
                    <option value="0" {{ $answer->status==0 ? 'selected' : '' }}>False</option>
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

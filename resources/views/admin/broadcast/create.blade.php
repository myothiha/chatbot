@extends('admin.layouts.app')

@section('title', 'Users')

@section('heading', 'Users')

@section('subheading', 'List')

<!-- Breadcrumb Section -->
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            Index
        </li>
        <li class="breadcrumb-item">
            <a href="{{ action('BroadcastController@getBroadcast') }}"><b>Broadcast to Users</b></a>
        </li>
    </ol>
@endsection

@section('content')

    <!-- Content Section -->
    <form action="{{ action('BroadcastController@broadcast') }}" method="post" enctype="multipart/form-data">

        {{ csrf_field() }}

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Message</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="message" name="message" placeholder="Message" required></textarea>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Broadcast</button>
            </div>
        </div>
    </form>
    <!-- /.row -->
@endsection

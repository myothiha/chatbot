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
            <a href="{{ action('BroadcastController@getBroadcastVideo') }}"><b>Broadcast to Users</b></a>
        </li>
    </ol>
@endsection

@section('content')

    <!-- Content Section -->
    <form action="{{ action('BroadcastController@broadcastVideo') }}" method="post" enctype="multipart/form-data">

        {{ csrf_field() }}

        <div class="form-group row">
            <label for="url" class="col-sm-2 col-form-label">Facebook Url</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="url" name="url" placeholder="Facebook Video Url" required />
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

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
            <a href="{{ action('UserController@index') }}"><b>Users</b></a>
        </li>
        <li class="breadcrumb-item">
            <a href="#"><b>Edit User</b></a>
        </li>
    </ol>
@endsection

@section('content')

    <!-- Content Section -->
    <form action="{{ action('UserController@update', $user->id) }}" method="post" enctype="multipart/form-data">

        {{ csrf_field() }}

        <input type="hidden" name="_method" value="put">

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" placeholder="Enter User's Name" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" placeholder="Enter User's email" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" placeholder="Type your password.">
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

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
    </ol>
@endsection

@section('content')

    <!-- Content Section -->

    <!-- Answer -->

    <!-- Answer Create Button -->
    <div class="row">
        <a href="{{ action('UserController@create') }}" class="btn btn-outline-info mb-3">Create New User</a>
    </div>

    <!-- Users List -->
    <div class="row mb-4">

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $index => $user)
                <tr>
                    <th scope="row">{{ ++$index }}</th>
                    <td><p>{{ $user->name }}</p></td>
                    <td><p>{{ $user->email }}</p></td>
                    <td>
                        <form action="{{ action('UserController@destroy', $user->id) }}"
                              method="post">

                            {{ csrf_field() }}

                            <a href="{{ action('UserController@edit', $user->id) }}" class="btn btn-outline-primary">Edit</a>

                            <input type="hidden" name="_method" value="DELETE"/>
                            <input type="submit" class="btn btn-outline-danger" name="btnSubmit" value="Delete"/>
                        </form>
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
@endsection

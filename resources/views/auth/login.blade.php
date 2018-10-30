@extends('admin.layouts.app')

@section('title', 'Conversations')

@section('content')

    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form action="{{ action('LoginController@check') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail
                                Address</label>
                            <div class="col-md-6">
                                <input type="text" id="email_address" class="form-control" name="email" required
                                       autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <input type="password" id="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                            {{--<a href="#" class="btn btn-link">--}}
                                {{--Forgot Your Password?--}}
                            {{--</a>--}}
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

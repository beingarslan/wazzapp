@extends('master')
@section('title','Login')

@section('content')
    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="/">
                        <img class="align-content" src="logo.png" style ='max-height: 200px'class='pr-2' >
                        
                    </a>
                </div>
                <div class="login-form">
                    {!! Form::open(["action"=>"UserController@authenticate","method"=>"post"]) !!}
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" class="form-control" name="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"> Remember Me
                            </label>
                            {{-- <label class="pull-right">
                                <a href="#">Forgotten Password?</a>
                            </label> --}}

                        </div>
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
               
                        <div class="register-link m-t-15 text-center">
                            <p>Don't have account ? <a href="/signup/"> Sign Up Here</a></p>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="js/main.js"></script>
@endsection
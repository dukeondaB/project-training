@extends('layouts.login')
@section('title', )
{{__('Login')}}
@endsection

@section('content')
    <div class="limiter">
        <div class="container-login100" style="background-image: url('{{asset('images/bg-01.jpg')}}');">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <form role="form" action="{{ route('login') }}" method="post" class="login100-form validate-form">
                    @csrf
                    <span class="login100-form-title p-b-49">
					    {{__('Login')}}
					</span>

                    <div class="wrap-input100 validate-input m-b-23" data-validate = "email is reauired">
                        <span class="label-input100">{{__('Email')}}</span>
                        <input id="email" class="input100" placeholder="{{__('Email')}}" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                        <span class="focus-input100" data-symbol="&#xf206;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <span class="label-input100">{{__('Password')}}</span>
                        <input id="password" class="input100" placeholder="{{__('Password')}}" type="password" class="form-control @error('password') is-invalid @enderror" name="password">


                        <span class="focus-input100" data-symbol="&#xf190;"></span>
                    </div>

                    <div class="wrap-input100">
                        @error('email')
                        <span class="text text-danger" role="alert"
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="text-right p-t-8 p-b-31">
                        <a href="#">
                            Forgot password?
                        </a>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn">
                                {{__('Login')}}
                            </button>
                        </div>
                    </div>




                </form>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

@endsection

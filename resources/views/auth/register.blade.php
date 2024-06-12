@extends('auth.layouts.master')
@section('Title' , 'Sign In')

@section('Content')

    <section class="auth h-100">
        <div class="h-100">
            <div class="row noHegiht h-100">
                <div class="wrapper h-100">
                    <div class="col-md-6 box details"> 
                    </div>
                    <div class="col-md-5 box">
                        <div class="form">
                            <div class="content">
                                <a href="https://zhome.com.eg" class="ZhomeName">Zhome</a>
                                <h3 class="login-form__title">{{ __('en.LoginToYourAccount') }}</h3>
                                <p>
                                    {{ __('en.HaveAccount') }}
                                    <a href="{{route('login')}}" class="fw-bold">{{ __('en.LoginNow') }}</a>
                                </p>
                            </div>
                        <form method='POST' action="{{ route('register') }}">
                                @csrf
                                <div class="inputs login-form__form">
                                    <div class="login-form__field position-relative" style="height:82px">
                                        <input type="text" name="Name" id="name" placeholder="{{ __('en.UserName') }}" required/>
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="login-form__field position-relative" style="height:82px">
                                        <input type="email" name="email" id="email" placeholder="{{ __('en.EmailAddress') }}" required />
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                                    <div class="login-form__field position-relative password-input" style="height:82px">
                                        <input type="password" name="password" id="password" placeholder="{{ __('en.EnterPassword') }}" required/>
                                        <i class="fa fa-eye toggler" id="eye"></i>
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    <button type="submit" class="thm-btn contact-one__btn">
                                        {{ __('en.SignUpNow') }}
                                    </button>

                                    <p style="text-align: center;margin-top: 19px;color: #acacac;margin-bottom:15px;">{{ __('en.LogSocial') }}</p>
                                    <div id="g_id_onload"
                                            data-client_id="673202749345-8voabpo6qcntjihfmlq4acudh7pl8o88.apps.googleusercontent.com"
                                            data-context="signup"
                                            data-ux_mode="popup"
                                            data-login_uri="https://zhome.com.eg/Common/SignIn.php"
                                            data-auto_prompt="false"
                                            data-callback="handleCredentialResponse">
                                    </div>
                                    <div class="d-flex gap-3 align-items-center justify-content-center flex-wrap" style="gap:20px;">
                                        <div class="g_id_signin"
                                                data-type="icon"
                                                data-shape="square"
                                                data-theme="filled_blue"
                                                data-text="signin_with"
                                                data-size="large"
                                                data-locale="en-GB"
                                                data-login_uri="https://zhome.com.eg/Common/SignIn.php"
                                        >
                                        </div>
                                        <a href="../SignWithFacebook.php" class="facebook-login-btn">
                                            <i class="fa-brands fa-facebook-f"></i>
                                            <span>{{ __('en.LogWithFacebook') }}</span>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-1 small-sidenav">
                        <ul class="small-sidenav-ul">
                            <li><a href="{{route('index')}}" title="{{ __('en.Home') }}"><i class="fa-solid fa-house"></i></a></li>
                            <li><a href="{{route('Shop.index')}}" title="{{ __('en.Shop') }}"><i class="fa-solid fa-store"></i></a></li>
                            <li><a href="{{route('About.index')}}" title="{{ __('en.About') }}"><i class="fa-solid fa-circle-info"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('Js')
    <script>
        $("[placeholder]").focus(function () {
            $(this).attr("data-text", $(this).attr("placeholder"));
            $(this).attr("placeholder", "");
        }).blur(function () {
            $(this).attr("placeholder", $(this).attr("data-text"));
        });

        // Eye toggler Password
        document.getElementById('eye').addEventListener('click', function () {
            let passwordField = document.getElementById('password');
            let eyeIcon = document.getElementById('eye');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }

            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    </script>
@stop
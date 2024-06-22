@extends('User.layout.master')
@section('Title' , 'Contact Us')

@section('Content')

    @section('Css')
        <style>
                @media (max-width: 767px){
                    .row.no-gutters .col-lg-12{
                        text-align: center;
                    }
                }
                i.fa-check{
                    font-size: 20px;
                }
                .ErrorMessages .alert.alert-success {
                    border-right: 4px solid #155741 !important;
                }
                span.asterisk{
                    display:none;
                }
        </style>
    @endsection

    <section class="shop-background site-banner jarallax min-height300 padding-large" style="background: url({{asset('UI/Imgs/website/Home/About/contactusbackgorund.webp')}}">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-title" class="text-white">{{ __('messages.Zhome')}}</h1>
                    <div class="breadcrumbs">
                    <span class="item">
                        <a href="{{route('index')}}" class="text-white">{{ __('messages.Home')}} /</a>
                    </span>
                    <span class="item" class="text-white">{{ __('messages.ContactUs')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Error --}}
    @include('User.components.Msg')

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact-one__main">
                        <div class="contact-one__image">
                            <img src="{{asset('UI/imgs/website/Home/Contact/Background.jpg')}}" class="img-fluid" alt="Background Zhome" />
                        </div>
                        <div class="contact-one__content">
                            <div class="row no-gutters">
                                <div class="col-lg-12">
                                    <h3 class="contact-one__title">{{ __('messages.Zhome')}}</h3>
                                    <p class="contact-one__text">{{ __('messages.ZhomeLocation')}}</p>
                                    <p class="contact-one__text"><a href="">{{ __('messages.ContactPhone') . "0" . $contact->Phone}}</a></p>
                                    <p class="contact-one__text"><a href="mailto:Zhome@gmail.com">{{ __('messages.ZhomeEmail')}}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <form method="POST" class="contact-one__form">
                        <div class="row">
                            @if (Auth::guard('web')->check())
                                <input type="hidden" name="UserID" value=" {{Auth::guard('web')->user()->id}}">
                                <div class="col-lg-12">
                                    <p class="contact-one__field">
                                        <label for="UserNameContactUs">{{ __('messages.ContactName')}}</label>
                                        <input type="text" name="Name" id="UserNameContactUs"  value="{{Auth::guard('web')->user()->Name }}">
                                        @error('Name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </p>
                                </div>
                                <div class="col-lg-6">
                                    <p class="contact-one__field">
                                        <label for="UserEmailContactUs">{{ __('messages.ContactEmail')}}</label>
                                        <input type="email" name="email" id="UserEmailContactUs" value="{{Auth::guard('web')->user()->email }}" required>
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </p>
                                </div>
                                <div class="col-lg-6">
                                    <p class="contact-one__field">
                                        <label for="UserPhoneContactUs">{{ __('messages.ContactPhone')}}</label>
                                        <input type="tel" name="Phone" id="UserPhoneContactUs" pattern="[0-9]*" value="{{Auth::guard('web')->user()->Phone }}" >
                                        @error('Phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </p>
                                </div>
                            @else
                                <div class="col-lg-12">
                                    <p class="contact-one__field">
                                        <label for="UserNameContactUs">{{ __('messages.ContactName')}}</label>
                                        <input type="text" name="Name" id="UserNameContactUs">
                                        @error('Name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </p>
                                </div>
                                <div class="col-lg-6">
                                    <p class="contact-one__field">
                                        <label for="UserEmailContactUs">{{ __('messages.ContactEmail')}}</label>
                                        <input type="email" name="email" id="UserEmailContactUs" required>
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </p>
                                </div>
                                <div class="col-lg-6">
                                    <p class="contact-one__field">
                                        <label for="UserPhoneContactUs">{{ __('messages.ContactPhone')}}</label>
                                        <input type="tel" name="Phone" id="UserPhoneContactUs" pattern="[0-9]*" >
                                        @error('Phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </p>
                                </div>
                            @endif

                            <div class="col-lg-12">
                                <p class="contact-one__field">
                                    <label for="UserSubjectContactUs">{{ __('messages.ContactSubject')}}</label>
                                    <input type="text" name="subject" id="UserSubjectContactUs" required>
                                    @error('subject')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </p>
                            </div>
                            <div class="col-lg-12">
                                <p class="contact-one__field">
                                    <label for="UserQuestionContactUs">{{ __('messages.ContactMessage')}}</label>
                                    <textarea name="UsersQuestion" id="UserQuestionContactUs" required></textarea>
                                    @error('UsersQuestion')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <button type="submit" class="thm-btn contact-one__btn">{{ __('messages.SendMessage')}}</button>
                                </p>
                            </div>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map -->
    <div class="contact-map-one" id="map">
        <div class="container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3456.490986993673!2d31.325215774340798!3d29.965316574963495!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1458392bdbce2669%3A0xae3fdbc2258f3e74!2sZHome!5e0!3m2!1sen!2seg!4v1695458349636!5m2!1sen!2seg" class="google-map__home" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

@endsection

@section('Js')
    <script>
        updateCartCount() 
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var errorMessagesDiv = document.getElementById('errorMessages');
    
            if (errorMessagesDiv) {
                setTimeout(function () {
                    errorMessagesDiv.style.display = 'none';
                }, 5000);
            }
        });
    </script>
@stop


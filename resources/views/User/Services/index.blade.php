@extends('User.layout.master')

@section('Title', 'Services')
    
@section('Css')
    <style>
        section.SectionNumber:nth-child(odd) {
                direction: rtl;
        }
        @media (max-width: 767px) {
            .SectionNumber hr.vertical {
                width: auto;
            }
        }
    </style>
@endsection

@section('Content')

    <div class="container mt-5 pt-4 mb-5">
        <div class="block-title text-center">
            <p class="block-title__tag-line text-center">Zhome</p>
            <h1 class="text-center">{{ __('messages.Services')}}</h1>
        </div>
    </div>

    <!-- Services -->
    @foreach($services as $service)

        <section class="SectionNumber">
            <div class="container">
                <div class="Cards-contact mt-5 pt-3">
                    <div class="card-contact-left text-center">
                        <img src="{{asset('Admin/dist/img/web/Services/')}}" class="ProposalProduct" style="width: 497px;height: 367px;border-radius: 3px;" alt="{{$service->Name}}">
                        <div>
                            <h2 style="font-size: 35px;">
                                @if(App::getLocale() == 'ar')
                                    {{$service->ArabicName}}
                                @else
                                    {{$service->Name}}
                                @endif
                            </h2>
                            <p>
                                @if(App::getLocale() == 'ar')
                                    {{$service->ArabicDescription}}
                                @else
                                    {{$service->Description}}
                                @endif
                            </p>
                            @if($service->Duration)
                                <span>{{ __('messages.Duration')}}<?php echo $Service['Duration']. " Minutes" ?></span>
                            @endif
                            <br>
                            @if($service->Price)
                                <span>{{ __('messages.Price') . __('messages.DepenedsOntheProduct')}} </span>
                            @else
                                <span>{{ __('messages.Price') . $service->Price . "EGP"}}</span>
                            @endif
                            <div>
                                <a class="btn btn-info button-Tool text-white" <?php if($Service['Status'] == '1'){ echo " href=".$Service['Link']." " ;} ?> >{{ $service->ButtonText}}</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <hr class="vertical">
        </section>

    @endforeach

    <!--Booing Card-->
    <?php 
        // if(isset($_GET['action']) && $_GET['action'] == "Success" ){
        //     if(isset($_SESSION['UserID'])){
        //         $UserID = $_SESSION['UserID'];
        //         $TransactionID = $_GET['TransactionID'];
        //         $BookedService = mysqli_query($con , "SELECT userbookedservice.* , user.* FROM userbookedservice LEFT JOIN user ON user.ID = userbookedservice.UserID WHERE TransactionID = $TransactionID AND UserID = $UserID");
        //         $Booked = mysqli_fetch_assoc($BookedService);
        //         $count = mysqli_num_rows($BookedService);
        //         $currentDate = date('Y-m-d');
        //         $twoDaysNext = date('Y-m-d', strtotime('+2 days', strtotime($Booked['Date'])));
                
        //         if($count > 0){
                    
        //            echo "<div class='alert alert-success' style='text-align: center;' id='Success'>";
        //                echo "<h3>Successfully Booked</h3>";
        //            echo "</div>";
                   
        //          echo  $BookingCard = "    
        //                   <div class='BookingCardContainer'>
        //                        <h3> Video Call </h3>
        //                        <div class='BookingCard'>
        //                            <div class='BookingCard-Photo'>
        //                                <img src='../Admin/Images/avatar.png' alt='Image'>
        //                                <p>".$Booked['Name']."</p>
        //                            </div>
        //                            <div class='BookingCard-Info'>
        //                                 <p>".$Booked['Email']."</p>
        //                                 <p>On ". date('d-M Y', strtotime($Booked['Date'])) ."</p>
        //                                 <p>".$Booked['Time']."</p>
        //                                 ".  ($currentDate < $Booked['Date'] ? "<span class='btn btn-success'>Incoming</span>" :
                                                
        //                                     ($currentDate == $Booked['Date'] ? "<span class='btn btn-success'>Today</span>" : "")
                                                   
        //                                     )."
        //                            </div>
        //                        </div>
        //                        <p class='smalltext'>* An email will be sent to your email with the link of the meeting. *</p>
        //                   </div> ";
        //         }
                
        //     }else{
        //         // the proplem here that he isnot a user he doesnot have an email or phone !!
        //         $UserID = session_id();
        //         $TransactionID = $_GET['TransactionID'];
        //         $BookedService = mysqli_query($con , "SELECT * FROM userbookedservice WHERE TransactionID = $TransactionID AND UnkownID = '$UserID'");
        //         $Booked = mysqli_fetch_assoc($BookedService);
        //         $count = mysqli_num_rows($BookedService);

        //         if($count > 0){
                    
        //            echo "<div class='alert alert-success'>";
        //                echo "Please Sign in now to send an ";
        //            echo "</div>";
                    
        //         }
        //     }
        // }else{
        //     if(isset($_SESSION['UserID'])){
        //         $UserID = $_SESSION['UserID'];
        //         $BookedService = mysqli_query($con , "SELECT userbookedservice.* , user.* FROM userbookedservice LEFT JOIN user ON user.ID = userbookedservice.UserID WHERE UserID = $UserID");
        //         $Booked = mysqli_fetch_assoc($BookedService);
        //         $count = mysqli_num_rows($BookedService);
        //         $currentDate = date('Y-m-d');
        //         $twoDaysNext = date('Y-m-d', strtotime('+2 days', strtotime($Booked['Date'])));
                
        //         if($count > 0){
                    
        //            echo "<div style='text-align: center;'>";
        //                echo "<h3 style='font-size: 40px;font-weight: 400;margin-top: 50px;cursor: default;'>Your Request</h3>";
        //            echo "</div>";
                   
        //          echo  $BookingCard = "    
        //                   <div class='BookingCardContainer' style='margin-top: 32px;'>
        //                        <h3> Video Call </h3>
        //                        <div class='BookingCard'>
        //                            <div class='BookingCard-Photo'>
        //                                <img src='../Admin/Images/avatar.png' alt='Image'>
        //                                <p>".$Booked['Name']."</p>
        //                            </div>
        //                            <div class='BookingCard-Info'>
        //                                 <p>".$Booked['Email']."</p>
        //                                 <p>On ". date('d-M Y', strtotime($Booked['Date'])) ."</p>
        //                                 <p>".$Booked['Time']."</p>
        //                                 ".  ($currentDate < $Booked['Date'] ? "<span class='btn btn-success'>Incoming</span>" :
                                                
        //                                     ($currentDate == $Booked['Date'] ? "<span class='btn btn-success'>Today</span>" : "")
                                                   
        //                                     )."
        //                            </div>
        //                        </div>
        //                        <p class='smalltext'>* An email will be sent to your email with the link of the meeting. *</p>
        //                   </div> ";
        //         }
        //     }
        // }
    ?>

@endsection

@section('Js')

    <script>
        updateCartCount();
    </script>

@stop
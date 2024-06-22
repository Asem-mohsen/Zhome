<style>
    .border-none{
        border :0px;
        background-color:transparent;
    }
</style>

    <!-- Header -->
    <div class="container" style="margin-top: 70px;margin-bottom: 40px;">
        <div class="block-title text-center">
            <p class="block-title__tag-line text-center">Zhome</p>
            <h1 style="text-align: center;">Video Call</h1>
        </div>
    </div>

    <?php 
        $SelectService = "SELECT * FROM services WHERE Link = '$Link'";
        $Services = mysqli_query($con , $SelectService);
        $Service= mysqli_fetch_assoc($Services);
        $count_Services =mysqli_num_rows($Services);
        $todaysDate = date("d-M Y");
        $nextDayDate = date("d-M Y", strtotime($todaysDate . " +1 day"));
        $next2DayDate = date("d-M Y", strtotime($todaysDate . " +2 day"));
        $next3DayDate = date("d-M Y", strtotime($todaysDate . " +3 day"));
        $next4DayDate = date("d-M Y", strtotime($todaysDate . " +4 day"));


    // <!--Hidden Values-->
    
        echo '<input class="service-name" type="hidden" name="service-name" value="Video Call">';
        echo '<input class="service-price" type="hidden" name="service-price" value="'. $Service['Price'] .'">';
        echo '<input id="UserName" type="hidden" name="UserName" value="'. (isset($UserService['Name']) ?  $UserService['Name'] : 'Unknown') .'">';
        echo '<input id="UserEmail" type="hidden" name="UserEmail" value="'. (isset($UserService['Email']) ?  $UserService['Email'] : 'Unknown') .'">';
        echo '<input id="UserPhone" type="hidden" name="UserPhone" value="'. (isset($UserService['Phone']) ?  $UserService['Phone'] : 0) .'">';
        echo '<input id="UserAddress" type="hidden" name="UserAddress" value="'. (isset($UserService['Address']) ?  $UserService['Address'] : 'None') .'">';

        if($count_Services > 0){ ?>

            <section class="SectionNumber">
                <div class="container">
                    <div class="Cards-contact" style="margin-top: 57px;">
                        <div class="card-contact-left" style="align-items: center;">
                            <img src="../Admin/Images/<?php echo $Service['Image'] ?>" class="ProposalProduct" style="width: 497px;height: 367px;border-radius: 3px;">
                            <div>
                                <h3 style="font-size: 35px;"><?php echo "Why to contact us with video call ?" ?></h3>
                                <p> <?php echo $Service['Description'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container">
                    <div class="table-responsive p-0" style="margin-top: 90px;">
                        <table id="example" class="table table-striped align-items-center mb-0 ServiceTable">
                            <thead>
                                <tr>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Time</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Duration</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                     <input type="hidden" class="UserID" name="UserID" value="<?php  if(isset($_SESSION['UserID'])){ echo $_SESSION['UserID'] ; }else{echo session_id() ; } ?>">  

                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            <?php echo $todaysDate?>
                                             <input type="hidden" class="ServiceDate" name="Date" value="<?php echo $todaysDate?>">  
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <div class="px-2 py-1" style="display:grid;">
                                                <div class="form-group" style="display:flex;justify-content: center;gap: 10px;" >
                                                    <input type="radio" id="CheckboxTime4-1" class="ServiceTime" name="Time" value="12:00pm - 12:30pm">  
                                                    <p class="text-xs text-secondary mb-0" for="CheckboxTime4-1">
                                                        <?php echo "12:00pm - 12:30pm" ?>
                                                    </p>
                                                </div>  
                                                <div class="form-group" style="display:flex;justify-content: center;gap: 10px;" >
                                                    <input type="radio" id="CheckboxTime4-2" class="ServiceTime" name="Time" value="01:00pm - 01:30pm">  
                                                    <p class="text-xs text-secondary mb-0" for="CheckboxTime4-2">
                                                        <?php echo "01:00pm - 01:30pm" ?>
                                                    </p>
                                                </div>  
                                                <div class="form-group" style="display:flex;justify-content: center;gap: 10px;" >
                                                    <input type="radio" id="CheckboxTime4-3" class="ServiceTime" name="Time" value="02:00pm - 02:30pm">  
                                                    <p class="text-xs text-secondary mb-0" for="CheckboxTime4-3">
                                                        <?php echo "02:00pm - 02:30pm" ?>
                                                    </p>
                                                </div>                                                
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <?php echo $Service['Duration'] ?> Minutes
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold"><?php echo $Service['Price'] ?> EGP</span>
                                             <input type="hidden" class="ServicePrice" name="ServicePrice" value="<?php echo $Service['Price'] ?>">  
                                        </td>
                                        <td class="align-middle">
                                            <button  class="text-secondary font-weight-bold text-xs border-none ButtonServicePay"  data-original-title="Book">
                                                Pay Now
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            <?php echo $nextDayDate?>
                                             <input type="hidden" class="ServiceDate" name="Date" value="<?php echo $nextDayDate?>">  
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <div class="px-2 py-1" style="display:grid;">
                                                <div class="form-group" style="display:flex;justify-content: center;gap: 10px;" >
                                                    <input type="radio" id="CheckboxTime4-1"  class="ServiceTime" name="Time" value="12:00pm - 12:30pm">  
                                                    <p class="text-xs text-secondary mb-0" for="CheckboxTime4-1">
                                                        <?php echo "12:00pm - 12:30pm" ?>
                                                    </p>
                                                </div>  
                                                <div class="form-group" style="display:flex;justify-content: center;gap: 10px;" >
                                                    <input type="radio" id="CheckboxTime4-2"  class="ServiceTime" name="Time" value="01:00pm - 01:30pm">  
                                                    <p class="text-xs text-secondary mb-0" for="CheckboxTime4-2">
                                                        <?php echo "01:00pm - 01:30pm" ?>
                                                    </p>
                                                </div>  
                                                <div class="form-group" style="display:flex;justify-content: center;gap: 10px;" >
                                                    <input type="radio" id="CheckboxTime4-3"  class="ServiceTime" name="Time" value="02:00pm - 02:30pm">  
                                                    <p class="text-xs text-secondary mb-0" for="CheckboxTime4-3">
                                                        <?php echo "02:00pm - 02:30pm" ?>
                                                    </p>
                                                </div>                                                
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <?php echo $Service['Duration'] ?> Minutes
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold"><?php echo $Service['Price'] ?> EGP</span>
                                             <input type="hidden" class="ServicePrice" name="ServicePrice" value="<?php echo $Service['Price'] ?>">  
                                        </td>
                                        <td class="align-middle">
                                            <button class="text-secondary font-weight-bold text-xs border-none ButtonServicePay"  data-original-title="Book">
                                                Pay Now
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            <?php echo $next2DayDate?>
                                         <input type="hidden" class="ServiceDate" name="Date" value="<?php echo $next2DayDate?>">  
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <div class="px-2 py-1" style="display:grid;">
                                                <div class="form-group" style="display:flex;justify-content: center;gap: 10px;" >
                                                    <input type="radio" id="CheckboxTime4-1" class="ServiceTime" name="Time" value="12:00pm - 12:30pm">  
                                                    <p class="text-xs text-secondary mb-0" for="CheckboxTime4-1">
                                                        <?php echo "12:00pm - 12:30pm" ?>
                                                    </p>
                                                </div>  
                                                <div class="form-group" style="display:flex;justify-content: center;gap: 10px;" >
                                                    <input type="radio" id="CheckboxTime4-2" class="ServiceTime" name="Time" value="01:00pm - 01:30pm">  
                                                    <p class="text-xs text-secondary mb-0" for="CheckboxTime4-2">
                                                        <?php echo "01:00pm - 01:30pm" ?>
                                                    </p>
                                                </div>  
                                                <div class="form-group" style="display:flex;justify-content: center;gap: 10px;" >
                                                    <input type="radio" id="CheckboxTime4-3" class="ServiceTime" name="Time" value="02:00pm - 02:30pm">  
                                                    <p class="text-xs text-secondary mb-0" for="CheckboxTime4-3">
                                                        <?php echo "02:00pm - 02:30pm" ?>
                                                    </p>
                                                </div>                                                
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <?php echo $Service['Duration'] ?> Minutes
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold"><?php echo $Service['Price'] ?> EGP</span>
                                         <input type="hidden" class="ServicePrice" name="ServicePrice" value="<?php echo $Service['Price'] ?>">  
                                        </td>
                                        <td class="align-middle">
                                            <button class="text-secondary font-weight-bold text-xs border-none ButtonServicePay"  data-original-title="Book">
                                                Pay Now
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            <?php echo $next3DayDate?>
                                             <input type="hidden" class="ServiceDate" name="Date" value="<?php echo $next3DayDate?>">  
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <div class="px-2 py-1" style="display:grid;">
                                                <div class="form-group" style="display:flex;justify-content: center;gap: 10px;" >
                                                    <input type="radio" id="CheckboxTime4-1"  class="ServiceTime" name="Time" value="12:00pm - 12:30pm">  
                                                    <p class="text-xs text-secondary mb-0" for="CheckboxTime4-1">
                                                        <?php echo "12:00pm - 12:30pm" ?>
                                                    </p>
                                                </div>  
                                                <div class="form-group" style="display:flex;justify-content: center;gap: 10px;" >
                                                    <input type="radio" id="CheckboxTime4-2"  class="ServiceTime" name="Time" value="01:00pm - 01:30pm">  
                                                    <p class="text-xs text-secondary mb-0" for="CheckboxTime4-2">
                                                        <?php echo "01:00pm - 01:30pm" ?>
                                                    </p>
                                                </div>  
                                                <div class="form-group" style="display:flex;justify-content: center;gap: 10px;" >
                                                    <input type="radio" id="CheckboxTime4-3"  class="ServiceTime" name="Time" value="02:00pm - 02:30pm">  
                                                    <p class="text-xs text-secondary mb-0" for="CheckboxTime4-3">
                                                        <?php echo "02:00pm - 02:30pm" ?>
                                                    </p>
                                                </div>                                                
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <?php echo $Service['Duration'] ?> Minutes
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold"><?php echo $Service['Price'] ?> EGP</span>
                                             <input type="hidden" class="ServicePrice" name="ServicePrice" value="<?php echo $Service['Price'] ?>">  
                                        </td>
                                        <td class="align-middle">
                                            <button   class="text-secondary font-weight-bold text-xs border-none ButtonServicePay" data-original-title="Book">
                                                Pay Now
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            <?php echo $next4DayDate?>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <div class="px-2 py-1" style="display:grid;">
                                                <div class="form-group" style="display:flex;justify-content: center;gap: 10px;" >
                                                    <input type="radio" id="CheckboxTime4-1" name="Time" value="12:00pm - 12:30pm">  
                                                    <p class="text-xs text-secondary mb-0" for="CheckboxTime4-1">
                                                        <?php echo "12:00pm - 12:30pm" ?>
                                                    </p>
                                                </div>  
                                                <div class="form-group" style="display:flex;justify-content: center;gap: 10px;" >
                                                    <input type="radio" id="CheckboxTime4-2" name="Time" value="01:00pm - 01:30pm">  
                                                    <p class="text-xs text-secondary mb-0" for="CheckboxTime4-2">
                                                        <?php echo "01:00pm - 01:30pm" ?>
                                                    </p>
                                                </div>  
                                                <div class="form-group" style="display:flex;justify-content: center;gap: 10px;" >
                                                    <input type="radio" id="CheckboxTime4-3" name="Time" value="02:00pm - 02:30pm">  
                                                    <p class="text-xs text-secondary mb-0" for="CheckboxTime4-3">
                                                        <?php echo "02:00pm - 02:30pm" ?>
                                                    </p>
                                                </div>                                                
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <?php echo $Service['Duration'] ?> Minutes
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold"><?php echo $Service['Price'] ?> EGP</span>
                                        </td>
                                        <td class="align-middle">
                                            <button class="text-secondary font-weight-bold text-xs border-none ButtonServicePay" data-original-title="Book">
                                                Pay Now
                                            </button>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section>
                <div id="calendar"></div>
            </section>
        <?php } ?>
        
        
        

<?php include "./Footer.php"; ?>

    <script>
        updateCartCount();
        // <!-- Calender -->
        // $(document).ready(function() {
        //     $('#calendar').fullCalendar({
        //         header: {
        //             left: 'prev,next today',
        //             center: 'title',
        //             right: 'month,agendaWeek,agendaDay,listWeek'
        //         },
        //         defaultDate: '2018-11-16',
        //         navLinks: true,
        //         eventLimit: true,
        //         events: [{
        //                 title: 'Front-End Conference',
        //                 start: '2018-11-16',
        //                 end: '2018-11-18'
        //             },
        //             {
        //                 title: 'Hair stylist with Mike',
        //                 start: '2018-11-20',
        //                 allDay: true
        //             },
        //             {
        //                 title: 'Car mechanic',
        //                 start: '2018-11-14T09:00:00',
        //                 end: '2018-11-14T11:00:00'
        //             },
        //             {
        //                 title: 'Dinner with Mike',
        //                 start: '2018-11-21T19:00:00',
        //                 end: '2018-11-21T22:00:00'
        //             },
        //             {
        //                 title: 'Chillout',
        //                 start: '2018-11-15',
        //                 allDay: true
        //             },
        //             {
        //                 title: 'Vacation',
        //                 start: '2018-11-23',
        //                 end: '2018-11-29'
        //             },
        //         ]
        //     });
        // });
$(document).ready(function () {  
    $(".ButtonServicePay").on('click', function () {
        const services = [];
        const ServiceTableForms = document.querySelectorAll('.ServiceTable');
        
        ServiceTableForms.forEach(form => {
        
            const rows = form.querySelectorAll('tr');
            rows.forEach(row => {
                const timeInputs = row.querySelectorAll('.ServiceTime');
        
                timeInputs.forEach(timeInput => {
                    if (timeInput.checked) {
                        const ServiceTime = timeInput.value;
                        const ServicePrice = row.querySelector('.ServicePrice').value;
                        const ServiceDate = row.querySelector('.ServiceDate').value;
                        // Push the checked time details into the services array
                        services.push({
                            date: ServiceDate,
                            time: ServiceTime,
                            price: ServicePrice,
                        });
                    }
                });
            });
        });
    
        let UserID = $('.UserID').val();
        $.ajax({
            url: 'https://zhome.com.eg/Front/Insert_Video_Call_Data.php',
            type: 'POST',
            data: {
                services: JSON.stringify(services), // Convert services array to JSON
                UserID: UserID
            },
            success: function (response) {
                if (response.trim() === "success") {
                    // Trigger checkoutService only when the response is "success"
                    $(".ButtonServicePay").on('click', function () {
                        checkoutService();
                    });
                } else {
                    // Handle other responses or errors
                    console.error('Error: ' + response);
                }
            },
            error: function (error) {
                // Handle error
                console.error('AJAX Error: ', error);
            }
        });
    });
});
    </script>
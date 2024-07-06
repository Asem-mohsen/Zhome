@extends('User.layout.master')

@section('Title', 'Interior Design')

@section('Css')
    <style>
        /* Navbar for specific pages */
        .header{
            border-bottom: 1px solid #eeee;
        }
        .menu .menu__inner .menu__item .menu__link , .nav-icon i{
            color: black
        }
        #Icons .separator {
            border-left: 1px solid black;
        }
        a.menu__link.JoinUsBtn {
            border: 1px solid #154352;
            color: black;
        }
        a.menu__link.JoinUsBtn:hover{
            color: white;
        }
        /* End */
        .wrapper{
            margin: 0 40px;
        }
        .room-boxs{
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .room-box-interior {
            position: relative;
            display: inline-block;
            border: 1px solid #eeee;
            border-radius: 10px;
            box-shadow: 0px 0px 5px 1px #eee;
            cursor: pointer;
        }
        .room-box-interior:hover{
            transition: ease-out 0.4s;
            box-shadow: 0px 0px 5px 1px #c1c1c1;
        }
        .room-box-interior.checked {
            border-color:#154352 !important;
        }
        .content.clearfix p.section-name{
            font-size: 30px;
            font-weight: 700;
            border-left: 10px solid #154352;
            padding-left: 20px;
        }
        .interior-img{
            padding: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 110px;
            height: 85px;
            object-fit: contain;
        }
        .room-box-interior .checkmark {
            display: none;
            position: absolute;
            top: 4px;
            right: 5px;
            background-color: #154352;
            font-size: 15px;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            justify-content: center;
            align-items: center;
        }

        .room-box-interior.checked .checkmark {
            display: flex;
        }

        .room-box-interior input[type="checkbox"] {
            display: none;
        }
        .steps.clearfix{
            display: none !important;
        }
        .wizard .content p {
            font-size: 15px;
            color: #030303;
        }
        .actions.clearfix{
            display: flex;
            justify-content: end;
            border-top: 1px solid #e0e0e0;
            padding-top: 30px;
            margin-top: 50px;
            margin-right: 30px;
        }

        /* bedrooms */
        .bedroom-boxes{
            gap: 10px;
            justify-content: left;
            height: 400px;
            overflow: scroll;
        }
        .bedroom-boxes .room-box-interior {
            border: 1px solid white;
            border-radius: 10px;
            box-shadow: none;
        }
        .bedroom-boxes .room-box-interior:hover {
            box-shadow: none;
        }
        .bedroom-boxes .interior-img {
            display: inline-block;
            padding: 0px;
            width: 210px;
            height: 100%;
            object-fit: contain;
            border-radius: 10px;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{asset('UI/css/bd-wizard.css')}}">
@endsection

@section('Content')

    <section class="mt-5 pt-5">
        <div class="wrapper">
            @include('User.Components.Msg')

            <form method="POST" id="MainForm" action="" enctype="multipart/form-data">
                @csrf
                <div id="wizard" class="mt-5 pt-5 p-0">

                    <h3>Step 1 Title</h3>
                    <section>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <p class="m-0 section-name">Which of these rooms do you want to furnish ?</p>
                            </div>
                            <div class="col-md-6">
                                <div class="room-boxs">

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="roomBox" id="bedroom" value="bedroom">
                                            <label class="m-0" for="bedroom">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/Rooms/4ISWTGCTDAkv5rfRHBGR0Hl1b8Mk5RiUjv1vdxkL.webp')}}" class="interior-img" width="100" alt="bedroom">
                                                <p class="mb-2 text-center">Bedrooms</p>
                                            </label>
                                        </div>

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="roomBox" id="living" value="Living Rooms">
                                            <label class="m-0" for="living">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/Rooms/QZwU6AbfmNe47C0UsCWKWLkTZ9XRRwKvBC1OM5Pg.webp')}}" class="interior-img" width="100" alt="bedroom">
                                                <p class="mb-2 text-center">Living Rooms</p>
                                            </label>
                                        </div>

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="roomBox" id="dinning" value="Dinning Rooms">
                                            <label class="m-0" for="dinning">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/Rooms/ERccbxLFHSQaWHXmmJFJ5KUmJ9wewLWHNOuHt5WY.webp')}}" class="interior-img" width="100" alt="bedroom">
                                                <p class="mb-2 text-center">Dinning Rooms</p>
                                            </label>
                                        </div>

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="roomBox" id="outdoor" value="Outdoor">
                                            <label class="m-0" for="outdoor">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/Rooms/rjREujfbU2zYbKBRwexSHoTUrGAS9AXEk7LMW3Za.webp')}}" class="interior-img" width="100" alt="bedroom">
                                                <p class="mb-2 text-center">Outdoor</p>
                                            </label>
                                        </div>

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="roomBox" id="office" value="Office">
                                            <label class="m-0" for="office">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/Rooms/1Ht8IAcvMxG9iomxBQF4dXtnay6HhQBKbP9KlRbH.webp')}}" class="interior-img" width="100" alt="bedroom">
                                                <p class="mb-2 text-center">Office</p>
                                            </label>
                                        </div>

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="roomBox" id="Kids" value="Kid's Room">
                                            <label class="m-0" for="Kids">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/Rooms/2I5Vx5C9rdMEJ29q3i3G6PmfRbEtwI4s3UVzUBvE.webp')}}" class="interior-img" width="100" alt="bedroom">
                                                <p class="mb-2 text-center">Kid's Room</p>
                                            </label>
                                        </div>

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="roomBox" id="Reception" value="Reception">
                                            <label class="m-0" for="Reception">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/Rooms/Oijb1zTmWOOCwDRAi9UUy4BD9JI85bvhriMR2GCL.webp')}}" class="interior-img" width="100" alt="bedroom">
                                                <p class="mb-2 text-center">Reception</p>
                                            </label>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <h3>Step 2 Title</h3>
                    <section>
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <p class="m-0 section-name">Select the rooms that you see yourself in</p>
                            </div>
                            <div class="col-md-7">
                                <div class="bedroom-boxes room-boxs">

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="bedrooms" id="6hdCwWvAK5Gplg8dLMKSJq1RjjbQQy0jYZxTPjhI" value="6hdCwWvAK5Gplg8dLMKSJq1RjjbQQy0jYZxTPjhI">
                                            <label class="m-0" for="6hdCwWvAK5Gplg8dLMKSJq1RjjbQQy0jYZxTPjhI">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/6hdCwWvAK5Gplg8dLMKSJq1RjjbQQy0jYZxTPjhI.webp')}}" class="interior-img" width="100" alt="bedroom">
                                            </label>
                                        </div>

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="bedrooms" id="7uHL8iyczMEm0AVIhE3iz9Wp9MciUlqlbp9HZCWD" value="7uHL8iyczMEm0AVIhE3iz9Wp9MciUlqlbp9HZCWD">
                                            <label class="m-0" for="7uHL8iyczMEm0AVIhE3iz9Wp9MciUlqlbp9HZCWD">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/7uHL8iyczMEm0AVIhE3iz9Wp9MciUlqlbp9HZCWD.webp')}}" class="interior-img" width="100" alt="bedroom">
                                            </label>
                                        </div>

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="bedrooms" id="C7b37UKsvsCy9d21C6FmF2OKhUOJD5daMiGAY8Pu" value="C7b37UKsvsCy9d21C6FmF2OKhUOJD5daMiGAY8Pu">
                                            <label class="m-0" for="C7b37UKsvsCy9d21C6FmF2OKhUOJD5daMiGAY8Pu">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/C7b37UKsvsCy9d21C6FmF2OKhUOJD5daMiGAY8Pu.webp')}}" class="interior-img" width="100" alt="bedroom">
                                            </label>
                                        </div>

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="bedrooms" id="ezjV8nIUbrtzuMNPgMAQVvcCBJKO4YDPXM5NbA5J" value="ezjV8nIUbrtzuMNPgMAQVvcCBJKO4YDPXM5NbA5J">
                                            <label class="m-0" for="ezjV8nIUbrtzuMNPgMAQVvcCBJKO4YDPXM5NbA5J">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/ezjV8nIUbrtzuMNPgMAQVvcCBJKO4YDPXM5NbA5J.webp')}}" class="interior-img" width="100" alt="bedroom">
                                            </label>
                                        </div>

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="bedrooms" id="fRHaDKWlycivBtRZ9xZgHIpaCuNRVmVsWJV80voX" value="fRHaDKWlycivBtRZ9xZgHIpaCuNRVmVsWJV80voX">
                                            <label class="m-0" for="fRHaDKWlycivBtRZ9xZgHIpaCuNRVmVsWJV80voX">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/fRHaDKWlycivBtRZ9xZgHIpaCuNRVmVsWJV80voX.webp')}}" class="interior-img" width="100" alt="bedroom">
                                            </label>
                                        </div>

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="bedrooms" id="gs5F2WCXePU7PBokYBUjHh7QpcN6KMXw4Q0znHt6" value="gs5F2WCXePU7PBokYBUjHh7QpcN6KMXw4Q0znHt6">
                                            <label class="m-0" for="gs5F2WCXePU7PBokYBUjHh7QpcN6KMXw4Q0znHt6">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/gs5F2WCXePU7PBokYBUjHh7QpcN6KMXw4Q0znHt6.webp')}}" class="interior-img" width="100" alt="bedroom">
                                            </label>
                                        </div>

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="bedrooms" id="q8reTqCd1eNhX4aE8xdhbQeTBKK78FMrvgmawQ3i" value="q8reTqCd1eNhX4aE8xdhbQeTBKK78FMrvgmawQ3i">
                                            <label class="m-0" for="q8reTqCd1eNhX4aE8xdhbQeTBKK78FMrvgmawQ3i">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/q8reTqCd1eNhX4aE8xdhbQeTBKK78FMrvgmawQ3i.webp')}}" class="interior-img" width="100" alt="bedroom">
                                            </label>
                                        </div>

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="bedrooms" id="tIukGsKyVYAB5wSKwsPfiinbKtrZTx8MuCStceCJ" value="tIukGsKyVYAB5wSKwsPfiinbKtrZTx8MuCStceCJ">
                                            <label class="m-0" for="tIukGsKyVYAB5wSKwsPfiinbKtrZTx8MuCStceCJ">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/tIukGsKyVYAB5wSKwsPfiinbKtrZTx8MuCStceCJ.webp')}}" class="interior-img" width="100" alt="bedroom">
                                            </label>
                                        </div>

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="bedrooms" id="UYhLcYZTsAIGbMDc7HENL743WnJcwMYROya8XTR6" value="UYhLcYZTsAIGbMDc7HENL743WnJcwMYROya8XTR6">
                                            <label class="m-0" for="UYhLcYZTsAIGbMDc7HENL743WnJcwMYROya8XTR6">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/UYhLcYZTsAIGbMDc7HENL743WnJcwMYROya8XTR6.webp')}}" class="interior-img" width="100" alt="bedroom">
                                            </label>
                                        </div>

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="bedrooms" id="VYpr7kDPhXjzrVp9GkOWwcdD7PSbFVbQjJCk7rhW" value="VYpr7kDPhXjzrVp9GkOWwcdD7PSbFVbQjJCk7rhW">
                                            <label class="m-0" for="VYpr7kDPhXjzrVp9GkOWwcdD7PSbFVbQjJCk7rhW">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/VYpr7kDPhXjzrVp9GkOWwcdD7PSbFVbQjJCk7rhW.webp')}}" class="interior-img" width="100" alt="bedroom">
                                            </label>
                                        </div>

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="bedrooms" id="ZdiF8IMJCOUyYzxGxuuI6bMOOAMXaHghHYgbs17I" value="ZdiF8IMJCOUyYzxGxuuI6bMOOAMXaHghHYgbs17I">
                                            <label class="m-0" for="ZdiF8IMJCOUyYzxGxuuI6bMOOAMXaHghHYgbs17I">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/ZdiF8IMJCOUyYzxGxuuI6bMOOAMXaHghHYgbs17I.webp')}}" class="interior-img" width="100" alt="bedroom">
                                            </label>
                                        </div>

                                        <div class="room-box-interior">
                                            <input type="checkbox" name="bedrooms" id="WWoGApI1MlHp6OiaMV4imvl6FuqwseLvdJhshhb9" value="WWoGApI1MlHp6OiaMV4imvl6FuqwseLvdJhshhb9">
                                            <label class="m-0" for="WWoGApI1MlHp6OiaMV4imvl6FuqwseLvdJhshhb9">
                                                <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/WWoGApI1MlHp6OiaMV4imvl6FuqwseLvdJhshhb9.webp')}}" class="interior-img" width="100" alt="bedroom">
                                            </label>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <h3>Step 3 Title</h3>
                    <section>
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <p class="m-0 section-name">Which of these furniture items do you love?</p>
                            </div>
                            <div class="col-md-7">
                                <div class="bedroom-boxes items-furniture">
                                    {{-- Chairs --}}
                                    <div class="row">
                                        <h4>Armchairs</h4>
                                        <div class="items-furniture-box">

                                            <div class="room-box-interior">
                                                <input type="checkbox" name="bedrooms" id="6hdCwWvAK5Gplg8dLMKSJq1RjjbQQy0jYZxTPjhI" value="6hdCwWvAK5Gplg8dLMKSJq1RjjbQQy0jYZxTPjhI">
                                                <label class="m-0" for="6hdCwWvAK5Gplg8dLMKSJq1RjjbQQy0jYZxTPjhI">
                                                    <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/6hdCwWvAK5Gplg8dLMKSJq1RjjbQQy0jYZxTPjhI.webp')}}" class="interior-img" width="100" alt="bedroom">
                                                </label>
                                            </div>

                                            <div class="room-box-interior">
                                                <input type="checkbox" name="bedrooms" id="6hdCwWvAK5Gplg8dLMKSJq1RjjbQQy0jYZxTPjhI" value="6hdCwWvAK5Gplg8dLMKSJq1RjjbQQy0jYZxTPjhI">
                                                <label class="m-0" for="6hdCwWvAK5Gplg8dLMKSJq1RjjbQQy0jYZxTPjhI">
                                                    <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/6hdCwWvAK5Gplg8dLMKSJq1RjjbQQy0jYZxTPjhI.webp')}}" class="interior-img" width="100" alt="bedroom">
                                                </label>
                                            </div>

                                            <div class="room-box-interior">
                                                <input type="checkbox" name="bedrooms" id="7uHL8iyczMEm0AVIhE3iz9Wp9MciUlqlbp9HZCWD" value="7uHL8iyczMEm0AVIhE3iz9Wp9MciUlqlbp9HZCWD">
                                                <label class="m-0" for="7uHL8iyczMEm0AVIhE3iz9Wp9MciUlqlbp9HZCWD">
                                                    <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/7uHL8iyczMEm0AVIhE3iz9Wp9MciUlqlbp9HZCWD.webp')}}" class="interior-img" width="100" alt="bedroom">
                                                </label>
                                            </div>

                                            <div class="room-box-interior">
                                                <input type="checkbox" name="bedrooms" id="C7b37UKsvsCy9d21C6FmF2OKhUOJD5daMiGAY8Pu" value="C7b37UKsvsCy9d21C6FmF2OKhUOJD5daMiGAY8Pu">
                                                <label class="m-0" for="C7b37UKsvsCy9d21C6FmF2OKhUOJD5daMiGAY8Pu">
                                                    <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/C7b37UKsvsCy9d21C6FmF2OKhUOJD5daMiGAY8Pu.webp')}}" class="interior-img" width="100" alt="bedroom">
                                                </label>
                                            </div>

                                            <div class="room-box-interior">
                                                <input type="checkbox" name="bedrooms" id="ezjV8nIUbrtzuMNPgMAQVvcCBJKO4YDPXM5NbA5J" value="ezjV8nIUbrtzuMNPgMAQVvcCBJKO4YDPXM5NbA5J">
                                                <label class="m-0" for="ezjV8nIUbrtzuMNPgMAQVvcCBJKO4YDPXM5NbA5J">
                                                    <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/ezjV8nIUbrtzuMNPgMAQVvcCBJKO4YDPXM5NbA5J.webp')}}" class="interior-img" width="100" alt="bedroom">
                                                </label>
                                            </div>

                                            <div class="room-box-interior">
                                                <input type="checkbox" name="bedrooms" id="fRHaDKWlycivBtRZ9xZgHIpaCuNRVmVsWJV80voX" value="fRHaDKWlycivBtRZ9xZgHIpaCuNRVmVsWJV80voX">
                                                <label class="m-0" for="fRHaDKWlycivBtRZ9xZgHIpaCuNRVmVsWJV80voX">
                                                    <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/fRHaDKWlycivBtRZ9xZgHIpaCuNRVmVsWJV80voX.webp')}}" class="interior-img" width="100" alt="bedroom">
                                                </label>
                                            </div>

                                            <div class="room-box-interior">
                                                <input type="checkbox" name="bedrooms" id="gs5F2WCXePU7PBokYBUjHh7QpcN6KMXw4Q0znHt6" value="gs5F2WCXePU7PBokYBUjHh7QpcN6KMXw4Q0znHt6">
                                                <label class="m-0" for="gs5F2WCXePU7PBokYBUjHh7QpcN6KMXw4Q0znHt6">
                                                    <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/BedRooms/gs5F2WCXePU7PBokYBUjHh7QpcN6KMXw4Q0znHt6.webp')}}" class="interior-img" width="100" alt="bedroom">
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </form>
        </div>
    </section>

@endsection


@section('Js')
    <script src="{{asset('UI/js/jquery.steps.min.js')}}"></script>
    <script src="{{asset('UI/js/bd-wizard.js')}}"></script>

<script>
    $(document).ready(function() {
        $('input[name="roomBox"]').change(function() {
            var $parentDiv = $(this).closest('.room-box-interior');

            if (this.checked) {
                $parentDiv.addClass('checked');
                $parentDiv.find('label').append('<span class="checkmark">&#10004;</span>');
            } else {
                $parentDiv.removeClass('checked');
                $parentDiv.find('.checkmark').remove();
            }
        });

        $('input[name="bedrooms"]').change(function() {
            var $parentDiv = $(this).closest('.room-box-interior');

            if (this.checked) {
                $parentDiv.addClass('checked');
                $parentDiv.find('label').append('<span class="checkmark">&#10004;</span>');
            } else {
                $parentDiv.removeClass('checked');
                $parentDiv.find('.checkmark').remove();
            }
        });
    });
</script>

@stop

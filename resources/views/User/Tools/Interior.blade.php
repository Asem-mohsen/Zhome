@extends('User.layout.master')

@section('Title', 'Interior Design')

@section('Css')
    <style>

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
            border-color:#154352; /* Customize the border style as needed */
        }
        p.section-name{
            font-size: 30px;
        }
        .interior-img{
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 125px;
            height: 90px;
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
    </style>
@endsection

@section('Content')

    <section class="mt-5 pt-5">
        <div class="wrapper">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="fw-bold m-0 section-name">Which of these rooms do you want to furnish ?</p>
                </div>
                <div class="col-md-6">
                    <div class="room-boxs">
                        
                            <div class="room-box-interior">
                                <input type="checkbox" name="roomBox" id="bedroom" value="bedroom">
                                <label class="m-0" for="bedroom">
                                    <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/4ISWTGCTDAkv5rfRHBGR0Hl1b8Mk5RiUjv1vdxkL.webp')}}" class="interior-img" width="100" alt="bedroom">
                                    <p class="mb-2 text-center">Bedrooms</p>
                                </label>
                            </div>
                            
                            <div class="room-box-interior">
                                <input type="checkbox" name="roomBox" id="living" value="Living Rooms">
                                <label class="m-0" for="living">
                                    <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/QZwU6AbfmNe47C0UsCWKWLkTZ9XRRwKvBC1OM5Pg.webp')}}" class="interior-img" width="100" alt="bedroom">
                                    <p class="mb-2 text-center">Living Rooms</p>
                                </label>
                            </div>

                            <div class="room-box-interior">
                                <input type="checkbox" name="roomBox" id="dinning" value="Dinning Rooms">
                                <label class="m-0" for="dinning">
                                    <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/ERccbxLFHSQaWHXmmJFJ5KUmJ9wewLWHNOuHt5WY.webp')}}" class="interior-img" width="100" alt="bedroom">
                                    <p class="mb-2 text-center">Dinning Rooms</p>
                                </label>
                            </div>

                            <div class="room-box-interior">
                                <input type="checkbox" name="roomBox" id="outdoor" value="Outdoor">
                                <label class="m-0" for="outdoor">
                                    <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/rjREujfbU2zYbKBRwexSHoTUrGAS9AXEk7LMW3Za.webp')}}" class="interior-img" width="100" alt="bedroom">
                                    <p class="mb-2 text-center">Outdoor</p>
                                </label>
                            </div>

                            <div class="room-box-interior">
                                <input type="checkbox" name="roomBox" id="office" value="Office">
                                <label class="m-0" for="office">
                                    <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/1Ht8IAcvMxG9iomxBQF4dXtnay6HhQBKbP9KlRbH.webp')}}" class="interior-img" width="100" alt="bedroom">
                                    <p class="mb-2 text-center">Office</p>
                                </label>
                            </div>

                            <div class="room-box-interior">
                                <input type="checkbox" name="roomBox" id="Kids" value="Kid's Room">
                                <label class="m-0" for="Kids">
                                    <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/2I5Vx5C9rdMEJ29q3i3G6PmfRbEtwI4s3UVzUBvE.webp')}}" class="interior-img" width="100" alt="bedroom">
                                    <p class="mb-2 text-center">Kid's Room</p>
                                </label>
                            </div>

                            <div class="room-box-interior">
                                <input type="checkbox" name="roomBox" id="Reception" value="Reception">
                                <label class="m-0" for="Reception">
                                    <img src="{{asset('Admin/dist/img/web/Tools/InteriorDesign/Oijb1zTmWOOCwDRAi9UUy4BD9JI85bvhriMR2GCL.webp')}}" class="interior-img" width="100" alt="bedroom">
                                    <p class="mb-2 text-center">Reception</p>
                                </label>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection


@section('Js')
<script>
    $(document).ready(function() {
        $('input[name="roomBox"]').change(function() {
            var $parentDiv = $(this).closest('.room-box-interior');
            
            if (this.checked) {
                $parentDiv.addClass('checked');
                $parentDiv.find('label').append('<span class="checkmark">&#10004;</span>'); // Add check mark
            } else {
                $parentDiv.removeClass('checked');
                $parentDiv.find('.checkmark').remove(); // Remove check mark
            }
        });
    });
</script>

@stop
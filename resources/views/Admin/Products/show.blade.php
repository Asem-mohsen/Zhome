@extends('Admin.Layout.Master')
@section('Title' , $product->Name)
@section('Content')

@include('Admin.Components.Msg')

    <div class="container-fluid py-4 product-page">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 overflow-hidden h-auto">
                    <!-- Details -->
                    <section class="product-details">
                        <div class="control-buttons d-flex justify-content-center pt-3 pb-3">
                                <a href="{{route('Products.edit' , $product->ID)}}" class="btn btn-success"> Edit </a>
                                <form action="{{ route('Products.delete' , $product->ID) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"> Delete </button>
                                </form>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="product-details__image d-flex justify-content-center">
                                    <img class="img-fluid" src="{{ asset("Admin/dist/img/web/Products/MainImage/".$product->MainImage)}}" width="500px" style="max-height: 493px;" alt="{{$product->Name}}" />
                                    <a href="#" class="product-details__img-popup img-popup">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </div>

                                <div class="additional-images d-flex justify-content-center p-3">
                                    @foreach ($product->images as $image)
                                        <div class="additional-image m-2">
                                            <img class="img-fluid h-100" src="{{ asset("Admin/dist/img/web/Products/OtherImages/$image->Image") }}" style="width:130px;object-fit: cover;" alt="{{$product->Name}}" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="product-details__content">
                                        <h3 class="product-details__title">{{$product->Name}}</h3>
                                        @if($product->sale != NULL)
                                            <p class="product-details__price">{{ $product->sale->PriceAfter . " EGP"}}</p>
                                            <p class="product-details__price" style="text-decoration: line-through; font-size:19px">{{ $product->Price . " EGP"}}</p>
                                        @else
                                            <p class="product-details__price">{{ $product->Price . " EGP"}}</p>
                                        @endif

                                        <p class="product-details__text" style="margin-right: 55px;">
                                            {{ $product->Description }}
                                        </p>
                                        <p class="product-details__categories">
                                            <span class="text-uppercase">Category : </span>
                                            <a href="{{route('Category.show' , $product->subcategory->category->ID )}}">
                                                {{ $product->subcategory->category->Category }}
                                            </a>
                                                    </br>
                                            <span class="text-uppercase">Sub Category : </span>
                                            <a href="{{route('Category.Subcategory.edit' , $product->subcategory->ID )}}">
                                                {{ $product->subcategory->SubName }}
                                            </a>
                                                    </br>
                                            <span class="text-uppercase">Brand : </span>
                                            <a href="{{route('Brands.edit' , $product->brand->ID )}}">
                                                {{ $product->brand->Brand }}
                                            </a>
                                        </p>
                                        <p class="product-details__availabelity">
                                            <span>Availability:</span>
                                            {{ $product->Quantity  . " In Stock"}}
                                        </p>
                                        <h4 class="mt-5 mb-5">Platforms</h4>
                                        <div class="Product-Platforms">
                                            @foreach($product->platforms as $Platform)
                                                        <a href="{{route('Platform.edit' , $Platform->ID )}}">
                                                            <div class="platform">
                                                                <img src="{{ asset("Admin/dist/img/web/Platforms/{$Platform->Logo}") }}" alt="{{$Platform->Platform}}">
                                                                <p>{{$Platform->Platform}}</p>
                                                            </div>
                                                        </a>
                                            @endforeach
                                        </div>
                                </div>
                            </div>
                            <hr class="separator mt-5 mb-5">

                            <div class="col-lg-12">
                                <div class="container">
                                    <h2 class="ProductDetails-Text mb-5 ml-4">
                                        {{$product->productDetails->Title}}
                                    </h2>
                                    <div class="Images-ProductsDetails">
                                        <div class="Image-One-ProductDetails fadeInUp">
                                            <img src="{{ asset("Admin/dist/img/web/Products/CoverImage/".$product->productDetails->CoverImage) }}" alt="Cover Image">
                                        </div>
                                    </div>
                                    <div class="Text-under-images-ProductDetails pt-5 mt-5">
                                        <div class="text-one-ProductDetails">
                                            <div class="top-text">
                                                <img src="{{ asset("Admin/dist/img/web/Brands/".$product->brand->Logo) }}" alt="{{$product->brand->Brand}}">
                                                <h3>Brand</h3>
                                            </div>
                                            <div class="bottom-text">
                                                <p>
                                                    {{$product->Name . ' is a ' . $product->brand->Brand . ' Brand'}}
                                                </p>
                                            </div>

                                        </div>
                                        <div class="text-one-ProductDetails">
                                            <div class="top-text">
                                            <i class="fa-solid fa-folder"></i>
                                            <h3>Platform</h3>
                                            </div>
                                            <div class="bottom-text">
                                                <div class="Product-Platforms w-100">
                                                    @foreach($product->platforms as $Platform)
                                                        <a href="{{route('Platform.edit' , $Platform->ID )}}">
                                                            <div class="platform">
                                                                <img src="{{ asset("Admin/dist/img/web/Platforms/$Platform->Logo") }}" alt="{{$Platform->Platform}}">
                                                                <p>{{$Platform->Platform}}</p>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @if($product->InstallationCost != NULL || $product->InstallationCost != 0)
                                            <div class="text-one-ProductDetails">
                                                <div class="top-text">
                                                    <i class="fa-solid fa-gears"></i>
                                                    <h3>Professional installation</h3>
                                                </div>
                                                <div class="bottom-text">
                                                    <p>
                                                        Available for the professional installation with only {{$product->InstallationCost . ' EGP'}}.
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="text-one-ProductDetails">
                                            <div class="top-text">
                                                <i class="fa-solid fa-house-signal"></i>
                                                <h3>Technology</h3>
                                            </div>
                                            <div class="bottom-text">
                                                <p>
                                                    @foreach ($product->technologies as $technology)
                                                        @php
                                                            $technologyArray[] = $technology['Technology'];
                                                        @endphp
                                                    @endforeach
                                                        @php
                                                            $technologyCount = count($technologyArray);
                                                        @endphp
                                                    @for ($i = 0; $i < $technologyCount; $i++)
                                                            {{$technologyArray[$i]}}
                                                            @if($i < $technologyCount - 1)
                                                                {{'-'}}
                                                            @endif
                                                    @endfor
                                                </p>
                                            </div>
                                        </div>
                                            @foreach($product->features as $feature)
                                                <div class="text-one-ProductDetails">
                                                    <div class="top-text">
                                                        <img src="{{asset('Admin/dist/img/photo3.jpg')}}" alt="{{$feature->Feature}}">
                                                        <h3>{{$feature->Feature}}</h3>
                                                    </div>
                                                    <div class="bottom-text">
                                                        <p>
                                                            {{$feature->Description}}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Expert Review -->
                            <div class="ExpertReview m-auto mt-5">
                                <div class="product-details__review-form">
                                    <h2 class="mb-3 text-center">Expert Review</h2>
                                    <!-- Reviews -->
                                    <div class="product-details__review w-75 m-auto">
                                        <div class="product-details__review-left d-flex">
                                            <img src="{{asset('Admin/dist/img/avatar2.png')}}" width="70px" height="70px" alt="Image" />
                                            <div class="d-flex flex-column pl-2">
                                                <h4 class="product-details__review-title">{{ $product->evaluations->admin->Name }}</h4>
                                                <span class="product-details__review-date text-sm">- <?php echo "Expert engineer" ?></span>
                                            </div>

                                        </div>
                                        <div class="product-details__review-right">
                                            <p class="product-details__review-text mt-3">{{$product->evaluations->Evaluation}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Product Part 2 -->
                        <div class="row" style="margin-top: 116px;">
                            <div class="col-lg-6">
                                <div class="product-details__content ProductDetails_Section_last">
                                    <h3 class="product-details__title"> {{ $product->productDetails->Title2}}</h3>
                                    <ul>
                                        <li>
                                            <span><i class="fa-solid fa-check"></i></span>
                                            <p>{{ $product->brand->Brand . "Brand" }}</p>
                                        </li>
                                        <li>
                                            <span><i class="fa-solid fa-check"></i></span>
                                            <p>
                                                Compitable with
                                                @foreach($product->platforms as $Platform)
                                                    <p>{{$Platform->Platform}}</p>
                                                @endforeach
                                            </p>
                                        </li>
                                        @foreach($product->features as $feature)
                                            <li>
                                                <span><i class="fa-solid fa-check"></i></span>
                                                <p>{{$feature->Feature}}</p>
                                            </li>
                                        @endforeach
                                        <li>
                                            <span><i class="fa-solid fa-check"></i></span>
                                            <p>Free Transportation</p>
                                        </li>
                                        @if($product->InstallationCost != NULL || $product->InstallationCost != 0)
                                            <li>
                                                <span><i class="fa-solid fa-check"></i></span>
                                                <p>Available for installation with only {{ $product->InstallationCost . 'EGP'}}</p>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="product-details__image LastProductDetails">
                                    <img class="img-fluid" src="{{asset('Admin/dist/img/web/Products/MainImage/'.$product->MainImage)}}" alt="MainImage" />
                                </div>
                            </div>
                        </div>
                    </section>

                    <!--FAQ , Video and Description-->
                    <section class="product-details">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="product-details__content">
                                        <div class="accrodion-grp" id="accordion" data-grp-name="product-details__accrodion">
                                            <div class="card card-primary card-outline">
                                                <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                                                    <div class="card-header">
                                                        <h4 class="card-title w-100">
                                                            Product Description
                                                        </h4>
                                                    </div>
                                                </a>
                                                <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div id="Description">
                                                            <div class="inner">
                                                                <div class="product-details__review-form">
                                                                    <!-- Description -->
                                                                    <div class="Product-spacification">
                                                                        <div class="container">
                                                                            <div class="Details">
                                                                                <h5>Capacity</h5>
                                                                                <div class="Details-info">
                                                                                    <p>Capacity(m)</p>
                                                                                    <span>{{ $product->productDetails->Capacity . 'm'}}</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Details">
                                                                                <h5>Noise Level</h5>
                                                                                <div class="Details-info">
                                                                                    <p>Noise(dBA)</p>
                                                                                    <span>50 dBA</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Details">
                                                                                <h5>Physical Specification</h5>
                                                                                <div class="many-details">
                                                                                    <div class="Details-info">
                                                                                        <p>Net Dimension(WxHxD)</p>
                                                                                        <span>{{ $product->productDetails->Width . 'x' . $product->productDetails->Height .  'x' . $product->productDetails->Length}}</span>
                                                                                    </div>
                                                                                    <div class="Details-info">
                                                                                        <p>Net Weight(kg)</p>
                                                                                        <span>{{ $product->productDetails->Weight . 'KG'}}</span>
                                                                                    </div>
                                                                                    <div class="Details-info">
                                                                                        <p>Color</p>
                                                                                        <div class="Colorsdiv">
                                                                                            @if($product->productDetails->Color)
                                                                                                <span class="color" style="background-color:{{ $product->productDetails->Color }}">
                                                                                                </span>
                                                                                            @elseif ($product->productDetails->Color2)
                                                                                                <span class="color" style="background-color:{{ $product->productDetails->Color2 }}">
                                                                                                </span>
                                                                                            @elseif ($product->productDetails->Color3)
                                                                                                <span class="color" style="background-color:{{ $product->productDetails->Color3 }}">
                                                                                                </span>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Details">
                                                                                <h5>Air Purification</h5>
                                                                                <div class="many-details">
                                                                                    <div class="Details-info">
                                                                                        <p>Indcator(cleanliness)</p>
                                                                                        <span>{{ $product->productDetails->AirPurification }}</span>
                                                                                    </div>
                                                                                    <div class="Details-info">
                                                                                        <p>Pre Filter</p>
                                                                                        <span>
                                                                                            @if( $product->productDetails->PreFilter == 1)
                                                                                                    {{'Yes'}}
                                                                                            @else
                                                                                                    {{'No'}}
                                                                                            @endif
                                                                                        </span>
                                                                                    </div>
                                                                                    <div class="Details-info">
                                                                                        <p>Dust Collecting</p>
                                                                                        <span> {{ $product->productDetails->DustCollecting == 1 ? 'Yes' : 'No' }}</span>
                                                                                    </div>
                                                                                    <div class="Details-info">
                                                                                        <p>Deodorizing Filter</p>
                                                                                        <span>{{ $product->productDetails->DeodorizingFilter == 1 ? 'Yes' : 'No' }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Details">
                                                                                <h5>Electrical Date</h5>
                                                                                <div class="Details-info">
                                                                                    <p>Power Consumption(W)</p>
                                                                                    <span>{{ $product->productDetails->PowerConsumption .' W' }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Tech details -->
                                            <div class="card card-primary card-outline">
                                                <a class="d-block w-100" data-toggle="collapse" href="#Tech">
                                                    <div class="card-header">
                                                        <h4 class="card-title w-100">
                                                            Technical Details
                                                        </h4>
                                                    </div>
                                                </a>
                                                <div id="Tech" class="collapse show" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div id="FAQ">
                                                            <div class="inner">
                                                                <div class="product-details__review-form" style="margin-top: 33px;">
                                                                    <!-- FAQ -->
                                                                    <div class="product-details__review" style="margin-bottom: 40px;">
                                                                        @foreach ($product->faqs as $faq)
                                                                            <div class="product-details__review-single" style="padding: 1px 30px;border:none;justify-content: left;">
                                                                                <div class="product-details__review-right">
                                                                                    <div class="FAQ"  style="gap: 0px;">
                                                                                        <div class="Question">
                                                                                            {{ ucfirst(strtolower($faq->Question)) }}
                                                                                        </div>
                                                                                        <div class="Answer">
                                                                                            <p class="product-details__review-text" style="margin-bottom: 20px;"> {{ ucfirst(strtolower($faq->Answer)) }}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Video -->
                                            <div class="card card-primary card-outline">
                                                <a class="d-block w-100" data-toggle="collapse" href="#Video">
                                                    <div class="card-header">
                                                        <h4 class="card-title w-100">
                                                            Video
                                                        </h4>
                                                    </div>
                                                </a>
                                                <div id="Video" class="collapse show" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div id="Video">
                                                            <div class="inner">
                                                                <div class="product-details__review-form" style="text-align-last: center;">
                                                                    <!-- Video -->
                                                                    <div class="product-details__review" style="margin-bottom: 40px;">
                                                                        <video style="width: 70%;align-self: center;height: 390px;" controls>
                                                                            <source src="{{$product->productDetails->Video}}" type="video/mp4">
                                                                        </video>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

@endsection

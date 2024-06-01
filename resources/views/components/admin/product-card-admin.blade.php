<div class="item product-one__single" style="height:390px" id="Product-{{ $variable->ID }}">
    <div class="product-one__image">
        <img src="{{ asset('Admin/dist/img/web/Products/MainImage/' . $variable->MainImage) }}" height="270px" alt="{{$variable->Name}}" />
    </div>
    <div class="product-one__content">
        <div class="product-one__content-left">
            <h3 class="product-one__title">
                <a href="{{ route('Products.show', $variable->ID) }}">{{ ucfirst(strtolower($variable->Name)) }}</a>
            </h3>
            <p class="description-product">
                {{ 'Brand: ' . $variable->brand->Brand }} <br>
                <div class="d-flex gap-1">
                    @foreach ($variable->platforms as $platform)
                        <a href="{{ route('Platform.edit' , $platform->ID ) }}" title="{{ $platform->Platform . " Platform" }}">
                            <img src="{{ asset('Admin/dist/img/web/Platforms/' . $platform->Logo) }}" class="Platform-flex-img">
                        </a>
                    @endforeach
                </div>
            </p>
            <div class="product-one__content-right d-flex align-items-center justify-content-between">
                @if($countSale > 0)
                    <div class="d-grid gap-1">
                        <p class="product-one__text">{{ $priceSale->PriceAfter . ' EGP' }}</p>
                        <p class="product-one__text" style="text-decoration: line-through; font-size:14px">{{ $variable->Price . ' EGP' }}</p>
                    </div>
                @else
                    <p class="product-one__text">{{ $variable->Price . ' EGP' }}</p>
                @endif
                @if($variable->Quantity <= 0)
                    <p class="OutStock">{{ __('OutofStock') }}</p>
                @else
                    <a href="{{ route('Products.show' , $variable->ID)}}" data-placement="top" class="product-one__cart-btn"><i class="fa-solid fa-search text-white"></i></a>
                @endif
            </div>
        </div>
    </div>
</div>

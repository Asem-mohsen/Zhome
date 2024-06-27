<div class="col-4 col-md-4 col-lg-2 FilterTransform MainFilter">
    <div class="shop_sidebar_area">
        <!-- Categories -->
        <div class="widget catagory">
            <div class="nav-side-menu">
                <a class="nav-link" data-bs-toggle="collapse" href="#CategoryExamples" role="button" aria-expanded="true" id="CategoryExamplesButton">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 nav-link-text">{{ __('messages.Categories') }}</h6>
                        <i class="fa-solid fa-chevron-down text-dark text-sm opacity-10"></i>
                    </div>
                </a>
                <div class="collapse collapsing menu-list checkbox-list" id="CategoryExamples">
                    @foreach($categories as $category)
                        <label for="Category{{ $category->ID }}" class="checkbox CategoryCheckBox">
                            <input type="checkbox" id="Category{{ $category->ID }}" class="CategoryCheckInput" name="category[]" value="{{ $category->ID }}" {{ isset($currentFilters['CategoryIDs']) && in_array($category->ID, $currentFilters['CategoryIDs']) ? 'checked' : '' }}>
                            {{ app()->getLocale() == 'ar' ? $category->ArabicName : $category->Category }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Brands --}}
        <div class="widget catagory ">
            <div class="nav-side-menu">
                <a class="nav-link" data-bs-toggle="collapse" aria-controls="BrandsExamples" role="button" href="#BrandsExamples" aria-expanded="true" id="BrandsExamplesButton">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 nav-link-text">{{ __('messages.Brands') }}</h6>
                      <i class="fa-solid fa-chevron-down text-dark text-sm text-sm opacity-10"></i>
                    </div>
                  </a>
                <div class="collapse collapsing menu-list checkbox-list" id="BrandsExamples">
                    @foreach($brands as $brand)
                        <label for="Brand{{ $brand->ID }}" class="checkbox BrandsCheckBox">
                            <input type="checkbox" class="BrandCheckInput" id="Brand{{ $brand->ID }}" name="brand[]" value="{{ $brand->ID }}" {{ isset($currentFilters['BrandIDs']) && in_array($brand->ID, $currentFilters['BrandIDs']) ? 'checked' : '' }}>
                            <img src="{{asset("Admin/dist/img/web/Brands/$brand->Logo")}}" alt="{{ $brand->Brand }} ">
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="widget catagory">
            <div class="nav-side-menu">
                  <a class="nav-link" data-bs-toggle="collapse" aria-controls="PlatformsExamples" role="button" href="#PlatformsExamples" aria-expanded="true" id="PlatformsExamplesButton">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 nav-link-text">{{ __('messages.Platforms') }}</h6>
                      <i class="fa-solid fa-chevron-down text-dark text-sm text-sm opacity-10"></i>
                    </div>
                  </a>
                <div class="collapse collapsing checkbox-list" id="PlatformsExamples">
                    @foreach($platforms as $platform)
                        <label for="Platform{{$platform->ID}}" class="checkbox PlatformCheckBox">
                            <input type="checkbox" id="Platform{{$platform->ID}}" class="PlatformCheckInput" name="platform[]" value="{{$platform->ID}}"  {{ isset($currentFilters['PlatformIDs']) && in_array($platform->ID, $currentFilters['PlatformIDs']) ? 'checked' : '' }}>
                            <img src="{{asset("Admin/dist/img/web/Platforms/$platform->Logo")}}" alt="{{$platform->Platform}}">
                            {{$platform->Platform}}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Technologies -->
        <div class="widget catagory">
            <div class="nav-side-menu">
                <a class="nav-link" data-bs-toggle="collapse" aria-controls="TechnologiesExamples" role="button" href="#TechnologiesExamples" aria-expanded="true" id="TechnologiesExamplesButton" >
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 nav-link-text">{{ __('messages.Technologies') }}</h6>
                    <i class="fa-solid fa-chevron-down  text-dark text-sm text-sm opacity-10"></i>
                    </div>
                </a>
                <div class="collapse collapsing checkbox-list" id="TechnologiesExamples">
                    @foreach($technologies as $technology)
                        <label for="{{$technology}}" class="checkbox TechCheckBox">
                            <input type="checkbox" id="{{$technology}}" class="TechCheckInput" name="technology[]" value="{{$technology}}" {{ isset($currentFilters['TechnologyIDs']) &&  in_array($technology, $currentFilters['TechnologyIDs']) ? 'checked' : '' }}>
                            {{$technology}}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Price Range -->
        <div class="widget price mb-50">
            <h6 class="widget-title mb-30">{{ __('messages.FilterbyPrice') }}</h6>
            <div class="widget-desc">
                <div class="slider-range">
                    <div data-min="{{ $minPrice }}" data-max="{{ $maxPrice }}" data-unit="$" class="slider-range-price ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" data-value-min="{{ $minPrice }}" data-value-max="{{ $maxPrice }}" data-label-result="Price:">
                        <div class="ui-slider-range ui-widget-header ui-corner-all"></div>
                        <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                        <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                    </div>
                    <div class="range-price">{{ __('messages.Price') }} <span id="price-range">{{ $minPrice }} - {{ $maxPrice }}</span></div>
                </div>
            </div>
        </div>

        <div class="FiltersButton">
            <button id="applyFilterBtn">{{ __('messages.ApplyFilter') }}</button>
            <button id="Reset" type="reset" title="{{ __('messages.ResetChoices') }}"><i class="fa-solid fa-rotate-right"></i></button>
        </div>
        
    </div>
</div>

<script>
    let filterUrl = "{{ route('Shop.FilterIndex') }}?" ;
</script>

@extends('frontend.app')
@push('specific_css')
    <link href="{{ asset('assets/frontend/css/listing.css') }}" rel="stylesheet">
@endpush
@section('content')
<main>
        <div id="stick_here"></div>		
        <div class="toolbox elemento_stick">
            <div class="container">
                <div class="collapse" id="filters">
                    <div class="row small-gutters filters_listing_1"></div>
                </div>
            </div>
        </div>
        <!-- /toolbox -->

        <div class="container margin_30">
        <div class="row small-gutters">
            @foreach($ebooks as $ebook)
            <div class="col-6 col-md-4 col-xl-3">
                <div class="grid_item">
                    <figure>
                        <a href="{{route('ebook.user_show',$ebook->id)}}">
                            <img class="img-fluid lazy" src="{{asset('storage/' . $ebook->thumbnail)}}" data-src="{{asset('storage/' . $ebook->thumbnail)}}" style="width: 336px;height: 336px;" alt="">
                            <img class="img-fluid lazy" src="{{asset('storage/' . $ebook->thumbnail)}}" data-src="{{asset('storage/' . $ebook->thumbnail)}}" style="width: 336px;height: 336px;" alt="">
                        </a>
                    </figure>
                    <div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
                    <a href="{{route('ebook.user_show',$ebook->id)}}">
                        <h3>{{ $ebook->title }}</h3>
                    </a>
                    <div class="price_box">
                        <a href="{{route('ebook.user_show',$ebook->id)}}" class="new_price">Rp {{ number_format($ebook->price, 2, ',', '.') }}</a>
                    </div>
                    <ul>
                        <li><a href="javascript:void(0)" class="tooltip-1 cart_book" data-id="{{ $ebook->id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to cart" onclick="add_to_cart(this)"><i class="ti-shopping-cart"></i><span>Add to cart</span></a></li>
                    </ul>
                </div>
                <!-- /grid_item -->
            </div>
        @endforeach
        </div>
        <!-- /row -->
        <div class="pagination__wrapper">
            {{ $ebooks->links('vendor.pagination.custom') }}
        </div>
            
    </div>
    <!-- /container -->
</main>
<!-- /main -->
@endsection
@push('specific_scripts')
    <script  src="{{asset('assets/frontend/js/sticky_sidebar.min.js')}}"></script>
    <script  src="{{asset('assets/frontend/js/specific_listing.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@push('scripts')
    
@endpush

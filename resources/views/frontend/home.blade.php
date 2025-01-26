@extends('frontend.app')
@push('specific_css')
    <link href="{{ asset('assets/frontend/css/home_1.css') }}" rel="stylesheet">
@endpush
@section('content')
<main>
    <div id="carousel-home">
    {{-- <div class="owl-carousel owl-theme">
        <div class="owl-slide cover" style="background-image: url({{ asset('assets/frontend/img/slides/slide_home_2.jpg') }});">
            <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <div class="row justify-content-center justify-content-md-end">
                        <div class="col-lg-6 static">
                            <div class="slide-text text-end white">
                                <h2 class="owl-slide-animated owl-slide-title">Attack Air<br>Max 720 Sage Low</h2>
                                <p class="owl-slide-animated owl-slide-subtitle">
                                    Limited items available at this price
                                </p>
                                <div class="owl-slide-animated owl-slide-cta"><a class="btn_1" href="listing-grid-1-full.html" role="button">Shop Now</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/owl-slide-->
        <div class="owl-slide cover" style="background-image: url({{ asset('assets/frontend/img/slides/slide_home_1.jpg') }});">
            <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <div class="row justify-content-center justify-content-md-start">
                        <div class="col-lg-6 static">
                            <div class="slide-text white">
                                <h2 class="owl-slide-animated owl-slide-title">Attack Air<br>VaporMax Flyknit 3</h2>
                                <p class="owl-slide-animated owl-slide-subtitle">
                                    Limited items available at this price
                                </p>
                                <div class="owl-slide-animated owl-slide-cta"><a class="btn_1" href="listing-grid-1-full.html" role="button">Shop Now</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/owl-slide-->
        <div class="owl-slide cover" style="background-image: url({{ asset('assets/frontend/img/slides/slide_home_3.jpg') }});">
            <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(255, 255, 255, 0.5)">
                <div class="container">
                    <div class="row justify-content-center justify-content-md-start">
                        <div class="col-lg-12 static">
                            <div class="slide-text text-center black">
                                <h2 class="owl-slide-animated owl-slide-title">Attack Air<br>Monarch IV SE</h2>
                                <p class="owl-slide-animated owl-slide-subtitle">
                                    Lightweight cushioning and durable support with a Phylon midsole
                                </p>
                                <div class="owl-slide-animated owl-slide-cta"><a class="btn_1" href="listing-grid-1-full.html" role="button">Shop Now</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/owl-slide-->
        </div>
    </div> --}}
    <div id="icon_drag_mobile"></div>
</div>
<!--/carousel-->

<div class="container margin_60_35">
    <div class="main_title">
        <h2>Newest eBooks</h2>
        <span>Ebooks</span>
        <p>Unlock a World of Knowledge.</p>
    </div>
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
                    <a href="javascript:void(0)">
                        <h3>{{ $ebook->title }}</h3>
                    </a>
                    <div class="price_box">
                        <span class="new_price">Rp {{ number_format($ebook->price, 2, ',', '.') }}</span>
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
</div>
<!-- /container -->
</main>
@endsection
@push('specific_scripts')
    <script src="{{ asset('assets/frontend/js/carousel-home.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@push('scripts')
    <script>
        function add_to_cart(element){
            const $cartBookElement = $(element);
            const ebookId = $cartBookElement.data('id');
            $.ajax({
                url: `{{ route('cart.store') }}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id:ebookId
                },
                success: function(response) {

                    $('#count_cart').text(response.cart_count)
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1000
                    });
                },
                error: function(xhr) {
                    if(xhr.status == 401){
                        window.location.href="{{ route('login') }}"
                    }else{
                        Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: xhr.responseJSON.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    }

                }
            });
        }
    </script>
@endpush

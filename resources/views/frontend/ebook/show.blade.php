@extends('frontend.app')
@push('specific_css')
    <link href="{{ asset('assets/frontend/css/product_page.css') }}" rel="stylesheet">
@endpush
@section('content')
    <main>
        <div class="container margin_30">
            <div class="row">
                <div class="col-md-6">
                    <div class="all">
                        <div class="slider">
                            <div class="owl-carousel owl-theme main">
                                <div style="background-image: url({{asset('storage/' . $ebook->thumbnail)}});" class="item-box"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="{{route('home')}}">Home</a></li>
                            <li><a href="#">Ebooks</a></li>
                            <li>Detail</li>
                        </ul>
                    </div>
                    <!-- /page_header -->
                    <div class="prod_info">
                        <h1>{{$ebook->title}}</h1>
                        <span class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i><em>4 reviews</em></span>
                        <p><small>{{$ebook->author}}</small><br>{{$ebook->description}}</p>
                        <div class="prod_options">
                            <div class="row">
                                <label class="col-xl-5 col-lg-5  col-md-6 col-6"><strong>Quantity</strong></label>
                                <div class="col-xl-4 col-lg-5 col-md-6 col-6">
                                    <div class="numbers-row">
                                        <input type="text" value="1" id="quantity" class="qty2" name="quantity">
                                        <div class="inc button_inc">+</div><div class="dec button_inc">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5 col-md-6">
                                <div class="price_main"><span class="new_price">Rp {{ number_format($ebook->price, 2, ',', '.') }}</span></div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="btn_add_to_cart"><button type="button" class="btn_1 full-width cart" onclick="add_item()">Add to Cart</button></div>
                            </div>
                        </div>
                    </div>
                    <!-- /prod_info -->
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </main>
    <!-- /main -->
@endsection
@push('specific_scripts')
    <script  src="{{asset('assets/frontend/js/carousel_with_thumbs.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@push('scripts')
    <script>
        $(".button_inc").on("click", function () {
            const $button = $(this);
            let oldValue = $button.parent().find("input").val();
            let newVal;
            if ($button.text() == "+") {
                newVal = parseFloat(oldValue) + 1;
            } else {
                // Don't allow decrementing below zero
                if (oldValue > 1) {
                    newVal = parseFloat(oldValue) - 1;
                } else {
                    newVal = 0;
                }
            }
            $button.parent().find("input").val(newVal);
        });

        function add_item() {
            const quantity = $('#quantity').val();
            $.ajax({
                url: `{{ route('cart.store') }}`,
                type: 'POST',
                data: {
                    _token  : '{{ csrf_token() }}',
                    id      :'{{$ebook->id}}',
                    quantity:quantity,
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

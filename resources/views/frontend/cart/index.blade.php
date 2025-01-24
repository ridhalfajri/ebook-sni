@extends('frontend.app')
@push('specific_css')
    <link href="{{ asset('assets/frontend/css/cart.css') }}" rel="stylesheet">
@endpush
@section('content')
    <main class="bg_gray">
        <div class="container margin_30">
            <div class="page_header">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{route('home')}}">Home</a></li>
                        <li>Cart</li>
                    </ul>
                </div>
                <h1>Your cart</h1>
            </div>
            <!-- /page_header -->
            @if(!$items->isEmpty())
                <table class="table table-striped cart-list">
                    <thead>
                    <tr>
                        <th>
                            Ebook
                        </th>
                        <th>
                            Price
                        </th>
                        <th>
                            Quantity
                        </th>
                        <th>
                            Subtotal
                        </th>
                        <th>
    
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>
                                <div class="thumb_cart">
                                    <img src="{{asset('storage/'.$item->ebook->thumbnail)}}" data-src="{{asset('storage/'.$item->ebook->thumbnail)}}" class="lazy" alt="Image">
                                </div>
                                <span class="item_cart">{{$item->ebook->title}}</span>
                            </td>
                            <td>
                                <strong>Rp {{ number_format($item->ebook->price, 2, ',', '.') }}</strong>
                            </td>
                            <td>
                                <div class="numbers-row">
                                    <input type="text" value="{{$item->quantity}}" data-id="{{ $item->id }}" class="qty2" name="total_quantity">
                                    <div class="inc button_inc" data-id="{{ $item->id }}" data-ebookid="{{ $item->ebook_id }}">+</div><div class="dec button_inc" data-id="{{ $item->id }}" data-ebookid="{{ $item->ebook_id }}">-</div>
                                </div>
                            </td>
                            <td>
                                <strong id="total_price{{ $item->id }}">Rp {{ number_format($item->price, 2, ',', '.') }}</strong>
                            </td>
                            <td class="options">
                                <a href="javascript:void(0)" onclick="delete_cart({{$item->id}})"><i class="ti-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h6>Cart is empty</h6>
            @endif
            
            <!-- /cart_actions -->

        </div>
        <!-- /container -->

        <div class="box_cart">
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <ul id="item-list">
                            @if(!$items->isEmpty())
                                <li>
                                    <span>Total</span> Rp {{ number_format($item->sum('price'), 2, ',', '.') }}
                                </li>
                            @endif
                            
                        </ul>
                        @if(!$items->isEmpty())
                            <button class="btn_1 full-width cart">Proceed to Checkout</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- /box_cart -->

    </main>
    <!--/main-->
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
            
            $.ajax({
                url: `{{ route('cart.store') }}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id:$button.data('ebookid'),
                    idItem : $button.data('id'),
                    totalQuantity : newVal
                },
                success: function(response) {
                    if(response.cart_item.quantity == 0){
                        location.reload()
                    }
                    $('#count_cart').text(response.cart_count)
                    $('#total_price' + response.cart_item.id).text(formatRupiahHeader(response.cart_item.price));
                    $('#item-list').empty();
                    $('#item-list').append('<li><span>Total</span>' + formatRupiahHeader(response.cart_item.price) + '</li>');
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
            
            
        });

        const delete_cart = (id)=>{
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((willDelete) => {
                if(willDelete.isConfirmed){
                    $.ajax({
                        url: `{{ route('cart_item.destroy', ':id') }}`.replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1000
                            });
                            setTimeout(() => {
                                location.reload()
                            }, 500);
                        },
                        error: function(xhr) {
                            console.info(xhr.responseJSON)
                            Swal.fire({
                                position: "top-end",
                                icon: "error",
                                title: xhr.responseJSON.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
                else {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: "Delete action has been canceled.",
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            });

        }
    </script>
@endpush

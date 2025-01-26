<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Ansonika">
    <title>Allaia | Bootstrap eCommerce Template - ThemeForest</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="{{ asset('assets/frontend/img/apple-touch-icon-57x57-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="{{ asset('assets/frontend/img/apple-touch-icon-72x72-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="{{ asset('assets/frontend/img/apple-touch-icon-114x114-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="{{ asset('assets/frontend/img/apple-touch-icon-144x144-precomposed.png') }}">

    <!-- GOOGLE WEB FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="{{ asset('assets/frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frontend/css/style.css') }}" rel="stylesheet">

	<!-- SPECIFIC CSS -->
    @stack('specific_css')

    <!-- YOUR CUSTOM CSS -->
    <link href="{{ asset('assets/frontend/css/custom.css') }}" rel="stylesheet">
    @stack('style')
</head>

<body>

	<div id="page">

	@include('frontend.partials.header')
	<!-- /header -->

	@yield('content')
	<!-- /main -->

	@include('frontend.partials.footer')
	<!--/footer-->
	</div>
	<!-- page -->

	<div id="toTop"></div><!-- Back to top button -->

	<!-- COMMON SCRIPTS -->
    <script src="{{ asset('assets/frontend/js/common_scripts.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/main.js') }}"></script>

	<!-- SPECIFIC SCRIPTS -->
    @stack('specific_scripts')

    <!-- CUSTOM SCRIPTS -->
    <script>
        function logout(){
            $.ajax({
                url: '{{ route('auth.logout') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    window.location.href = '/';
                },
                error: function(xhr) {
                    alert('Logout failed. Please try again.');
                }
            });
        }

        function formatRupiahHeader(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
            }).format(amount);
        }
        $('#cart_items').hover(function() {
            $.ajax({
                url: '{{ route("cart.get_items") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#cart-items-list').empty(); // Clear previous items
                    if (data.length > 0) {
                        data.forEach(function(item) {
                            $('#cart-items-list').append(`
                                <li>
                                    <a href="javascript:void(0)">
                                        <figure>
                                            <img src="{{ asset('storage/') }}/${item.thumbnail}" data-src="{{ asset('storage/') }}/${item.thumbnail}" alt="" width="50" height="50" class="lazy">
                                        </figure>
                                        <strong>
                                            <span>${item.quantity}x ${item.title}</span> ${formatRupiahHeader(item.price)}
                                        </strong>
                                    </a>
                                </li>
                            `);
                        });
                    } else {
                        $('#cart-items-list').append('<li>Your cart is empty.</li>');
                    }
                    $('#cart-dropdown').show(); // Show the dropdown
                },
                error: function(xhr) {
                    console.error('Error fetching cart items:', xhr);
                    }
            });
            }, function() {
            $('#cart-dropdown').hide();
        });

        $('#search-form').submit(function(e) {
            e.preventDefault();
            const searchQuery = $('#search_ebook').val();
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('title', searchQuery);
            window.location.href = currentUrl.toString();
        });
    </script>

    @stack('scripts')
</body>
</html>

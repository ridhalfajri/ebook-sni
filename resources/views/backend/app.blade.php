<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Slim">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/slim/img/slim-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/slim">
    <meta property="og:title" content="Slim">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/slim/img/slim-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/slim/img/slim-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>Slim Responsive Bootstrap 4 Admin Template</title>

    <!-- vendor css -->
    <link href="{{ asset('assets/backend/lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/lib/perfect-scrollbar/css/perfect-scrollbar.min.css') }}" rel="stylesheet">

    <!-- Slim CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/slim.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" />
    @stack('style')


</head>
<body>

<div class="slim-header with-sidebar">
    @include('backend.partials.header')
    <!-- container-fluid -->
</div><!-- slim-header -->

<div class="slim-body">
    @include('backend.partials.sidebar')
    <!-- slim-sidebar -->

    <div class="slim-mainpanel">

        @yield('content')

        @include('backend.partials.footer')
        <!-- slim-footer -->
    </div><!-- slim-mainpanel -->
</div><!-- slim-body -->

<script src="{{ asset('assets/backend/lib/jquery/js/jquery.js') }}"></script>
<script src="{{ asset('assets/backend/lib/popper.js/js/popper.js') }}"></script>
<script src="{{ asset('assets/backend/lib/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/backend/lib/jquery.cookie/js/jquery.cookie.js') }}"></script>
<script src="{{ asset('assets/backend/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js') }}"></script>

<script src="{{ asset('assets/backend/js/slim.js') }}"></script>
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
</script>
@stack('scripts')
</body>
</html>

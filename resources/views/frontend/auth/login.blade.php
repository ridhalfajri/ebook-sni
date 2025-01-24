@extends('frontend.app')
@push('specific_css')
    <link href="{{ asset('assets/frontend/css/account.css') }}" rel="stylesheet">
@endpush
@section('content')
<main class="bg_gray">
    <div class="container margin_30">
        <div class="page_header">
            <div class="breadcrumbs">
                <ul>
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li>Login</li>
                </ul>
        </div>
        <h1>Sign In</h1>
    </div>
    <!-- /page_header -->
            <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-8">
                <div class="box_account">
                    <h3 class="client">Already Client</h3>
                    <form action="{{route('auth.login')}}" method="POST" id="form-login">
                        @csrf
                        <div class="form_container">
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email*" value="jane@example.com">
                                <small class="text-danger" id="err_email"></small>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password*" value="password">
                                <small class="text-danger" id="err_password"></small>
                            </div>
                            <div class="clearfix add_bottom_15">
                                <div class="checkboxes float-start">
                                    <label class="container_check">Remember me
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="float-end"><a id="forgot" href="javascript:void(0);">Lost Password?</a></div>
                            </div>
                            <div class="text-center"><input type="submit" value="Log In" class="btn_1 full-width"></div>
                            <a href="{{route('register')}}">Create an Account</a>
                        </div>
                        <!-- /form_container -->
                    </form>
                </div>
                <!-- /row -->
            </div>
        </div>
        <!-- /row -->
        </div>
        <!-- /container -->
</main>
@endsection
@push('scripts')
    <script>
        $('#form-login').submit(function(e) {
            e.preventDefault();
            const form = $(this);
            const actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    resetForm()
                    console.log(response)
                    window.location.href = response.redirect
                },
                error: function (xhr) {
                    if (xhr.status === 422) { // Unprocessable Entity
                        const errors = xhr.responseJSON.errors;
                        resetForm();
                        setError(errors);
                    } else {
                        console.error('An unexpected error occurred.');
                    }
                },

            });
        });
        function resetForm() {
            $('#err_email').text('')
            $('#err_password').text('')
        }
        function  setError(err){
            if (err.email) {
                $('#err_email').text(err.email)
            }
            if (err.password) {
                $('#err_password').text(err.password)
            }
        }
    </script>
@endpush

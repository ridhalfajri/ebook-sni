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
                    <li>Register</li>
                </ul>
        </div>
        <h1>Create an Account</h1>
    </div>
    <!-- /page_header -->
            <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-8">
                <div class="box_account">
                    <h3 class="new_client">New Client</h3> <small class="float-right pt-2">* Required Fields</small>
                    <form action="{{route('auth.register')}}" method="POST" id="form-register">
                        @csrf
                        <div class="form_container">
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email*">
                                <small class="text-danger" id="err_email"></small>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password*">
                                <small class="text-danger" id="err_password"></small>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="" placeholder="Password Confirmation*">
                                <small class="text-danger" id="err_password_confirmation"></small>
                            </div>
                            <div class="private box">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Full Name*">
                                            <small class="text-danger" id="err_name"></small>
                                        </div>
                                    </div>
                                </div>
                                <!-- /row -->
                            </div>
                            <!-- /company -->
                            <div class="text-center"><input type="submit" value="Register" class="btn_1 full-width"></div>
                            <a href="{{route('login')}}">Already have an account</a>
                        </div>
                    </form>
                    <!-- /form_container -->
                </div>
                <!-- /box_account -->
            </div>
        </div>
        <!-- /row -->
        </div>
        <!-- /container -->
</main>
@endsection

@push('scripts')
    <script>
        $('#form-register').submit(function(e) {
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

                    window.location.href = '{{ route('login') }}'
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
            $('#err_name').text('')
            $('#err_password').text('')
            $('#err_password_confirmation').text('')
        }
        function  setError(err){
            if (err.email) {
                $('#err_email').text(err.email)
            }
            if (err.name) {
                $('#err_name').text(err.name)
            }
            if (err.password) {
                $('#err_password').text(err.password)
            }
            if (err.password_confirmation) {
                $('#err_password_confirmation').text(err.password_confirmation)
            }
        }
    </script>
@endpush

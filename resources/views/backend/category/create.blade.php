@extends('backend.app')
@section('content')
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
            <h6 class="slim-pagetitle">Categories Page</h6>
        </div><!-- slim-pageheader -->
        <div class="row row-sm mg-t-20">
            <div class="col-lg-6">
                <div class="section-wrapper">
                    <label class="section-title mg-b-20 mg-sm-b-40">Input Category</label>
                    <form action="{{route('categories.store')}}" method="POST" id="form-category">
                        @csrf
                        <div class="form-layout form-layout-4">
                            <div class="row">
                                <label class="col-sm-4 form-control-label">Name <span class="tx-danger">*</span></label>
                                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name Category">
                                    <small class="text-danger" id="err_name"></small>
                                </div>

                            </div><!-- row -->
                            <div class="row mg-t-20">
                                <label class="col-sm-4 form-control-label">Description</label>
                                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter Description"></textarea>
                                    <small class="text-danger" id="err_description"></small>
                                </div>
                            </div>
                            <div class="form-layout-footer mg-t-30">
                                <button class="btn btn-primary bd-0" type="submit">Submit</button>
                                <button class="btn btn-secondary bd-0" type="button" onclick="window.location.href='{{route('categories.index')}}'">Cancel</button>
                            </div><!-- form-layout-footer -->
                        </div><!-- form-layout -->
                    </form>
                </div>
            </div>
        </div>
    </div><!-- container -->
@endsection

@push('scripts')
    <script>
        $('#form-category').submit(function(e) {
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
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1000
                    });
                    setTimeout(function (){
                        window.location.href = "{{route('categories.index')}}"
                    },1000)
                },
                error: function (xhr) {
                    if (xhr.status === 422) { // Unprocessable Entity
                        const errors = xhr.responseJSON.errors;
                        resetForm();
                        setError(errors);
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: xhr.responseJSON.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },

            });
        });
        function resetForm() {
            $('#err_name').text('')
            $('#err_description').text('')
        }
        function  setError(err){
            if (err.name) {
                $('#err_name').text(err.name)
            }
            if (err.description) {
                $('#err_description').text(err.description)
            }
        }
    </script>
@endpush

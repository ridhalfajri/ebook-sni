@extends('backend.app')
@push('style')
    <link href="{{ asset('assets/backend/lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <style>

        .image-preview-container {
            width: 300px;
            height: 200px;
            overflow: hidden;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #eaeaea;
        }

        #imagePreview {
            max-width: 100%;
            max-height: 100%;
        }
        iframe {
            width: 100%;
            height: 200px; /* Adjust height as needed */
            border: none; /* Remove border */
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Ebooks</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
            <h6 class="slim-pagetitle">Ebooks Page</h6>
        </div><!-- slim-pageheader -->
        <div class="row row-sm mg-t-20">
            <div class="col-lg">
                <div class="section-wrapper">
                    <label class="section-title">Top Label Layout</label>
                    <p class="mg-b-20 mg-sm-b-40">A form with a label on top of each form control.</p>
                    <form action="{{route('ebooks.update',$ebook->id)}}" method="POST" id="form-ebook" enctype="multipart/form-data">
                        <div class="form-layout">
                        <div class="row mg-b-25">
                            <div class="col-lg-4">
                                <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Category: <span class="tx-danger">*</span></label>
                                    <select class="form-control select2-show-search" name="category_id" data-placeholder="Choose category">
                                        <option disabled>Choose category</option>
                                        @foreach ($categories as $category)
                                        @if($ebook->category_id == $category->id)
                                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                        @else
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                        @endforeach
                                      </select>
                                      <small class="text-danger" id="err_category"></small>
                                </div>
                                </div><!-- col-4 -->
                            <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-control-label">Title: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="title" placeholder="Enter title" value="{{ $ebook->title }}">
                                <small class="text-danger" id="err_title"></small>
                            </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-control-label">Author: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="author" placeholder="Enter author" value="{{ $ebook->author }}">
                                <small class="text-danger" id="err_author"></small>
                            </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-control-label">Price <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" id="amount" name="amount" placeholder="Enter price" value="{{ floor($ebook->price) }}">
                                <small class="text-danger" id="err_price"></small>
                                <input class="form-control" type="hidden" id="price" name="price" value="" placeholder="Enter price" value="{{ $ebook->price }}">
                            </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-8">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Description:</label>
                                <textarea class="form-control" type="text" name="description" placeholder="Enter Description">{{ $ebook->description }}</textarea>
                                <small class="text-danger" id="err_description"></small>
                            </div>
                            </div><!-- col-8 -->
                            <div class="col-lg-4">
                                <label class="form-control-label">File: <span class="tx-danger">*</span></label>
                                <div class="custom-file">
                                <input type="file" class="custom-file-input" name="file_path" id="file_path" accept=".pdf">
                                <label class="custom-file-label" id="label_choose_file_path" for="file_path">Choose file</label>
                                <input type="hidden" class="custom-file-input" name="old_file_path" id="old_file_path" value="{{ $ebook->file_path }}">
                                <small class="text-danger" id="err_file_path"></small>
                                @if($ebook->file_path != null)
                                    <a class="text-primary" href="{{ asset('storage/' . $ebook->file_path) }}">Download</a>
                                @endif
                                </div><!-- custom-file -->
                            </div>
                            <div class="col-lg-4">
                                <label class="form-control-label">Thumbnail: <span class="tx-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="thumbnail" id="thumbnail" accept=".png,.jpg,.jpeg">
                                    <label class="custom-file-label" for="thumbnail"id='label_choose_thumbnail'>Choose thumbnail</label>
                                    <input type="hidden" class="custom-file-input" name="old_thumbnail" id="old_thumbnail" value="{{ $ebook->thumbnail }}">
                                    <small small class="text-danger" id="err_thumbnail"></small>
                                </div><!-- custom-file -->
                            </div>
                            {{-- <div class="col-lg-4">
                                <div class="form-group mg-b-10-force">
                                    <iframe src="{{ asset('storage/' . $ebook->file_path) }}" class="mt-4" frameborder="0"></iframe>
                                </div>
                            </div> --}}
                            <div class="col-lg-4">
                                <div class="form-group mg-b-10-force">
                                    <label for="imagePreview">Preview Thumbnail</label>
                                    <div class="image-preview-container">
                                        <img id="imagePreview" src="{{ asset('storage/' . $ebook->thumbnail) }}" alt="Image Preview" style="display: block; max-width: 300; max-height: 300;"/>
                                    </div>
                                </div>
                            </div>
                        </div><!-- row -->
            
                        <div class="form-layout-footer">
                            <button type="submit" class="btn btn-primary bd-0">Submit Form</button>
                            <button type="button" class="btn btn-secondary bd-0" onclick="window.location.href='{{ route('ebooks.index') }}'">Cancel</button>
                        </div><!-- form-layout-footer -->
                        </div><!-- form-layout -->
                    </from>
                </div><!-- section-wrapper -->
            </div>
        </div>
    </div><!-- container -->
@endsection

@push('scripts')
    <script src="{{ asset('assets/backend/lib/select2/js/select2.min.js') }}"></script>
    <script>
        $(function() {
            const element = document.getElementById('amount')
            changeFormatRupiah(element)
        })

        $('#file_path').on('change', function(event) {
            const file = event.target.files[0];
            let fileName = file.name
            if (fileName.length > 50) {
                fileName = fileName.substring(0, 40) + '...'; // Tambahkan '...' jika dipotong
            }
            $('#label_choose_file_path').text(fileName) 
        })
        $('#thumbnail').on('change', function(event) {
            
            const file = event.target.files[0];
            let fileName = file.name
            if (fileName.length > 50) {
                fileName = fileName.substring(0, 40) + '...'; // Tambahkan '...' jika dipotong
            }
            $('#label_choose_thumbnail').text(fileName)
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                
                $('#imagePreview').attr('src', e.target.result); 
                $('#imagePreview').css('display', 'block');
            };

            if (file) {
                reader.readAsDataURL(file); 
            }
        });
        $('.select2-show-search').select2({
          minimumResultsForSearch: ''
        });
        $('#form-ebook').submit(function(e) {
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
                        window.location.href = "{{route('ebooks.index')}}"
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
            $('#err_category').text('')
            $('#err_title').text('')
            $('#err_author').text('')
            $('#err_price').text('')
            $('#err_description').text('')
            $('#err_file_path').text('')
            $('#err_thumbnail').text('')
        }
        function  setError(err){
            if (err.category_id) {
                $('#err_category').text(err.category_id)
            }
            if (err.title) {
                $('#err_title').text(err.title)
            }
            if (err.author) {
                $('#err_author').text(err.author)
            }
            if (err.price) {
                $('#err_price').text(err.price)
            }
            if (err.description) {
                $('#err_description').text(err.description)
            }
            if (err.file_path) {
                $('#err_file_path').text(err.file_path)
            }
            if (err.thumbnail) {
                $('#err_thumbnail').text(err.thumbnail)
            }
        }
        $('#amount').on('input', function(e)  {
            changeFormatRupiah(this)
            console.log(this);
            
            
        });
        function changeFormatRupiah(e){
            let value = e.value.replace(/[^0-9]/g, '');
            
            let numberValue = parseFloat(value)
            if (!isNaN(numberValue)) {
                let integerValue = Math.floor(numberValue);
                e.value = formatRupiah(integerValue);
            } else {
                e.value = '';
            }
            //simpan value tanpa saparator di id price
            let amountValue = e.value.replace(/[^0-9]/g, '');
            $('#price').val(amountValue)
        }

        function formatRupiah(angka) {
            let rupiah = '';
            let angkak = angka.toString();
            let sisa = angkak.length % 3;
            let ribuan = angkak.substr(0, sisa);
            let ribuanLain = angkak.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                rupiah += ribuan;
            }
            if (ribuanLain) {
                rupiah += (ribuan ? '.' : '') + ribuanLain.join('.');
            }
            return 'Rp ' + rupiah;
        }

    </script>
@endpush

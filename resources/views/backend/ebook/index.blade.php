@extends('backend.app')
@push('style')
    <link href="{{asset('assets/backend/lib/ion.rangeSlider/css/ion.rangeSlider.css')}}" rel="stylesheet">
    <link href="{{asset('assets/backend/lib/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/backend/lib/select2/css/select2.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ebooks</li>
            </ol>
            <h6 class="slim-pagetitle">Ebooks Page</h6>
        </div><!-- slim-pageheader -->
        <div class="section-wrapper">
            <div class="row">
                <div class="col-sm-12 col-md-12 d-flex justify-content-end">
                    <div class="btn-demo">
                        <button class="btn btn-primary btn-block mg-b-10" onclick="window.location.href='{{route('ebooks.create')}}'">Create Ebook</button>
                    </div><!-- btn-demo -->
                </div><!-- col-sm-3 -->
            </div>
            <div class="row">
                <div class="col-lg">
                    <select class="form-control select2-show-search" name="category_id" id="filter_category" data-placeholder="Choose category">
                    <option value="*">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div><!-- col -->
                <div class="col-lg">
                    <input class="form-control" id="filter_title" placeholder="Filter Title" type="text">
                </div><!-- col -->
                <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                    <input type="text" class="rangeslider3" id="filter_range_price" data-extra-classes="irs-primary" value="">
                </div><!-- col-6 -->
            </div>
            <table class="table" id="ebookTable">
                <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col">Category</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Price</th>
                    <th scope="col" class="text-right">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div><!-- container -->
@endsection

@push('scripts')
    <script src="{{asset('assets/backend/lib/ion.rangeSlider/js/ion.rangeSlider.min.js')}}"></script>
    <script src="{{ asset('assets/backend/lib/select2/js/select2.min.js') }}"></script>
    <script>
        let table,debounceTimer;
        
        $('.select2-show-search').select2({
            minimumResultsForSearch: ''
        });
        $(function (){
            ebooks()

            $('.rangeslider3').ionRangeSlider({
                type: 'double',
                grid: true,
                min: 0,
                max: isNaN(parseInt(@json($max_price), 10)) || @json($max_price) === null ? 0 : parseInt(@json($max_price), 10),
                from: 0,
                to: 0,
                prefix: 'Rp'
            });
        })
        const debounceEbooks = () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                ebooks();
            }, 500);
        };
        $('#filter_title').on('keyup', debounceEbooks);
        $('#filter_category').on('change', debounceEbooks);
        $('#filter_range_price').on('change', debounceEbooks);

        const ebooks = ()=>{
            table = new DataTable('#ebookTable',{
                processing: true,
                destroy: true,
                serverSide: true,
                deferRender: true,
                responsive: true,
                pageLength: 10,
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('ebooks.datatable') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data:{
                        categoryName : $('#filter_category').val(),
                        title : $('#filter_title').val(),
                        range_price : $('#filter_range_price').val()
                    }
                },
                columns: [{
                    data: 'no',
                    name: 'no',
                    class: 'text-center',
                    },
                    {
                        data: 'categoryName',
                        name: 'categories.name',

                    },
                    {
                        data: 'title',
                        name: 'title',

                    },
                    {
                        data: 'author',
                        name: 'author',

                    },
                    {
                        data: 'price',
                        name: 'price',
                        render: function(data, type, row) {
                            // Format the price to Rupiah
                            const rupiahFormat = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0,
                            });
                            return rupiahFormat.format(data);
                        }

                    },
                    {
                        data: 'action',
                        name: 'action',
                        class: 'text-right',
                    },
                ],
                columnDefs: [{
                    'sortable': false,
                    'searchable': false,
                    'targets': [0, -1]
                }],
            });
            table.on('draw.dt', function() {
                var info = table.page.info();
                table.column(0, {
                    search: 'applied',
                    order: 'applied',
                    page: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1 + info.start;
                });
            });
        }

        const delete_ebook = (id)=>{
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
                        url: `{{ route('ebooks.destroy', ':id') }}`.replace(':id', id),
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
                            $("#ebookTable").DataTable().ajax.reload();
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

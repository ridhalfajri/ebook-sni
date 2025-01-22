@extends('backend.app')
@section('content')
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Categories</li>
            </ol>
            <h6 class="slim-pagetitle">Categories Page</h6>
        </div><!-- slim-pageheader -->
        <div class="section-wrapper">
            <div class="row">
                <div class="col-sm-12 col-md-12 d-flex justify-content-end">
                    <div class="btn-demo">
                        <button class="btn btn-primary btn-block mg-b-10" onclick="window.location.href='{{route('categories.create')}}'">Create Category</button>
                    </div><!-- btn-demo -->
                </div><!-- col-sm-3 -->
            </div>
            <table class="table" id="categoryTable">
                <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
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
    <script>
        let table;
        $(function (){
            categories()
        })
        const categories = ()=>{
            table = new DataTable('#categoryTable',{
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
                    url: '{{ route('categories.datatable') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                },
                columns: [{
                    data: 'no',
                    name: 'no',
                    class: 'text-center',
                    },
                    {
                        data: 'name',
                        name: 'name',

                    },
                    {
                        data: 'description',
                        name: 'description',

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

        const delete_category = (id)=>{
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
                        url: `{{ route('categories.destroy', ':id') }}`.replace(':id', id),
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
                            $("#categoryTable").DataTable().ajax.reload();
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

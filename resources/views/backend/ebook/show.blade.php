@extends('backend.app')
@push('style')
    
@endpush
@section('content')
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ebooks.index') }}">Ebooks</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
            <h6 class="slim-pagetitle">Ebooks Page</h6>
        </div><!-- slim-pageheader -->
        <div class="card card-latest-activity mg-t-20">
            <div class="card-body">
              <div class="slim-card-title">Detail</div>
              <div class="media media-author">
                <div class="media-body">
                  <h3><a href="javascript:void(0)">{{ $ebook->title }}</a></h3>
                  <p>{{ $ebook->author }}</p>
                </div><!-- media-body -->
              </div><!-- media -->
              <div class="row no-gutters">
                <div class="col-md-4">
                  <a href=""><img src="{{asset('storage/' . $ebook->thumbnail)}}" class="img-fit-cover" alt="" style="width: 336px;height: 336px;"></a>
                </div><!-- col-4 -->
                <div class="col-md-8">
                  <div class="post-wrapper">
                    <span>{{ $ebook->category->name }}</span>
                    <a href="" class="activity-title">RP. {{ number_format($ebook->price, 2, ',', '.') }}</a>
                    <p>{{ $ebook->description }}</p>
                    <p class="mg-b-0">
                      <a href="{{asset('storage/' . $ebook->file_path)}}" class="d-block">Download</a>
                      <span>{{ \Carbon\Carbon::parse($ebook->created_at)->translatedFormat('d F Y') }}</span>
                    </p>
                  </div><!-- post-wrapper -->
                </div><!-- col-8 -->
              </div><!-- row -->

            </div><!-- card-body -->
          </div><!-- card -->
    </div><!-- container -->
@endsection

@push('scripts')

@endpush

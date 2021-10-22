@extends('layouts.dash')

@section('clientreviews')
menu-active
@endsection

@section('title')
Client's Reviews Edit|
@endsection
@section('dash_content')
<script src="https://cdn.tiny.cloud/1/ft8qzzzy55wfpr1cdg4ojb8pqxjfe9tanm9mermc14jg36hr/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Sidebar Area End Here -->
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h1>My Client's Reviews Edit</h1>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">Home</a>
            </li>
            <li>
                <a href="{{ route('client-reviews.index') }}">My Client's Reviews</a>
            </li>
            <li>
                My Client's Reviews Edit
            </li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
            @if(session('status'))
            <div class="alert alert-success">
            {{ session('status') }}
            </div>
            @endif
            @if(session('status1'))
            <div class="alert alert-danger">
            {{ session('status1') }}
            </div>
            @endif



<form action="{{ route('client-reviews.update',$review->id) }}" method="post" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="card bg-secondary">
    <img class="card-img-top img-fluid rounded mx-auto  w-25 " id="tenant_photo_viewer"
    src="{{ asset('uploads/clientreviews') }}/{{ $review->client_photo }}" alt="{{ $review->client_photo }}">
    <div class="card-body ">
        <div class="form-group">
        <h5 class="card-title">Upload New Client Upload Image:</h5>

        <input type="file" class="form-control form-control-lg" name="client_photo"
            accept="image/x-png image/jpeg image/jpg image/gif " onchange="readURL(this);">
        @error('client_photo')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    </div>

    <div class="card-body">
        <div class="form-group">
<div class="row">
    <div class="col">
        <h5 class="card-title">Client Name:</h5>
        <input name="client_name" class="form-control form-control-lg" placeholder="Client Name" required
            value="{{ $review->client_name  }}" type="text">
        @error('client_name')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

    </div>
    <div class="col">
        <h5 class="card-title">Home Page Serial:</h5>
        <input name="serial" class="form-control form-control-lg" placeholder="Home Page Serial" required
            value="{{ $review->serial  }}" min="1" type="number">
        @error('serial')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

    </div>

</div>


    </div>
    </div>
    <div class="card-body">
        <div class="form-group">
        <h5 class="card-title">Client Designation:</h5>
        <input name="client_designation" class="form-control form-control-lg" placeholder="Client Designation" required
            value="{{ $review->client_designation  }}" type="text">
        @error('client_designation')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    </div>


    <div class="card-body">
        <div class="form-group">
        <h5 class="card-title">Client's Review:</h5>
            <textarea  name="client_review" class="form-control"> {{ $review->client_review }}</textarea>
        @error('client_review')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    </div>

    <div class="card-body">
        <button type="submit" class="btn-fill-md radius-30 text-light bg-dark-pastel-green">Update<i class="fas fa-check mg-l-15"></i></button>
    </div>
</form>
</div>








@endsection

@section('javascript')

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#tenant_photo_viewer').attr('src', e.target.result);
            };
            $('#tenant_photo_viewer').removeClass('hidden');
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
<script>
    tinymce.init({
    selector: 'textarea',
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code link help wordcount'
    ],
    toolbar: 'undo redo | formatselect | ' +
    'bold italic backcolor | alignleft aligncenter ' +
    'alignright alignjustify | bullist numlist outdent indent link| ' +
    'removeformat',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
</script>
@endsection

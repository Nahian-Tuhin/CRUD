@extends('layouts.dash')

@section('clientreviews')
menu-active
@endsection

@section('title')
Clients Reviews|
@endsection
@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

<style>
    /* The switch - the box around the slider */
    .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
    opacity: 0;
    width: 0;
    height: 0;
    }

    /* The slider */
    .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    }

    .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    }

    input:checked + .slider {
    background-color: #2196F3;
    }

    input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
    border-radius: 34px;
    }

    .slider.round:before {
    border-radius: 50%;
    }
</style>
@endsection
@section('dash_content')

<!-- Sidebar Area End Here -->
<div class="dashboard-content-one">

            <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h1>My Client's Reviews</h1>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">Home</a>
            </li>
            <li>My Client's Reviews </li>
        </ul>
        <br>
        <a href="{{ route('client-reviews.create') }}">
            <button type="button" class="btn-fill-lmd radius-30 text-light shadow-dodger-blue bg-dodger-blue">Add New Client Review</button>
        </a>
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

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:rgb(255, 6, 6) " id="exampleModalLabel">Confirm Delete ?
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>
                        <div class="modal-body">
                            Are You Sure You Want To Delete The Data?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <form action="{{ route('client-reviews.destroy','id?') }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <input id="id" value="id" name="id" hidden>
                                <button type="sybmit" class="btn btn-danger">Confirm Delete</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container">
                <div class="table-responsive">
                <table id="example" class="table">
                    <thead>
                        <tr >
                            <th>No.</th>
                            <th>Client Photo</th>
                            <th>Client Name</th>
                            <th>Client Designation</th>
                            <th>Client Review</th>
                            <th >Serial</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse( $review as $item)
                                <tr>
                                    {{-- <td scope="row">{{ $item->serial + 1 }}</td> --}}
                                    <td scope="row">{{ $loop->index + 1 }}</td>
                                    <td>
                                        <img class="img-fluid"  height="60" width="60" src="{{ asset('uploads/clientreviews') }}/{{ $item->client_photo }}" alt="{{ $item->photo }}">
                                    </td>
                                    {{-- {{ route('client-reviews.show',$item->id)  }} --}}
                                    <td><a href="#">{{ $item->client_name }}</a></td>
                                    <td>{!! $item->client_review !!}</td>
                                    <td>{{ $item->client_designation }}</td>
                                    <td  >{{ $item->serial }}</td>
                                            <td>
                                        <label class="switch">
                                            <input type="checkbox" data-id="{{ $item->id }}" id="clientreviews_status"
                                            {{ $item->status == 1 ? 'checked' : ''}}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="btn-group " role="group" aria-label="Basic mixed styles example">
                                            <a
                                                href="{{ route('client-reviews.edit',$item->id) }}">
                                                <button type="button" class="btn btn-primary">Edit</button>
                                            </a>||
                                            <button id="delet" type="button" class="btn btn-danger delet"
                                                data-toggle="modal" data-id="{{ $item->id }}"
                                                data-target="#exampleModal">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                        @empty
                            <h2>No data Found...</h2>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>







    @endsection

    @section('javascript')
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "order": [
                    [3, "desc"]
                ]
            });
        });

        $(document).on('click', '.delet', function () {
            let id = $(this).attr('data-id');
            $('#id').val(id);
        });

    </script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('body').on('change','#clientreviews_status', function(){
        var id = $(this).attr('data-id');
        if(this.checked){
        var status = 1;
        }else{
            var status = 2;

        }
        //ajax work strat
                    $.ajax({
                    url: 'clients/reviews/'+id+'/'+status,
                    method: 'get',
                    success: function(result){
                    }
                    });
            //         //ajax work end

        });
                });





    </script>



    @endsection

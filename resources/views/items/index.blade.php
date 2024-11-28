@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">
                Add Item 
            </button>

            @if ($errors->any())
            <div class="alert alert-warning">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif


            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{route('store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="exampleInputTitle">Title</label>
                                    <input type="text" name="title" class="form-control" id="exampleInputTitle" placeholder="Enter your name" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPrice">Price</label>
                                    <input type="number" name="price" class="form-control" id="exampleInputPrice" placeholder="Enter Item Price">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputDetails">Details</label>
                                    <textarea name="details" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleSelect">Image</label>
                                    <input class="form-control" name="image" type="file" id="exampleSelect">
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Items') }}  <span class="btn btn success">({{$count->count() ?? 0}})</span></div>
                <div class="card-body">
                    <form method="GET" action="{{ route('items') }}">
                        <div class="row">
                            <div class="col-4 form-group">
                                <input type="text" name="title" class="form-control" placeholder="Search by Title" value="{{ $title }}">
                            </div>
                            <div class="col-4 form-group">
                                <input type="number" name="price" class="form-control" placeholder="Search by Price" value="{{ $price }}">
                            </div>
                            <div class="col-3 form-group">
                                <button class="btn btn-primary" type="submit">Search</button>
                                @if(($title != '') || ($price != ''))
                                <a style="margin-left: 5px;" href="{{route('items')}}"><button class="btn btn-primary" type="button">Clear Filter</button></a>
                                @endif
                            </div>

                        </div>
                    </form>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col" style="max-width: 100px;">Details</th>
                                <th scope="col">Price</th>
                                <th scope="col">Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            ?>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->price }}</td>
                                <td style="max-width: 100px;">{{ $product->details }}</td>
                                <td style="text-align:center;"><img style="height:100px; width:100px;" src="{{ asset('uploads/'.$product->image) }}" /></td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-5">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
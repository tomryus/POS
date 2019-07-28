@extends('layouts.master')
@section('title','List Product')

@section('content')
<div class="container-fluid">
        
    <div class="panel panel-headline">
        <div class="panel-heading">
            <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Manajemen Product</h1>
                    </div>
                    <br>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('product.index')}}">Product</a></li>
                        </ol>
                    </div>
                </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="row">
           
            <div class="col-md-12">
                <div class="metric">
                    <h2>Edit Product</h2><br>
                    <br>
                    <form role="form" action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label for="name">Nama Product</label>
                            <input type="text" value="{{$product->name}}" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name" required>
                            <div class="invalid-feedback">
                                {{$errors->first('name')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select name="category_id" class="form-control {{ $errors->has('category_id') ? 'is-invalid':'' }}" id="category_id" required>
                             <option value="{{$product->category_id}}">{{$product->category->name}}</option>   
                            <option>Pilih Category </option>
                            @foreach ($categories as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                            </select>
                            <div class="invalid-feedback">
                                {{$errors->first('category_id')}}
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea value="{{$product->decription}}" name="description" id="description" cols="5" rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid':'' }}">{{$product->description}}</textarea>
                                <div class="invalid-feedback">
                                {{$errors->first('description')}}
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input value="{{$product->stock}}" type="number" name="stock" class="form-control {{ $errors->has('stock') ? 'is-invalid':'' }}" id="stock" required>
                            <div class="invalid-feedback">
                                {{$errors->first('stock')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input value="{{$product->price}}" type="number" name="price" class="form-control {{ $errors->has('price') ? 'is-invalid':'' }}" id="price" required>
                            <div class="invalid-feedback">
                                {{$errors->first('price')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input value="{{$product->code}}" type="text" name="code" class="form-control {{ $errors->has('code') ? 'is-invalid':'' }}" id="code" required>
                            <div class="invalid-feedback">
                                {{$errors->first('code')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" name="photo" class="form-control">
                            @if (!empty($product->photo))
                                        <hr>
                                        <img src="{{ asset('storage/product/' . $product->photo) }}" 
                                            alt="{{ $product->name }}"
                                            width="150px" height="150px">
                                    @endif
                            <div class="invalid-feedback">
                                {{$errors->first('photo')}}
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                        </form>

                                                        
                   </div>
            </div>
        </div>
    </div>         
</div>              
@endsection
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
                    <h2>List Category</h2><br>
                    <br>
                    <form role="form" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Product</label>
                            <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name" required>
                            <div class="invalid-feedback">
                                {{$errors->first('name')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select name="category_id" class="form-control {{ $errors->has('category_id') ? 'is-invalid':'' }}" id="category_id" required>
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
                                <textarea name="description"  id="description" cols="5" rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid':'' }}"></textarea>
                                <div class="invalid-feedback">
                                {{$errors->first('description')}}
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" name="stock" class="form-control {{ $errors->has('stock') ? 'is-invalid':'' }}" id="stock" required>
                            <div class="invalid-feedback">
                                {{$errors->first('stock')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" class="form-control {{ $errors->has('price') ? 'is-invalid':'' }}" id="price" required>
                            <div class="invalid-feedback">
                                {{$errors->first('price')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" name="code" class="form-control {{ $errors->has('code') ? 'is-invalid':'' }}" id="code" required>
                            <div class="invalid-feedback">
                                {{$errors->first('code')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" name="photo" class="form-control {{ $errors->has('photo') ? 'is-invalid':'' }}" id="photo" required>
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
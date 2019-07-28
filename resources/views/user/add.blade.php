@extends('layouts.master')
@section('title','Add User')

@section('content')
<div class="container-fluid">
        
    <div class="panel panel-headline">
        <div class="panel-heading">
            <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Manajemen User</h1>
                    </div>
                    <br>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('user.index')}}">User</a></li>
                        </ol>
                    </div>
                </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="row">
           
            <div class="col-md-12">
                <div class="metric">
                    <h2>Add User</h2><br>
                    <br>
                    <form role="form" action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama User</label>
                            <input  type="text" name="name" autocomplete="off" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name" required>
                            <div class="invalid-feedback">
                                {{$errors->first('name')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" class="form-control {{ $errors->has('role') ? 'is-invalid':'' }}" id="role" required>
                            <option>Pilih Role </option>
                            @foreach ($role as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                            </select>
                            <div class="invalid-feedback">
                                {{$errors->first('role')}}
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" autocomplete="off" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" id="email" required>
                            <div class="invalid-feedback">
                                {{$errors->first('email')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}" id="password" required>
                            <div class="invalid-feedback">
                                {{$errors->first('password')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cpassword">Confirmation Password</label>
                            <input type="password" name="cpassword" class="form-control {{ $errors->has('cpassword') ? 'is-invalid':'' }}" id="cpassword" required>
                            <div class="invalid-feedback">
                                {{$errors->first('cpassword')}}
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
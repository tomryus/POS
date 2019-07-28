@extends('layouts.master')
@section('title','List Role')

@section('content')
<div class="container-fluid">
        
    <div class="panel panel-headline">
        <div class="panel-heading">
            <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Manajemen Role</h1>
                    </div>
                    <br>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('role.index')}}">Role</a></li>
                        </ol>
                    </div>
                </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-md-10">
                <div class="metric">
                    <h2 class="panel-title">Tambah Data</h2><br>
                    <form role="form" action="{{ route('role.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tambah Role</label>
                            <input value="{{$role->name}}" type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name" required>
                            <div class="invalid-feedback">
                                {{$errors->first('name')}}
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
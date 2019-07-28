@extends('layouts.master')
@section('title','Role Category')

@section('content')
<div class="container-fluid">
        
    <div class="panel panel-headline">
        <div class="panel-heading">
            <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Role Category</h1>
                    </div>
                    <br>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('category.index')}}">Role</a></li>
                        </ol>
                    </div>
                </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-md-5">
                <div class="metric">
                    <h2 class="panel-title">Tambah Role</h2><br>
                    <form role="form" action="{{ route('user.add_permission') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Kategori</label>
                            <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name" required>
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
                    
            <div class="col-md-7">
                <div class="metric">
                    @php
                        $dt = new DateTime();
                        $dt->setTimeZone(new DateTimeZone('Asia/Bangkok'));
                    @endphp
                    <h3>List Category</h3><br>
                    {{$dt->format('Y-m-d H:i:s')}}
                    @if(session('status'))
                    <div class="alert alert-success" >
                          {{session('status')}}
                    </div>
                    @endif

                    <form action="{{ route('user.role_permission') }}" method="GET">
                        <div class="form-group">
                            <label for="">Roles</label>
                            <div class="input-group">
                                <select name="role" class="form-control">
                                    @foreach ($roles as $value)
                                        <option value="{{ $value }}" {{ request()->get('role') == $value ? 'selected':'' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-btn">
                                    <button class="btn btn-danger">Check!</button>
                                </span>
                            </div>
                        </div>
                    </form>

                    {{-- jika $permission tidak bernilai kosong --}}
                    @if (!empty($permissions))
                    <form action="{{ route('user.setRolePermission', request()->get('role')) }}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1" data-toggle="tab">Permissions</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                        @php $no = 1; @endphp
                                        @foreach ($permissions as $key => $row)
                                            <input type="checkbox" 
                                                name="permission[]" 
                                                class="minimal-red" 
                                                value="{{ $row }}"
                                                {{--  CHECK, JIKA PERMISSION TERSEBUT SUDAH DI SET, MAKA CHECKED --}}
                                                {{ in_array($row, $hasPermission) ? 'checked':'' }}
                                                > {{ $row }} <br>
                                            @if ($no++%4 == 0)
                                            <br>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="pull-right">
                            <button class="btn btn-primary btn-sm">
                                <i class="fa fa-send"></i> Set Permission
                            </button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>         
</div>              
@endsection
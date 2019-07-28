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
            <div class="col-md-5">
                <div class="metric">
                    <h2 class="panel-title">Tambah Data</h2><br>
                    <form role="form" action="{{ route('role.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tambah Role</label>
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
                    <a href="{{route('category.trash')}}" class="btn btn-default pull-right">Trash Data</a>
                    <br><br><br>                    
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <td>WK</td>
                                <td>Role</td>
                                <td>Guard</td>
                                <td>Created At</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        <tbody>
                            @foreach ($role as $item)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->guard_name }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <a href="{{route('role.edit', $item->id)}}" class="btn btn-light"><i class="fa fa-pencil"></i> <span>Edit</span></a>
                                    <a href="javascript:void(0)" onclick="$(this).find('form').submit()" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete
                                        <form method="POST" action={{route('role.destroy',$item->id) }}  onsubmit="return confirm('Delete this category temporarily?')"
                                      </a>
                                      @csrf
                                      @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @php
                                $no++;
                            @endphp
                            @endforeach
                        </tbody>
                        
                        </table>
                        {{$role->appends(Request::all())->links()}}
                </div>
            </div>
        </div>
    </div>         
</div>              
@endsection
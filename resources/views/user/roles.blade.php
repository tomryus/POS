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
            <div class="col-md-6">
                <div class="metric">
                    <h2 class="panel-title">Tambah Role</h2><br>
                    <form action="{{ route('user.set_role', $user->id) }}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <td>:</td>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>:</td>
                                        <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                    </tr>
                                    <tr>
                                        <th>Role</th>
                                        <td>:</td>
                                        <td>
                                            @foreach ($roles as $row)
                                            <input type="radio" name="role" 
                                                {{ $user->hasRole($row) ? 'checked':'' }}
                                                value="{{ $row }}"> {{  $row }} <br>
                                            @endforeach
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm float-right">
                                    Set Role
                                </button>
                            </div>
                     </form>

                </div>
            </div>
                    
        
        </div>
    </div>         
</div>              
@endsection
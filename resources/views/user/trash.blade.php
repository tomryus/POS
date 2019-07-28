@extends('layouts.master')
@section('title','List User')

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
                    @php
                        $dt = new DateTime();
                        $dt->setTimeZone(new DateTimeZone('Asia/Bangkok'));
                    @endphp
                    <h3>List Trash User</h3><br>
                    {{$dt->format('Y-m-d H:i:s')}}
                    @if(session('status'))
                    <div class="alert alert-success" >
                          {{session('status')}}
                    </div>
                    @endif
                    <br>
                    
                    <a href="{{route('user.index')}}" class="btn btn-default pull-right"> Data</a>
                    <br><br><br>                    
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <td>NO</td>
                                <td>Nama</td>
                                <td>Email</td>
                                <td>Role</td>
                                <td>Status</td>
                                <td>Verified</td>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        <tbody>
                            @foreach ($user as $item)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->email}}</td>
                                <td>@foreach ($item->getRoleNames() as $role)
                                    <label for="" class="badge badge-info">{{ $role }}</label>
                                    @endforeach
                                </td>
                                <td>@if ($item->status)
                                    <label class="badge badge-success">Aktif</label>
                                    @else
                                    <label for="" class="badge badge-default">Suspend</label>
                                    @endif
                                </td>
                                <td>{{$item->email_verified_at}}</td>
                                <td>
                                    <a href="{{route('user.restore', $item->id)}}" class="btn btn-light"><i class="fa fa-pencil"></i> <span>Restore</span></a>
                                    <a href="javascript:void(0)" onclick="$(this).find('form').submit()" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete Permanent
                                        <form method="POST" action={{route('user.deletepermanent',$item->id) }}  onsubmit="return confirm('Delete this category permanently?')"
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
                        {{$user->appends(Request::all())->links()}}
                </div>
            </div>
        </div>
    </div>         
</div>              
@endsection
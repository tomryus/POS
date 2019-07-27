@extends('layouts.master')
@section('title','List Category')

@section('content')
<div class="container-fluid">
        
    <div class="panel panel-headline">
        <div class="panel-heading">
            <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Manajemen Kategori</h1>
                    </div>
                    <br>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Kategori</li>
                        </ol>
                    </div>
                </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="row">
            
            <div class="col-md-8">
                <div class="metric">
                    @if(session('status'))
                    <div class="alert alert-success" >
                          {{session('status')}}
                    </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>NO</td>
                                <td>Nama</td>
                                <td>Deskripsi</td>
                                <td>Delete At</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        <tbody>
                            @foreach ($categories as $item)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->description}}</td>
                                <td>{{$item->deleted_at}}</td>
                                
                                <td>
                                    <a href="{{route('category.restore', $item->id)}}" class="btn btn-light"><i class="fa fa-pencil"></i> <span>Restore</span></a>
                                    <a href="javascript:void(0)" onclick="$(this).find('form').submit()" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete Permanent
                                    <form method="POST" action={{route('category.deletepermanent',$item->id) }}  onsubmit="return confirm('Delete this category Permanent?')"
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
                </div>
            </div>
        </div>
    </div>         
</div>              
@endsection
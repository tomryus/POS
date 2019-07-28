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
                    @php
                        $dt = new DateTime();
                        $dt->setTimeZone(new DateTimeZone('Asia/Bangkok'));
                    @endphp
                    <h3>Trash data</h3><br>
                    {{$dt->format('Y-m-d H:i:s')}}
                    @if(session('status'))
                    <div class="alert alert-success" >
                          {{session('status')}}
                    </div>
                    @endif
                    <br>
                    <a href="{{route('product.index')}}" class="btn btn-default pull-right">Data</a>
                    <br><br><br>                    
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <td>NO</td>
                                <th>Nama Produk</th>
                                <th>Deskripsi</th>
                                <th>Stock</th>
                                <th>Harga</th>
                                <th>Category</th>
                                <th>Tanggal</th>
                                <th>Foto</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        <tbody>
                            @foreach ($product as $item)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->description}}</td>
                                <td>{{$item->stock}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->category->name}}</td>
                                <td>{{$item->updated_at}}</td>
                                <td><img src={{asset('storage/product/' .$item->photo)}} width="150"></td>
                                <td>
                                    <a href="{{route('product.restore', $item->id)}}" class="btn btn-light"><i class="fa fa-pencil"></i> <span>Restore</span></a>
                                    <a href="javascript:void(0)" onclick="$(this).find('form').submit()" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete Permanent
                                        <form method="POST" action={{route('product.deletepermanent',$item->id) }}  onsubmit="return confirm('Delete this category permanently?')"
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
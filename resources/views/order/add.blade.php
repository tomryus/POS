@extends('layouts.master')
@section('title','Add Order')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

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
                            <li class="breadcrumb-item active"><a href="{{route('order.create')}}">Order</a></li>
                        </ol>
                    </div>
                </div>
        </div>
    </div>

    <section class="content" id="pos">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <div class="metric">
                    <h2 class="panel-title">Tambah Data</h2><br>
                    <form action="#" @submit.prevent="addToCart" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="product_id">Product</label>
                            <select name="product_id" id="product_id" v-model="cart.product_id" class="form-control {{ $errors->has('product_id') ? 'is-invalid':'' }}" id="product_id" required>
                            <option>Pilih Category </option>
                            @foreach ($product as $item)
                                <option value="{{$item->id}}">{{$item->code. '-' .$item->name}}</option>
                            @endforeach
                            </select>
                            <div class="invalid-feedback">
                                {{$errors->first('product_id')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="qty">Quantity</label>
                            <input type="text" name="qty"  v-model="cart.qty" class="form-control {{ $errors->has('qty') ? 'is-invalid':'' }}" id="qty" required>
                            <div class="invalid-feedback">
                                {{$errors->first('qty')}}
                            </div>
                        </div>                       
                        <div>
                            <button class="btn btn-primary btn-sm"
                                :disabled="submitCart"
                                >
                                <i class="fa fa-shopping-cart"></i> @{{ submitCart ? 'Loading...':'Ke Keranjang' }}
                            </button>
                        </div>
                        </form>
                </div>
            </div>
                    
            <div class="col-md-3">
                <div class="metric">
                    @php
                        $dt = new DateTime();
                        $dt->setTimeZone(new DateTimeZone('Asia/Bangkok'));
                    @endphp
                    <h3>Detail Product</h3><br>
                    {{$dt->format('Y-m-d H:i:s')}}
                    @if(session('status'))
                    <div class="alert alert-success" >
                          {{session('status')}}
                    </div>
                    @endif
                    <div v-if="product.name">
                        <table class="table table-stripped">
                            <tr>
                                <th>Kode</th>
                                <td>:</td>
                                <td>@{{ product.code }}</td>
                            </tr>
                            <tr>
                                <th width="3%">Produk</th>
                                <td width="2%">:</td>
                                <td>@{{ product.name }}</td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td>:</td>
                                <td>@{{ product.price | currency }}</td>
                            </tr>
                        </table>
                    </div>        
                    </div>
            </div>
            <div class="col-md-2" v-if="product.photo">
                <div class="metric">
                <img :src="'/storage/product/' + product.photo" 
                    height="150px" 
                    width="150px" 
                    :alt="product.name">
            </div>
            </div>
            <div class="col-md-4">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- MENGGUNAKAN LOOPING VUEJS -->
                        <tr v-for="(row, index) in shoppingCart">
                            <td>@{{ row.name }} (@{{ row.code }})</td>
                            <td>@{{ row.price | currency }}</td>
                            <td>@{{ row.qty }}</td>
                            <td>
                                <!-- EVENT ONCLICK UNTUK MENGHAPUS CART -->
                                <button 
                                    @click.prevent="removeCart(index)"    
                                    class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="card-footer text-muted">
                    <a href="" 
                        class="btn btn-info btn-sm float-right">
                        Checkout
                    </a>
                </div>
                
            </div>
            
        </div>
    </div> 
    </section>        
</div>              
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/accounting.js/0.4.1/accounting.min.js"></script>
    <script src="{{ asset('js/transaksi.js') }}"></script>
@endsection

@extends('layouts.master')
@section('title','Check Out')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

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
                            <li class="breadcrumb-item"><a href="#">Order</a></li>
                            <li class="breadcrumb-item active"><a href="#">Checkout</a></li>
                        </ol>
                    </div>
                </div>
        </div>
    </div>
    <section class="content" id="pos">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-8">
                <div class="metric">
                    @php
                        $dt = new DateTime();
                        $dt->setTimeZone(new DateTimeZone('Asia/Bangkok'));
                    @endphp
                    <h3>Data Pelanggan</h3><br>
                    {{$dt->format('Y-m-d H:i:s')}}
                    @if(session('status'))
                    <div class="alert alert-success" >
                          {{session('status')}}
                    </div>
                    @endif
                    <br>
                    <div v-if="message" class="alert alert-success">
                        Transaksi telah disimpan, Invoice: <strong>#@{{ message }}</strong>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" name="email" 
                            v-model="customer.email"
                            class="form-control" 
                            @keyup.enter.prevent="searchCustomer"
                            required
                            >
                        <p>Tekan enter untuk mengecek email.</p>
                        <!-- EVENT KETIKA TOMBOL ENTER DITEKAN, MAKA AKAN MEMANGGIL METHOD searchCustomer dari Vuejs -->
                    </div>
                    <div v-if="formCustomer">
                        <div class="form-group">
                            <label for="">Nama Pelanggan</label>
                            <input type="text" name="name" 
                                v-model="customer.name"
                                :disabled="resultStatus"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea name="address"
                                class="form-control"
                                :disabled="resultStatus"
                                v-model="customer.address"
                                cols="5" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">No Telp</label>
                            <input type="number" name="phone" 
                                v-model="customer.phone"
                                :disabled="resultStatus"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        <!-- JIKA VALUE DARI errorMessage ada, maka alert danger akan ditampilkan -->
                        <div v-if="errorMessage" class="alert alert-danger">
                            @{{ errorMessage }}
                        </div>
                        <!-- JIKA TOMBOL DITEKAN MAKA AKAN MEMANGGIL METHOD sendOrder -->
                        <button class="btn btn-primary btn-sm float-right"
                            :disabled="submitForm"  
                            @click.prevent="sendOrder"
                            >
                            @{{ submitForm ? 'Loading...':'Order Now' }}
                        </button>
                    </div>
                </div>
            </div>
            @include('order.cart')
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
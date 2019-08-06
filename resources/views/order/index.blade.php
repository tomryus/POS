@extends('layouts.master')
@section('title','List Order')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/daterangepicker/daterangepicker-bs3.css') }}">
 @endsection

@section('content')
<table class="container-fluid">
        
    <div class="panel panel-headline">
        <div class="panel-heading">
            <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Manajemen Order</h1>
                    </div>
                    <br>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('order.index')}}">order</a></li>
                        </ol>
                    </div>
                </div>
        </div>
    </div>
    
    <section class="content" id="pos">
    <div class="panel-body">
        <div class="row">
           
        <div class="col-md-12">
                <div class="metric">
                    @php
                        $dt = new DateTime();
                        $dt->setTimeZone(new DateTimeZone('Asia/Bangkok'));
                    @endphp
                    
                    {{$dt->format('Y-m-d H:i:s')}}
                    <br>
                    @if(session('status'))
                    <div class="alert alert-success" >
                          {{session('status')}}
                    </div>
                    @endif
                    <br>
                    <div class="col-md-12">
                            <form action="{{ route('order.index') }}" method="get">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Mulai Tanggal</label>
                                            <input type="text" name="start_date" 
                                                class="form-control {{ $errors->has('start_date') ? 'is-invalid':'' }}"
                                                id="start_date"
                                                value="{{ request()->get('start_date') }}"
                                                >
                                        </div>
                                        <div class="form-group">
                                            <label for="">Sampai Tanggal</label>
                                            <input type="text" name="end_date" 
                                                class="form-control {{ $errors->has('end_date') ? 'is-invalid':'' }}"
                                                id="end_date"
                                                value="{{ request()->get('end_date') }}">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-sm">Cari</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Pelanggan</label>
                                            <select name="customer_id" class="form-control">
                                                <option value="">Pilih</option>
                                                @foreach ($customer as $cust)
                                                <option value="{{ $cust->id }}"
                                                    {{ request()->get('customer_id') == $cust->id ? 'selected':'' }}>
                                                    {{ $cust->name }} - {{ $cust->email }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Kasir</label>
                                            <select name="user_id" class="form-control">
                                                <option value="">Pilih</option>
                                                @foreach ($user as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ request()->get('user_id') == $item->id ? 'selected':'' }}>
                                                    {{ $item->name }} - {{ $item->email }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    </div>                  
                
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-cart"></i></span>
                    <p>
                        <span class="number">{{ $sold }}</span>
                        <span class="title">Item terjual</span>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-shopping-bag"></i></span>
                    <p>
                        <span class="number">Rp {{ number_format($total) }}</span>
                        <span class="title">Omset</span>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-eye"></i></span>
                    <p>
                        <span class="number">{{ $total_customer }}</span>
                        <span class="title">Total Pelanggan</span>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-bar-chart"></i></span>
                    <p>
                        <span class="number">35%</span>
                        <span class="title">Conversions</span>
                    </p>
                </div>
            </div>
        </div>
        <table class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Pelanggan</th>
                        <th>No Telp</th>
                        <th>Total Belanja</th>
                        <th>Kasir</th>
                        <th>Tgl Transaksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- LOOPING MENGGUNAKAN FORELSE, DIRECTIVE DI LARAVEL 5.6 -->
                    @forelse ($order as $row)
                    <tr>
                        <td><strong>#{{ $row->invoice }}</strong></td>
                        <td>{{ $row->customer->name }}</td>
                        <td>{{ $row->customer->phone }}</td>
                        <td>Rp {{ number_format($row->total) }}</td>
                        <td>{{ $row->user->name }}</td>
                        <td>{{ $row->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>
                            <a href="{{ route('order.pdf', $row->invoice) }}" 
                                target="_blank"
                                class="btn btn-primary btn-sm">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="{{ route('order.excel', $row->invoice) }}" 
                                target="_blank"
                                class="btn btn-info btn-sm">
                                <i class="fa fa-file-excel-o"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="7">Tidak ada data transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </table>
    </table> 
    </section>        
</table>              
@endsection

@section('js')
    <script src="{{ asset('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/datepicker/bootstrap-datepicker.js') }}"></script>
    <script>
        $('#start_date').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });

        $('#end_date').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
    </script>
@endsection
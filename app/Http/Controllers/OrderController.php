<?php

namespace App\Http\Controllers;

use App\User;
use App\model\Order;
use App\model\Product;
use App\model\Customer;
use Illuminate\Http\Request;
use App\model\Order_detail;
use Cookie;
use DB;
use Carbon\Carbon;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customer = Customer::orderBy('name', 'ASC')->get();
        $user = User::orderBy('name', 'ASC')->get();
        $order = Order::orderBy('created_at', 'DESC')->with('order_detail', 'customer');

        if(!empty($request->customer_id))
        {
            $order = $order->where('customer_id', $request->custumer_id);
        }

        if(!empty($request->user_id))
        {
            $order =$order->where('user_id', $request->user_id);
        }
        
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $this->validate($request, [
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date'
            ]);
            
            
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d') . '00:00:01';
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d') . '23:59:59';

        $order =  $order->whereBetween('created_at',[$start_date,$end_date]);
        }else {
            
            $order= $order->take(10)->skip(0)->get();
        }

        return view('order.index', [
            'order' => $order,
            'sold' => $this->countItem($order),
            'total' => $this->countTotal($order),
            'total_customer' => $this->countCustomer($order),
            'customer' => $customer,
            'user' => $user
        ]);
    }
    public function countItem($order)
    {
        $items = [];

        if($order->count() != 0)
        {
            foreach($order as $item){
                $qty = $item->order_detail->pluck('qty')->all();
                $val = array_sum($qty);
    
                $items =+ $val;
            }
        }
        return $items;        
    }
    public function CountTotal($order)
    {
        $items = 0 ;
        if($order->count() != 0)
        {

                $total  = $order->pluck('total')->all();
                $items    = array_sum($total);
                
            
        }
        return $items;
        
    }
    public function countCustomer($order)
    {
        $items = [];
        if($order->count() > 0)
        {
            foreach($order as $item){
                $items[] = $item->customer->email;
                
            }
        }
        return count(array_unique($items));  
    }
    public function invoicePdf()
    {

    }
    public function invoiceexcel()
    {

    }
        

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = Product::orderBy('created_at', 'DESC')->get();
        return view('order.add', compact('product'));
    }
    
    public function getProduct($id)
    {
        $products = Product::findOrFail($id);
        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\model\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\model\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\model\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\model\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
    public function addToCart(Request $request)
    {
        //validasi data yang diterima
        //dari ajax request addToCart mengirimkan product_id dan qty
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer'
        ]);
    
     
        //mengambil data product berdasarkan id
        $product = Product::findOrFail($request->product_id);
        //mengambil cookie cart dengan $request->cookie('cart')
        $getCart = json_decode($request->cookie('cart'), true);
        //jika datanya ada
        if ($getCart) {
            //jika key nya exists berdasarkan product_id
            if (array_key_exists($request->product_id, $getCart)) {
                //jumlahkan qty barangnya
                $getCart[$request->product_id]['qty'] += $request->qty;
                //dikirim kembali untuk disimpan ke cookie
                return response()->json($getCart, 200)
                    ->cookie('cart', json_encode($getCart), 120);
            } 
        }
    
     
        //jika cart kosong, maka tambahkan cart baru
        $getCart[$request->product_id] = [
            'code' => $product->code,
            'name' => $product->name,
            'price' => $product->price,
            'qty' => $request->qty
        ];
        //kirim responsenya kemudian simpan ke cookie
        return response()->json($getCart, 200)
            ->cookie('cart', json_encode($getCart), 120);
    }
    public function getCart()
    {
        //mengambil cart dari cookie
        $cart = json_decode(request()->cookie('cart'), true);
        //mengirimkan kembali dalam bentuk json untuk ditampilkan dengan vuejs
        return response()->json($cart, 200);
    }

    public function removeCart($id)
    {
        $cart = json_decode(request()->cookie('cart'), true);
        //menghapus cart berdasarkan product_id
        unset($cart[$id]);
        //cart diperbaharui
        return response()->json($cart, 200)->cookie('cart', json_encode($cart), 120);
    }
    public function checkout()
    {
        return view('order.checkout');
    }
    public function storeOrder(Request $request)
    {
        //validasi 
        $this->validate($request, [
            'email' => 'required|email',
            'name' => 'required|string|max:100',
            'address' => 'required',
            'phone' => 'required|numeric'
        ]);
    
     
        //mengambil list cart dari cookie
        $cart = json_decode($request->cookie('cart'), true);
        //memanipulasi array untuk menciptakan key baru yakni result dari hasil perkalian price * qty
        $result = collect($cart)->map(function($value) {
            return [
                'code' => $value['code'],
                'name' => $value['name'],
                'qty' => $value['qty'],
                'price' => $value['price'],
                'result' => $value['price'] * $value['qty']
            ];
        })->all();
    
     
        //database transaction
        DB::beginTransaction();
        try {
            //menyimpan data ke table customers
            $customer = Customer::firstOrCreate(
                [
                    'email' => $request->email
                ],
                [
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone' => $request->phone
                ]
                );
    
     
            //menyimpan data ke table orders
            $order = Order::create([
                'invoice' => $this->generateInvoice(),
                'customer_id' => $customer->id,
                'user_id' => auth()->user()->id,
                'total' => array_sum(array_column($result, 'result'))
                //array_sum untuk menjumlahkan value dari result
            ]);
    
     
            //looping cart untuk disimpan ke table order_details
            foreach ($result as $key => $row) {
                $order->order_detail()->create([
                    'product_id' => $key,
                    'qty' => $row['qty'],
                    'price' => $row['price']
                ]);
            }
            //apabila tidak terjadi error, penyimpanan diverifikasi
            DB::commit();
            
     
            //me-return status dan message berupa code invoice, dan menghapus cookie
            return response()->json([
                'status' => 'success',
                'message' => $order->invoice,
            ], 200)->cookie(Cookie::forget('cart'));
        } catch (\Exception $e) {
            //jika ada error, maka akan dirollback sehingga tidak ada data yang tersimpan 
            DB::rollback();
            //pesan gagal akan di-return
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }
    public function generateInvoice()
    {
        //mengambil data dari table orders
        $order = Order::orderBy('created_at', 'DESC');
        //jika sudah terdapat records
        if ($order->count() > 0) {
            //mengambil data pertama yang sdh dishort DESC
            $order = $order->first();
            //explode invoice untuk mendapatkan angkanya
            $explode = explode('-', $order->invoice);
            //angka dari hasil explode di +1
            return 'INV-' . $explode[1] + 1;
        }
        //jika belum terdapat records maka akan me-return INV-1
        return 'INV-1';
    }
}

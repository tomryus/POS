<?php

namespace App\Http\Controllers;

use App\model\Product;
use App\model\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use File;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    public function index()
    {
        $product = Product::with('category')->paginate(5);

        return view('product/index',['product'=>$product]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        return view('product/add',['categories' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Validator::make($request->all(),[
            'code' => 'required|string|max:10|unique:products',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:100',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg'
        ])->validate();

            $photo = null;
           //jika terdapat file (Foto / Gambar) yang dikirim
            if ($request->hasFile('photo')) {
                //maka menjalankan method saveFile()
                $photo = $this->saveFile($request->name, $request->file('photo'));
            }
        

        Product::create([
            'code'          => $request->code,
            'name'          => $request->name,
            'description'   => $request->description,
            'stock'         => $request->stock,
            'price'         => $request->price,
            'category_id'   => $request->category_id,
            'photo'         => $photo
        ]);
        return redirect()->route('product.index')->with('status','data berhasil ditambah');
       
        
    }
    private function saveFile($name, $photo)
    {
        //set nama file adalah gabungan antara nama produk dan time(). Ekstensi gambar tetap dipertahankan
        $images = str_slug($name) . time() . '.' . $photo->getClientOriginalExtension();
        //set path untuk menyimpan gambar
        
        $path = public_path('storage/product');
        //cek jika uploads/product bukan direktori / folder
        if(!File::isDirectory($path)) {
            //maka folder tersebut dibuat
            File::makeDirectory($path, 0777, true, true);
        } 
        //simpan gambar yang diuplaod ke folrder uploads/produk
        Image::make($photo)->save($path . '/' . $images);
        //mengembalikan nama file yang ditampung divariable $images
        return $images;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $category = Category::all();
        return view('product/edit',['categories'=>$category,'product'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        \Validator::make($request->all(),[
            'code' => 'required|string|max:10|unique:products',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:100',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg'
        ])->validate();

        $photo = $product->photo;

        //cek jika ada file yang dikirim dari form
        if ($request->hasFile('photo')) {
            //cek, jika photo tidak kosong maka file yang ada di folder uploads/product akan dihapus
            !empty($photo) ? File::delete(public_path('storage/product/' . $photo)):null;
            //uploading file dengan menggunakan method saveFile() yg telah dibuat sebelumnya
            $photo = $this->saveFile($request->name, $request->file('photo'));
        }

        $product->update([
            'name'              => $request->name,
            'description'       => $request->description,
            'stock'             => $request->stock,
            'price'             => $request->price,
            'category_id'       => $request->category_id,
            'photo'             => $photo
        ]);

        return redirect()->route('product.index')->with('status','data berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('status','data berhasil dihapus');
    }

    public function trash()
    {   
        $product = Product::onlyTrashed()->get();
        return view('product/trash',['product'=>$product]);
    }
    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('product.index')->with('status','data berhasil dikembalikan');
    }
    public function deletepermanent($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        if (!empty($product->photo)) {
            //file akan dihapus dari folder uploads/produk
            File::delete(public_path('storage/product/' . $product->photo));
        }
        //hapus data dari table
        $product->delete();
        $product->forceDelete();
        return redirect()->route('product.index')->with('status','data berhasil dihapus permanent');
    }
}

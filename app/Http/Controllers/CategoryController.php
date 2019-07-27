<?php

namespace App\Http\Controllers;

use App\model\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        
        $category = Category::paginate(8);


        return view('category/index',['categories' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'name' => "required|min:4|Unique:categories",
        ])->validate();
        
        Category::create([
            'name'          => $request->name,
            'description'   => $request->description
        ]);

        return redirect()->route('category.index')->with('status','data berhasil ditambah');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('category/edit',['category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        \Validator::make($request->all(),[
            'name' => "required|min:4|Unique:categories",
            'description'   => "required|string",
        ])->validate();
        $category->update([
            'name'          => $request->name,
            'description'   => $request->description
        ]);

        return redirect()->route('category.index')->with('status','data berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->Delete();
        return redirect()->route('category.index')->with('status','data berhasil dihapus ke temporary');
    }

    public function trash()
    {
        $category = Category::onlyTrashed()->get();
        return view('category/trash',['categories'=>$category]);
    }
    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('category.index')->with('status','data berhasil dikembalikan');
    }
    public function deletepermanent($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()->route('category.index')->with('status','data berhasil dihapus permanent');
    }
}

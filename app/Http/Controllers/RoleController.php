<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::orderBy('created_at', 'DESC')->paginate(10);
        return view('role.index', compact('role'));
    }
    public function store(request $request)
    {
        \Validator::make($request->all(),[
            'name' => "required|min:4|Unique:categories",
        ])->validate();
        Role::firstOrCreate([
            'name' => $request->name
        ]);
        return redirect()->route('role.index')->with('status','data role berhasil ditambah');

    }
    public function edit(Role $role)
    {
        return view('role/edit',compact['role']);
    }
    public function update(Role $role)
    {
        \Validator::make($request->all(),[
            'name' => "required|min:4|Unique:categories",
        ])->validate();
        $role->update([
            'name' => $request->name
        ]);
        return redirect()->route('role.index')->with('status','data role berhasil ditambah');
    }
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('role.index')->with('status','data role berhasil dihapus');
    }
}

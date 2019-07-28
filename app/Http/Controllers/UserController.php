<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use DB;

class UserController extends Controller
{
    public function index()
    {
        $user = User::orderBy('created_at', 'DESC')->paginate(10);
        return view('user/index',['user'=>$user]);
    }
    public function create()
    {
        $role = Role::orderBy('name', 'ASC')->get();
        return view('user/add',['role'=>$role]);
    }
    public function store(request $request)
    {
        \Validator::make($request->all(),[
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8',
            'cpassword' => 'required_with:password|same:password|min:8',
            'role'      => 'required|string|exists:roles,name'
        ])->validate();

        $user = User::firstOrCreate([
            'email'         => $request->email
        ], 
        [
            'name'          => $request->name,
            'password'      => bcrypt($request->password),
            'status'        => true
        ]);
        $user->assignRole($request->role);
        return redirect()->route('user.index')->with('status','data berhasil ditambah');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }
    public function update(request $request,$id)
    {
        \Validator::make($request->all(),[
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6',
            ])->validate();

            $user = User::findOrFail($id);
            $password = !empty($request->password) ? bcrypt($request->password):$user->password;
            $user->update([
                'name' => $request->name,
                'password' => $password
            ]);
            return redirect()->route('user.index')->with('status','data berhasil diedit');

    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('status','data berhasil dihapus');
    }
    public function trash()
    {
        $user = User::onlyTrashed()->paginate(10);
        return view('user/trash',['user'=>$user]);
    }
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('user.index')->with('status','data berhasil dikembalikan');

    }
    public function deletepermanent($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->route('user.index')->with('status','data berhasil dikembalikan');

    }
    public function rolePermission(Request $request)
    {
        $role = $request->get('role');
        
        //Default, set dua buah variable dengan nilai null
        $permissions = null;
        $hasPermission = null;
        
        //Mengambil data role
        $roles = Role::all()->pluck('name');
        
        //apabila parameter role terpenuhi
        if (!empty($role)) {
            //select role berdasarkan namenya, ini sejenis dengan method find()
            $getRole = Role::findByName($role);
            
            //Query untuk mengambil permission yang telah dimiliki oleh role terkait
            $hasPermission = DB::table('role_has_permissions')
                ->select('permissions.name')
                ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where('role_id', $getRole->id)->get()->pluck('name')->all();
            
            //Mengambil data permission
            $permissions = Permission::all()->pluck('name');
        }
        return view('user.role_permission', compact('roles', 'permissions', 'hasPermission'));
    }
    public function addPermission(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:permissions'
        ]);

        $permission = Permission::firstOrCreate([
            'name' => $request->name
        ]);
        return redirect()->back()->with('status','role ditambahkan');
    }
    public function setRolePermission(Request $request, $role)
    {
        //select role berdasarkan namanya
        $role = Role::findByName($role);
        
        //fungsi syncPermission akan menghapus semua permissio yg dimiliki role tersebut
        //kemudian di-assign kembali sehingga tidak terjadi duplicate data
        $role->syncPermissions($request->permission);
        return redirect()->back()->with('status','data berhasil diupdate');
    }
    public function roles(Request $request, $id)
    {
        $user = User::find($id);
        $roles = Role::all()->pluck('name');
        return view('user.roles', compact('user', 'roles'));
    }
    public function setRole(Request $request, $id)
    {
        $this->validate($request, [
            'role' => 'required'
        ]);
        $user = User::findOrFail($id);
        //menggunakan syncRoles agar terlebih dahulu menghapus semua role yang dimiliki
        //kemudian di-set kembali agar tidak terjadi duplicate
        $user->syncRoles($request->role);
        return redirect()->route('user.index')->with('status','Role Sudah Di Set');
    }

}

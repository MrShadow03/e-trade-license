<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;

class AdminController extends Controller{
    public function index(){
        return view('admin.pages.admins.index', [
            'admins' => Admin::all(),
            'roles' => Role::select('id', 'name')->where('guard_name', 'admin')->get(),
        ]);
    }

    public function store(AdminStoreRequest $request){
        $admin = Admin::create([
            ...$request->validated(),
            'password' => 'pass@bcc'.$request->phone,
        ]);

        $admin->syncRoles([$request->role]);

        $imagePath = Helpers::resizeImage();

        $admin->addMedia($imagePath)->toMediaCollection('dp');

        return redirect()->route('admin.admins');
    }

    public function update(AdminUpdateRequest $request, Admin $admin){
        $admin->update($request->validated());

        $admin->syncRoles([$request->role]);

        return redirect()->route('admin.admins');
    }
}

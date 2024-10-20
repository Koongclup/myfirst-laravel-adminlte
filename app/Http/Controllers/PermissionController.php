<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    // Display a listing of the permissions
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function($row) {
                    $editUrl = route('admin.permission.edit', encrypt($row->id));
                    $deleteUrl = route('admin.permission.destroy', encrypt($row->id));
                    return '<button class="btn btn-sm btn-secondary editPermission" data-id="'.encrypt($row->id).'">
                                <i class="far fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger deletePermission" data-url="'.$deleteUrl.'">
                                <i class="fas fa-trash-alt"></i>
                            </button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.permission.index');
    }

    // Store a newly created permission in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions|max:255',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return response()->json(['success' => 'Permission created successfully.']);
    }


    public function show($id)
    {
        $permission = Permission::findOrFail(decrypt($id));
        return response()->json($permission);
    }

    // Show the specified permission
    public function edit($id)
    {
        $permission = Permission::findOrFail(decrypt($id));
        return response()->json($permission);
    }

    // Update the specified permission in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . decrypt($id),
        ]);

        Permission::where('id', decrypt($id))->update([
            'name' => $request->name,
        ]);

        return response()->json(['success' => 'Permission updated successfully.']);
    }

    // Remove the specified permission from storage
    public function destroy($id)
    {
        Permission::where('id', decrypt($id))->delete();
        return response()->json(['success' => 'Permission deleted successfully.']);
    }
}

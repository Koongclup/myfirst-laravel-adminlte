<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $roles = Role::all();
        view()->share('roles', $roles);
        
        $modes = Mode::all();
        view()->share('modes', $modes);
    }

    /**
     * Get the user data for DataTables.
     */
    public function getUsersData(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select(['id', 'name', 'email', 'role', 'mode', 'created_at']);
            return DataTables::of($users)
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-sm btn-primary edit-btn " data-id="' . $row->id . '"><i class="fa fa-edit"></i></button>
                            <form method="POST" action="' . route('admin.users.destroy', $row->id) . '" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-sm delete-btn"> <i class="fa fa-trash"></i></button>
                            </form>';
                })
                ->make(true);
        }
    }

    /**
     * Display the list of users and charts.
     */
    public function index()
    {
        // Group users by role for pie chart
        $roles = User::select('role', \DB::raw('count(*) as total'))
                     ->groupBy('role')
                     ->get();
                     
        $roleData = $roles->map(function($role) {
            return [
                'name' => $role->role,
                'y' => $role->total
            ];
        });

        // Group users by mode for column chart
        $modes = User::select('mode', \DB::raw('count(*) as total'))
                     ->groupBy('mode')
                     ->get();

        $modeCategories = $modes->pluck('mode')->toArray();
        $modeData = $modes->pluck('total')->toArray();

        return view('admin.user.index', [
            'roleData' => $roleData,
            'modeCategories' => $modeCategories,
            'modeData' => $modeData
        ]);
    }

    /**
     * Show the form to create a new user.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a new user in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|max:255|min:6',
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);
        $user->assignRole($request->role);
        return redirect()->route('admin.user.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user); // Return user data as JSON
    }

    /**
     * Update the specified user in the database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string|max:50',
            'mode' => 'required|string|max:50',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->mode = $request->mode;
        $user->save();

        return response()->json(['message' => 'User updated successfully!']);
    }

    /**
     * Update user via page request (for form submissions).
     */
    public function updatepage(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'string'],
            'mode' => ['required', 'string'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $user->syncRoles($request->role); // Sync roles
        return redirect()->route('admin.user.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from the database.
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}

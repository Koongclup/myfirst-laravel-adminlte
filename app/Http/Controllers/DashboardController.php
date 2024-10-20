<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Count data
        $userCount = User::count();
        $categoryCount = Category::count();
        $productCount = Product::count();
        $collectionCount = Collection::count();

        // Group users by role for the pie chart
        $roles = User::select('role', \DB::raw('count(*) as total'))
                     ->groupBy('role')
                     ->get();

        $roleData = $roles->map(function($role) {
            return [
                'name' => ucfirst($role->role), // Capitalize role name
                'y' => $role->total
            ];
        })->toArray();

        // Group users by mode for the column chart
        $modes = User::select('mode', \DB::raw('count(*) as total'))
                     ->groupBy('mode')
                     ->get();

        $modeCategories = $modes->pluck('mode')->toArray();
        $modeData = $modes->pluck('total')->toArray();

        // Pass data to the view
        return view('admin.dashboard', compact('userCount', 'categoryCount', 'productCount', 'collectionCount', 'roleData', 'modeCategories', 'modeData'));
    }
}

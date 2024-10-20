<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dashboard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $user = User::count();
        view()->share('user',$user);
        
        $category = Category::count();
        view()->share('category',$category);
        
        $product = Product::count();
        view()->share('product',$product);
        
        $collection = Collection::count();
        view()->share('collection',$collection);

        
    }

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
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard');
    }
}

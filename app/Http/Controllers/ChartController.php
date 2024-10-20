<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class ChartController extends Controller
{
    public function getChartData(): JsonResponse
    {
        // Fetch user role data
        $roles = User::select('role', \DB::raw('count(*) as total'))
                     ->groupBy('role')
                     ->get();

        $roleData = $roles->map(function($role) {
            return [
                'name' => ucfirst($role->role), // Capitalize role name
                'y' => $role->total
            ];
        })->toArray();

        // Fetch user mode data
        $modes = User::select('mode', \DB::raw('count(*) as total'))
                     ->groupBy('mode')
                     ->get();

        $modeCategories = $modes->pluck('mode')->toArray();
        $modeData = $modes->pluck('total')->toArray();

        return response()->json([
            'roleData' => $roleData,
            'modeCategories' => $modeCategories,
            'modeData' => $modeData
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Mode;
use Illuminate\Http\Request;

class ModeController extends Controller
{
    public function index()
    {
        $modes = Mode::all();
        return view('admin.mode.index', compact('modes'));
    }

    public function create()
    {
        return view('admin.mode.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:modes,name',
        ]);

        Mode::create($request->all());
        return redirect()->route('admin.mode.index')->with('success', 'Mode created successfully.');
    }

    public function edit($id)
    {
        $mode = Mode::findOrFail($id);
        return response()->json($mode);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:modes,name,' . $id,
        ]);

        $mode = Mode::findOrFail($id);
        $mode->update($request->all());
        return response()->json(['message' => 'Mode updated successfully!']);
    }

    public function destroy($id)
    {
        Mode::destroy($id);
        return redirect()->back()->with('success', 'Mode deleted successfully.');
    }
}

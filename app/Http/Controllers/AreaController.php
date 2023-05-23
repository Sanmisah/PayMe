<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Area::paginate(10);
        return view('areas.index', compact('areas'));
    }

  
    public function create()
    {
        return view('areas.create');
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'area' => 'required|unique:areas,area',
        ]);

        Area::create($request->all());
        return redirect()->route('areas.index')->with('success', 'Area created successfully.');
    }

   
    public function show($id)
    {
        $area = Area::findOrFail($id);
        return view('areas.show', compact('area'));
    }

   
    public function edit($id)
    {
        $area = Area::findOrFail($id);
        return view('areas.edit', compact('area'));
    }

  
    public function update(Request $request, Area $area)
    {
        $request->validate([
            'area' => 'required',
        ]);

        $area->update($request->all());
        return redirect()->route('areas.index')->with('success', 'Area updated successfully.');
    }

   
    public function destroy(Area $area)
    {
        $area->delete();
        return redirect()->route('areas.index')->with('success', 'Area deleted successfully.');
    }
}

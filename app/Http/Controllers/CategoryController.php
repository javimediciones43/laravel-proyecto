<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::all();
    }   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $category = Category::create($request->all());

        return response()->json($category, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Category::findorFail($id);
    } 
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findorFail($id);
        request()->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return response()->json($category, 200);
    }     

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)    
    {
        $category = Category::findorFail($id);        
        return response()->json([
            'message' => 'Categoria borrada correctamente   '
        ]);
    }
}

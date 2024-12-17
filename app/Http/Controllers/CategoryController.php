<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

        Category::create([
            'name' => $request->name,
            'user_id' => Auth::user()->id
        ]);
        toastr()->success('Category Created Successfully');
        return redirect()->route('admin.category.index');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       
        $request->validate([
            'name' => 'required|unique:categories,name,' . $id,
        ]);
    
        $category = Category::findOrFail($id);
    

        $category->update([
            'name' => $request->name
        ]);
    
        toastr()->success('Category Updated Successfully');
    
        return redirect()->route('admin.category.index');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        toastr()->success('Category Deleted Successfully');
    
        return response(['status' => 'success', 'message' => 'Deleted Successfully']);
    }
}

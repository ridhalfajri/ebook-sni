<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('backend.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = ucwords(strtolower(trim($request->name)));
        $category->description = ucfirst(strtolower(trim($request->description)));
        $category->save();
        return response()->json(['message' => 'Success add category.'],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('backend.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $category->name = ucwords(strtolower(trim($request->name)));
        $category->description = ucfirst(strtolower(trim($request->description)));
        $category->save();

        return response()->json(['message' => 'Success update category.'],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->delete()){

            return response()->json(['message' => 'Success delete category.'],200);
        }

        return response()->json(['message' => 'Failed to delete the category. Please try again.'], 500);
    }

    /**
     * Datatable
     */
    public function datatable(Request $request){
        $categories = Category::select('*')->orderBy('name','ASC');
        return DataTables::of($categories)
            ->addColumn('no', '')
            ->addColumn('action', 'backend.category.action')
            ->rawColumns(['action'])
            ->make(true);
    }
}
